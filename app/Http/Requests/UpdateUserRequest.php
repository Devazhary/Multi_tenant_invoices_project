<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
        $userId = $this->route('user')->id;

        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'status'   => ['required', 'in:active,inactive'],
            'roles'    => ['required', 'array', 'min:1'],
            'roles.*'  => ['exists:roles,name'],
        ];
    }

    /**
     * Get the validation messages in Arabic.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'اسم المستخدم مطلوب.',
            'name.max'           => 'اسم المستخدم يجب أن لا يتجاوز 255 حرفاً.',
            'email.required'     => 'البريد الإلكتروني مطلوب.',
            'email.email'        => 'صيغة البريد الإلكتروني غير صحيحة.',
            'email.unique'       => 'هذا البريد الإلكتروني مستخدم من قبل.',
            'password.confirmed' => 'كلمة المرور وتأكيدها غير متطابقتين.',
            'password.min'       => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل.',
            'status.required'    => 'حالة الحساب مطلوبة.',
            'status.in'          => 'قيمة حالة الحساب غير صالحة.',
            'roles.required'     => 'يجب تحديد صلاحية واحدة على الأقل.',
            'roles.min'          => 'يجب تحديد صلاحية واحدة على الأقل.',
            'roles.*.exists'     => 'إحدى الصلاحيات المحددة غير موجودة.',
        ];
    }
}
