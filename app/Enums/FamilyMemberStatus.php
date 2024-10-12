<?php

namespace App\Enums;

enum FamilyMemberStatus: int {

    case YES = 1;
    case NO = 0;

    public function label(): string {
        return match ($this) {
            self::YES => 'Yes',
            self::NO => 'No',
        };
    }
}
