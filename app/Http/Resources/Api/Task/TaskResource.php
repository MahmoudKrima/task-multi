<?php

namespace App\Http\Resources\Api\Task;

use App\Http\Resources\Api\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'title'=>$this->title,
            'due_date'=>$this->due_date,
            'created_by'=>$this->created_by,
            'creator_name'=>$this->creator->name,
            'users'=>$this->users ? UserResource::collection($this->users) : __('admin.n/a'),
            'attachments'=>$this->attachments ? AttachmentsResource::collection($this->attachments) : __('admin.n/a'),
        ];
    }
}
