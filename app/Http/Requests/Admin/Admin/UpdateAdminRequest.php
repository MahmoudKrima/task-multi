<?php

namespace App\Http\Requests\Admin\Admin;

use App\Enum\ActivationStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($this->route('admin')->id)],
            'phone' => ['required', 'digits_between:10,15', Rule::unique('admins', 'phone')->ignore($this->route('admin')->id)],
            'image' => ['image', 'mimetypes:image/jpeg,image/png,image/webp,image/gif', 'mimes:jpg,jpeg,jfif,png,gif,webp', 'max:5120'],
            'role' => ['required', 'string', 'exists:roles,id'],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'max:20'],
        ];
    }
}
