<?php

namespace App\Service;

use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Helpers\AuthToken;
use App\Http\Requests\API\EmailRequest;
use Illuminate\Support\Facades\Password;
use App\Helpers\ApiResponse;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

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
}