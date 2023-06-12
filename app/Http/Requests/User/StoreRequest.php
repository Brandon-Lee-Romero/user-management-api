<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|min:2|max:50',
            'last_name' => 'required|string|min:2|max:50',
            'address' => 'required|string|min:5|max:150',
            'postcode'  => 'required|string|min:4|max:150',
            'contact_number' => 'required|numeric|digits:11|unique:users',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|min:4|max:20|unique:users',
            'password' => 'required|confirmed|min:6|max:24',
        ];
    }

    public function getData()
    {
        $data = $this->validated();
        $data['password'] = Hash::make($data['password']);
        return $data;
    }
}
