<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class UniqueEmailOrPhone implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the email or phone is unique
        return !User::where('email', $value)
                   ->orWhere('phone', $value)
                   ->exists();
    }

    public function message()
    {
        return 'The email/phone has already been taken';
    }
}
