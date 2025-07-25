<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Person;
use App\Helpers\LogHelper;

class UserObserver
{

    public function creating(User $user)
    {
        //
    }

    public function created(User $user)
    {
       Person::create([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'status' => User::STATUS_ACTIVE,
       ]);   
    }

    public function updated(User $user)
    {
        if ($user->wasChanged('deleted_at')) {
            return;
        }
        if ($user->wasChanged('status')) {
            $user->person()->update(['status' => $user->status]);
        }
        LogHelper::Log('updated', 'User', $user->id);
    }

    public function deleted(User $user)
    {
        $byEmail = auth()->user()->email;
        $user->person()->update(['status' => User::STATUS_DEACTIVE, 'deleted_by' => $byEmail]);
        $user->person()->delete();
        LogHelper::Log('deleted', 'User', $user->id, $byEmail);
    }

    public function restored(User $user)
    {
        $byEmail = auth()->user()->email;
        $user->person()->restore();
        $user->person()->update(['status' => User::STATUS_ACTIVE, 'deleted_by' => null]);
        LogHelper::Log('restored', 'User', $user->id, $byEmail);
    }

    public function forceDeleted(User $user)
    {
        $user->person()->forceDelete();
    }
}
