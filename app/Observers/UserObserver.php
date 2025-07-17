<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Helpers\LogHelper;

class UserObserver
{
    public function created(User $user)
    {
        if($user->status == User::STATUS_ACTIVE)
        {
            Mail::raw('Welcome to system', function ($message) use ($user) 
            {
                $message->to($user->email)
                       ->subject('Welcome');
            });
        }
        LogHelper::Log('created', 'User', $user->id);
    }

    public function updated(User $user)
    {
        if($user->wasChanged('status'))
        {
            $user->person()->update(['status' => $user->status]);            
        }
        LogHelper::Log('updated', 'User', $user->id);
    }

    public function deleted(User $user)
    {
        $user->person()->delete();
        LogHelper::Log('deleted', 'User', $user->id);
    }

    public function restored(User $user)
    {
        //
    }

    public function forceDeleted(User $user)
    {
        //
    }
}
