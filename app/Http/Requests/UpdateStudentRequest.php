<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('users')->ignore($this->route('student')),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Họ và tên là trường bắt buộc.",
            'name.max' => "Họ và tên tối đa :max ký tự.",
            'email.required' => "Email là trường bắt buộc.",
            'email.max' => "Email tối đa :max ký tự.",
            'email.email' => "Email không đúng định dạng.",
            'email.unique' => "Email đã tồn tại.",
        ];
    }
}
