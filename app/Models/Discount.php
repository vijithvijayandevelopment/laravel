<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Discount extends Model {

    use HasFactory,
        SoftDeletes;

    public const ID = 'id';
    public const NAME = 'name';
    public const TYPE = 'type';
    public const AMOUNT = 'amount';
    public const RECURRING_AMOUNT = 'recurring_amount';
    public const FAMILY_MEMBER_AMOUNT = 'family_member_amount';
    public const PERCENTAGE = 'percentage';
    public const RECURRING_PERCENTAGE = 'recurring_percentage';
    public const FAMILY_MEMBER_PERCENTAGE = 'family_member_percentage';
    public const MAX_USES = 'max_uses';
    public const MAX_DISCOUNT_AMOUNT = 'max_discount_amount';
    public const IS_ACTIVE = 'is_active';
    public const CREATED_BY = 'created_by';
    public const UPDATED_BY = 'updated_by';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        self::NAME,
        self::TYPE,
        self::AMOUNT,
        self::RECURRING_AMOUNT,
        self::FAMILY_MEMBER_AMOUNT,
        self::PERCENTAGE,
        self::RECURRING_PERCENTAGE,
        self::FAMILY_MEMBER_PERCENTAGE,
        self::MAX_USES,
        self::MAX_DISCOUNT_AMOUNT,
        self::IS_ACTIVE,
        self::CREATED_BY,
        self::UPDATED_BY,
    ];

    /**
     * Get the name of the table associated with the model.
     *
     * @return string
     */
    public static function getTableName(): string {
        return (new static)->getTable();
    }

    // Mutator for formatting the name
    public function setNameAttribute($value): void {
        $this->attributes[self::NAME] = Str::title(Str::lower($value));
    }
}
