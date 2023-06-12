<?php

namespace App\Http\Requests\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'first_name' => 'string|min:2|max:50',
            'last_name' => 'string|min:2|max:50',
            'address' => 'string|min:5|max:150',
            'postcode'  => 'string|min:4|max:150',
            'contact_number' => 'numeric|digits:11|unique:users,contact_number,' . $this->id,
            'email' => 'email|unique:users,email,' . $this->id,
            'username' => 'string|min:4|max:20|unique:users,username,' . $this->id,
            'password' => 'confirmed|min:6|max:24',
        ];
    }

    public function getData()
    {
        $data = $this->validated();

        if(isset($data['password'])) $data['password'] = Hash::make($data['password']);
        
        return $data;
    }

}
