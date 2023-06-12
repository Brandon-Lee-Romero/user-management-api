<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
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
            'page'  => 'integer|min:1',
            'limit' => 'integer|min:1|max:100',
            'sort'  => 'string|in:username,email,contact_number,first_name,last_name,created_at',
            'order' => 'string|in:asc,desc',
            'search' => 'string|max:50',
        ];
    }
}
