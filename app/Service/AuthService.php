<?php

namespace App\Service;

use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\AuthToken;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\ModelNotFoundException;    
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\Access\AuthorizationException;
class AuthService
{
    public function registerUserAndPerson(array $validated)
    {
        return DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $person = Person::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            return compact('user', 'person');
        });
    }

    public function checkEmailExists($dataProvider)
    {
        $user = User::where('email', $dataProvider->email ?? $dataProvider['email'])->first();
        if (!$user) {
            throw new ModelNotFoundException();
        }
        return $user;
    }

    public function checkStatus($user)
    {
        if ($user->status == User::STATUS_DEACTIVE) {
            throw new AuthorizationException();
        }
        return $user;
    }

    public function loginUser(array $credentials)
    {
        $user = $this->checkEmailExists($credentials);
        $this->checkStatus($user);
        if (!Hash::check($credentials['password'], $user->password)) {
            throw new UnauthorizedHttpException('');
        }
        
        $token = $this->createAccessToken($user);
        
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function changePassword($user, array $validated) 
    {
        if (!Hash::check($validated['old_password'], $user->password)) {
            throw new UnauthorizedHttpException('');
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();
        return $user;
    }

    public function createAccessToken($user)
    {
        $now = time();
        $exp = $now + 24*3600*config('services.auth.day_expire');

        $payload = [
            "user_id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
            "exp" => $exp,
        ];
        return AuthToken::encodeAccessToken($payload);
    }

    public function sendResetPasswordMail(array $validated)
    {
        return Password::sendResetLink($validated);
    }

    public function resetPassword(array $validated)
    {
        return Password::reset(
            $validated,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );
    }

    public function registerMutilsPerson(array $validated)
    {
        return $this->registerUserAndPerson($validated);
    }

    public function deleteAccount($id)
    {
       return User::find($id)->delete();    
    }
}