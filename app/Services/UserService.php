<?php

namespace App\Services;

use App\Models\User;

class UserService
{

    public function createGuest()
    {
        return User::create([
            'name' => 'Guest',
            'email' => null,
            'password' => null,
        ]);
    }

}
