<?php

namespace App\Http\Requests\Admin\Task;

use App\Enum\TaskPriorityEnum;
use App\Enum\TaskStatusEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SearchTaskRequest extends FormRequest
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
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'created_by' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('admins', 'id')->where(function ($query) {
                    $query->whereIn('id', function ($subQuery) {
                        $subQuery->select('created_by')
                            ->from('tasks')
                            ->whereNotNull('created_at');
                    });
                }),
            ],
            'due_date' => ['sometimes', 'nullable', 'date', 'date_format:Y-m-d'],
            'status' => ['sometimes', 'nullable', 'string', Rule::in(TaskStatusEnum::vals())],
            'priority' => ['sometimes', 'nullable', 'string', Rule::in(TaskPriorityEnum::vals())],
        ];
    }
}
