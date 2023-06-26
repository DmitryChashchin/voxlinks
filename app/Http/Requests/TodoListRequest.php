<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TodoListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'sortBy' => Rule::in(['title', 'created_at']),
            'sortOrder' => Rule::in(['asc', 'desc']),
        ];
    }

    public function messages(): array
    {
        return  [
            'sortBy' => "The 'sortBy' parameter accepts only 'title' or 'created_at' ",
            'sortOrder' => "The 'sortOrder' parameter accepts only 'asc' or 'desc' value",
        ];
    }
}
