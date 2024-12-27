<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'max:20'],
            'phone' => ['required', 'digits_between:10,15', Rule::unique('admins', 'phone')->ignore(auth('admin')->id())],
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore(auth('admin')->id())],
            'image' => ['image', 'mimetypes:image/jpeg,image/png,image/webp,image/gif', 'mimes:jpg,jpeg,jfif,png,gif,webp', 'max:5120'],
        ];
    }
}
