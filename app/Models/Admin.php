<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Enum\ActivationStatusEnum;
use App\Models\Scopes\TenantScope;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles, BelongsToTenant,Notifiable,HasApiTokens;

    protected $guarded = ['created_at', 'updated_at'];

    public static $permissions = [
        'admins.view',
        'admins.create',
        'admins.update',
        'admins.delete',
    ];

    protected $casts = [
        'password' => 'hashed',
        'status' => ActivationStatusEnum::class
    ];

    public function activity()
    {
        return $this->morphMany(Activity::class, 'causer');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'user_tasks', 'user_id', 'task_id');
    }

    public function task_creator()
    {
        return $this->hasMany(Task::class, 'created_by', 'id');
    }

    protected static function booted()
    {
        static::addGlobalScope(new TenantScope);
    }
}
