<?php

namespace App\Enum;

enum BoolEnum: string
{
    case YES  = 'yes';
    case NO  = 'no';

    public function lang(): string
    {
        return match ($this) {
            self::YES => __("admin.yes"),
            self::NO => __("admin.no"),
        };
    }

    public function badge(): string
    {
        return match ($this) {
            self::YES => 'btn btn-success text-center',
            self::NO => 'btn btn-danger text-center',
        };
    }

    public static function vals(): array
    {
        return [
            self::YES->value,
            self::NO->value,
        ];
    }
}
