<?php

namespace App\Enums;

enum BookingStatus: int {

    case COMPLETED = 1;
    case FAILED = 0;

    public function label(): string {
        return match ($this) {
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
        };
    }
}
