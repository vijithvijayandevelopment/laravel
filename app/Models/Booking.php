<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model {

    use HasFactory;

    public const ID = 'id';
    public const APPLICATION_ID = 'application_id';
    public const BOOKING_ID = 'booking_id';
    public const USER_ID = 'user_id';
    public const USER_NAME = 'user_name';
    public const DISCOUNT_ID = 'discount_id';
    public const PURCHASE_AMOUNT = 'purchase_amount';
    public const DISCOUNT_AMOUNT = 'discount_amount';
    public const DISCOUNT_PERCENTAGE = 'discount_percentage';
    public const IS_RECURRING = 'is_recurring';
    public const IS_FAMILY_MEMBER_APPLIED = 'is_family_member_applied';
    public const FAMILY_MEMBER_ID = 'family_member_id';
    public const FAMILY_MEMBER_NAME = 'family_member_name';
    public const STATUS = 'status';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::APPLICATION_ID,
        self::BOOKING_ID,
        self::USER_ID,
        self::USER_NAME,
        self::DISCOUNT_ID,
        self::PURCHASE_AMOUNT,
        self::DISCOUNT_AMOUNT,
        self::DISCOUNT_PERCENTAGE,
        self::IS_RECURRING,
        self::IS_FAMILY_MEMBER_APPLIED,
        self::FAMILY_MEMBER_ID,
        self::FAMILY_MEMBER_NAME,
        self::STATUS,
    ];

    /**
     * Get the name of the table associated with the model.
     *
     * @return string
     */
    public static function getTableName(): string {
        return (new static)->getTable();
    }

    // Mutator for formatting the user name
    public function setUserNameAttribute($value): void {
        $this->attributes[self::USER_NAME] = Str::title(Str::lower($value));
    }

    // Mutator for formatting the family member name
    public function setFamilyMemberNameAttribute($value): void {
        $this->attributes[self::FAMILY_MEMBER_NAME] = Str::title(Str::lower($value));
    }
}
