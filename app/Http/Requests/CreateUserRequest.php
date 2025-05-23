<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
           'name'=> 'required',
           'email'=> 'required|email|unique:users,email',
           'password' => 'required',
           'role_id' => 'required|exists:roles,id',
        ];
    }
}
