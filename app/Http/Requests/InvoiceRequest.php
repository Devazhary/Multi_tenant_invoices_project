<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
            'invoice_number' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after:invoice_date',
            'section_id' => 'required|exists:sections,id',
            'product' => 'required|string|max:255',
            'amount_collection' => 'required|numeric|min:0',
            'amount_commission' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0',
            'rate_vat' => 'required|string|max:255',
            'value_vat' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'note' => 'nullable|string|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'invoice_number.required' => 'رقم الفاتورة مطلوب',
            'invoice_date.required' => 'تاريخ الفاتورة مطلوب',
            'due_date.required' => 'تاريخ الاستحقاق مطلوب',
            'due_date.after' => 'تاريخ الاستحقاق يجب أن يكون بعد تاريخ الفاتورة',
            'section_id.required' => 'القسم مطلوب',
            'section_id.exists' => 'القسم المحدد غير موجود',
            'product.required' => 'المنتج مطلوب',
            'amount_collection.required' => 'المبلغ المحصل مطلوب',
            'amount_commission.required' => 'مبلغ العمولة مطلوب',
            'discount.required' => 'الخصم مطلوب',
            'rate_vat.required' => 'نسبة الضريبة على القيمة المضافة مطلوبة',
            'value_vat.required' => 'قيمة الضريبة على القيمة المضافة مطلوبة',
            'total.required' => 'المجموع الكلي مطلوب',
            'note.max' => 'الملاحظات يجب أن لا تتجاوز 255 حرفًا',
        ];
    }
}
