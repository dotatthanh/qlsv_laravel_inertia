<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportRequest extends FormRequest
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
            'class_id' => 'required',
            'subject_id' => 'required',
            'file' => 'required|file|mimes:xlsx,xls',
        ];
    }

    public function messages(): array
    {
        return [
            'class_id.required' => 'Tên lớp là trường bắt buộc.',
            'subject_id.required' => 'Tên môn học là trường bắt buộc.',
            'file.required' => 'Tệp excel là trường bắt buộc.',
            'file.file' => 'Tệp excel phải là định dạng tệp.',
            'file.mimes' => 'Tệp excel phải có định dạng xlsx, xls.',
        ];
    }
}
