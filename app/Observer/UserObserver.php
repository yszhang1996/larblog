<?php


namespace App\Observer;

use App\User;
use Illuminate\Support\Str;

class UserObserver
{
    public function creating(User $user){
        $user->email_token = str::random(10);
        $user->email_active = false;
    }
}