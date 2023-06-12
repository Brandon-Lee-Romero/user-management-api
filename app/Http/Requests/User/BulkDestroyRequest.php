<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class  BulkDestroyRequest extends FormRequest
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
            'id' => 'required|array|min:1|distinct',
            'id.*' => 'integer|exists:users,id',
        ];
    }
}
