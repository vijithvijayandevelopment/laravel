<?php

namespace App\Enums;

enum Status: int {

    case ACTIVE = 1;
    case INACTIVE = 0;

    public function label(): string {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::INACTIVE => 'Inactive',
        };
    }
}
