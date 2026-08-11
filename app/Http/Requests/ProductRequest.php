<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        return [
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    public function messages(): array
    {
        return [
            'product_name.required' => 'اسم المنتج مطلوب',
            'product_name.string' => 'اسم المنتج يجب أن يكون نصًا',
            'product_name.max' => 'اسم المنتج يجب ألا يزيد عن 255 حرفًا',
            'description.string' => 'الوصف يجب أن يكون نصًا',
            'section_id.required' => 'القسم مطلوب',
            'section_id.exists' => 'القسم المحدد غير موجود',
        ];
    }
}
