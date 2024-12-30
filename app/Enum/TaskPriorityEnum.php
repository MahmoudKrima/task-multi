<?php

namespace App\Enum;

enum TaskPriorityEnum: string
{
    case LOW  = 'low';
    case MEDIUM  = 'medium';
    case HIGH  = 'high';

    public function lang(): string
    {
        return match ($this) {
            self::LOW => __("admin.low"),
            self::MEDIUM => __("admin.medium"),
            self::HIGH => __("admin.high"),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::LOW => 'btn btn-warning text-center',
            self::MEDIUM => 'btn btn-success text-center',
            self::HIGH => 'btn btn-danger text-center',
        };
    }

    public static function vals(): array
    {
        return [
            self::LOW->value,
            self::MEDIUM->value,
            self::HIGH->value,
        ];
    }
}
