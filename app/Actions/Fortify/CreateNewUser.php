<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    public function create(array $input): User
    {
        Validator::make($input, [
            'username'   => ['required','string','max:50','alpha_dash','unique:users,username'],
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'email'      => ['required','string','email','max:255','unique:users,email'],
            'password'   => $this->passwordRules(),
        ])->validate();

        return User::create([
            'username'   => $input['username'],
            'first_name' => $input['first_name'],
            'last_name'  => $input['last_name'],
            'email'      => $input['email'],
            'password'   => Hash::make($input['password']),
            'role_id'    => 1, // general (ตั้งให้เป็นค่าเริ่มต้น)
            // ฟิลด์อื่น (gender, age, skin_type_id, is_sensitive_skin, allergies) ไปเก็บหน้า onboarding
        ]);
    }
}
