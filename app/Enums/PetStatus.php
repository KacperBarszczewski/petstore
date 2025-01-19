<?php

namespace App\Enums;

enum PetStatus: string
{
    case AVAILABLE = 'available';
    case PENDING = 'pending';
    case SOLD = 'sold';

    public static function all(): array
    {
        return [
            self::AVAILABLE->value,
            self::PENDING->value,
            self::SOLD->value,
        ];
    }
}