<?php

namespace App\Models;

use App\Enum\TaskStatusEnum;
use App\Enum\TaskPriorityEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Stancl\Tenancy\Database\Concerns\BelongsToPrimaryModel;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model
{
    use HasFactory,BelongsToPrimaryModel;

    protected $guarded = ['created_at', 'updated_at'];

    public static $permissions = [
        'task.view',
        'task.create',
        'task.update',
        'task.delete',
        'task.assign',
    ];

    protected $casts = [
        'status' => TaskStatusEnum::class,
        'priority' => TaskPriorityEnum::class
    ];


    public function getRelationshipToPrimaryModel(): string
    {
        return 'creator';
    }

    public function creator()
    {
        return $this->belongsTo(Admin::class, 'created_by', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(Admin::class, 'user_tasks', 'task_id', 'user_id');
    }

    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class, 'task_id', 'id');
    }

    public function scopeForAdmin(Builder $query)
    {
        $admin = auth('admin')->user();

        if (!$admin->hasRole('employee')) {
            return $query->with('creator', 'users', 'attachments')
                ->orderBy('id', 'desc');
        }

        return $query->where('created_by', $admin->id)
            ->orWhereHas('users', function ($q) use ($admin) {
                $q->where('user_id', $admin->id);
            })
            ->with('creator', 'users', 'attachments')
            ->distinct()
            ->orderBy('id', 'desc');
    }

}
