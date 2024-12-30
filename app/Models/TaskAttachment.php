<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAttachment extends Model
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    public static $permissions = [
        'task_attachment.view',
        'task_attachment.update',
        'task_attachment.delete',
    ];

    public function task(){
        return $this->belongsTo(Task::class);
    }


}
