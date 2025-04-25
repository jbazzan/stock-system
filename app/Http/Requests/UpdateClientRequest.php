<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'=>'sometimes|required|string|max:255',
            'email'=>'sometimes|required|email',
            'phone'=>'nullable|string|max:20',
            'address'=>'nullable|string|max:255',
        ];
    }
}
