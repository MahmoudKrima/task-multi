<?php

namespace App\Http\Requests\Api\User\Task;

use App\Enum\TaskStatusEnum;
use App\Enum\TaskPriorityEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:9999'],
            'due_date' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
            'status' => ['required', 'string', Rule::in(TaskStatusEnum::vals())],
            'priority' => ['required', 'string', Rule::in(TaskPriorityEnum::vals())],
            'users' => ['sometimes','nullable','array'],
            'users.*' => [
                'required',
                'integer',
                Rule::exists('admins', 'id')->where(function ($query) {
                    $query->whereIn('id', function ($subQuery) {
                        $subQuery->select('model_id')
                            ->from('model_has_roles')
                            ->where('role_id', function ($roleSubQuery) {
                                $roleSubQuery->select('id')
                                    ->from('roles')
                                    ->where('name', 'employee')
                                    ->limit(1);
                            });
                    });
                }),
            ],
            'attachments' => ['sometimes','nullable','array'],
            'attachments.*' => [
                'sometimes','nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx',
                'mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Ensure valid MIME types
                'max:10240',
            ],
        ];
    }
}
