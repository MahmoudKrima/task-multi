<?php

namespace App\Enum;

enum TaskStatusEnum: string
{
    case PENDING  = 'pending';
    case INPROGRESS  = 'inprogress';
    case COMPLETED  = 'completed';

    public function lang(): string
    {
        return match ($this) {
            self::PENDING => __("admin.pending"),
            self::INPROGRESS => __("admin.inprogress"),
            self::COMPLETED => __("admin.completed"),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::PENDING => 'btn btn-warning text-center',
            self::INPROGRESS => 'btn btn-success text-center',
            self::COMPLETED => 'btn btn-danger text-center',
        };
    }

    public static function vals(): array
    {
        return [
            self::PENDING->value,
            self::INPROGRESS->value,
            self::COMPLETED->value,
        ];
    }
}
