<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $sectionId = $this->route('section') ? $this->route('section')->id : null;

        return [
            'section_name' => 'required|string|max:255|unique:sections,section_name,' . $sectionId,
            'description' => 'nullable|string|max:255',
            'created_by' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'section_name.required' => 'يرجى إدخال اسم القسم',
            'section_name.string' => 'اسم القسم يجب أن يكون نصًا',
            'section_name.max' => 'اسم القسم يجب ألا يزيد عن 255 حرفًا',
            'section_name.unique' => 'اسم القسم موجود بالفعل',
            'description.string' => 'الوصف يجب أن يكون نصًا',
            'description.max' => 'الوصف يجب ألا يزيد عن 255 حرفًا',
            'created_by.string' => 'تم الإنشاء بواسطة يجب أن يكون نصًا',
            'created_by.max' => 'تم الإنشاء بواسطة يجب ألا يزيد عن 255 حرفًا',
        ];
    }
}
