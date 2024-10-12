<?php

namespace App\Enums;

enum RoleType: int {

    case ADMIN = 1;
    case USER = 2;

    public function label(): string {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::USER => 'User',
        };
    }
}
