<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255',  Rule::unique('roles', 'name')
            ->where('tenant_id', tenant('id'))
            ->ignore($this->route('role')->id),],
            'permission_id' => ['required', 'exists:permissions,id'],
            'permission_id.*' => ['required', 'exists:permissions,id'],
        ];
    }
}
