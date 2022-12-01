<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Validator;

class UserValidation
{
    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUserForRegister($request)
    {
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/']
        ]);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUserForLogin($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*#?&]/'],
            'password_confirm' => 'required|same:password',
        ]);
    }
}
