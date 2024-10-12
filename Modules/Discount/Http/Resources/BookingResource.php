<?php

namespace Modules\Discount\Http\Resources;

use App\Enums\BookingStatus;
use App\Enums\FamilyMemberStatus;
use App\Enums\RecurringStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource {

    private const KEY_ID = 'id';
    private const KEY_BOOKING_ID = 'booking_id';
    private const KEY_USER_ID = 'user_id';
    private const KEY_USER_NAME = 'user_name';
    private const KEY_DISCOUNT_ID = 'discount_id';
    private const KEY_DISCOUNT_AMOUNT = 'discount_amount';
    private const KEY_DISCOUNT_PERCENTAGE = 'discount_percentage';
    public const KEY_IS_RECURRING = 'is_recurring';
    public const KEY_IS_RECURRING_LABEL = 'is_recurring_label';
    private const KEY_IS_FAMILY_MEMBER_APPLIED = 'is_family_member_applied';
    public const KEY_IS_FAMILY_MEMBER_APPLIED_LABEL = 'is_family_member_applied_label';
    private const KEY_FAMILY_MEMBER_ID = 'family_member_id';
    private const KEY_FAMILY_MEMBER_NAME = 'family_member_name';
    private const KEY_STATUS = 'status';
    private const KEY_STATUS_LABEL = 'status_label';
    private const KEY_CREATED_AT = 'created_at';
    private const KEY_UPDATED_AT = 'updated_at';

    /**
     * Transform the resource into an array.
     * @Override
     * 
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array {
        return ($this->resource instanceof Collection ? $this->resource : collect([$this]))->map(fn($booking) => $this->transform($booking))->toArray();
    }

    /**
     * Transform the resource into an array.
     * @Override
     * 
     * @param $value
     * @param $callback
     * @param $default
     * @return array
     */
    protected function transform($value, callable $callback = null, $default = null): array {
        return [
            self::KEY_ID => $value->id,
            self::KEY_BOOKING_ID => $value->booking_id,
            self::KEY_USER_ID => $value->user_id,
            self::KEY_USER_NAME => $value->user_name,
            self::KEY_DISCOUNT_ID => $value->discount_id,
            self::KEY_DISCOUNT_AMOUNT => $value->discount_amount,
            self::KEY_DISCOUNT_PERCENTAGE => $value->discount_percentage,
            self::KEY_IS_RECURRING => $value->is_recurring,
            self::KEY_IS_RECURRING_LABEL => RecurringStatus::from($value->is_recurring)->label(),
            self::KEY_IS_FAMILY_MEMBER_APPLIED => $value->is_family_member_applied,
            self::KEY_IS_FAMILY_MEMBER_APPLIED_LABEL => FamilyMemberStatus::from($value->is_family_member_applied)->label(),
            self::KEY_FAMILY_MEMBER_ID => $value->family_member_id,
            self::KEY_FAMILY_MEMBER_NAME => $value->family_member_name,
            self::KEY_STATUS => $value->status,
            self::KEY_STATUS_LABEL => BookingStatus::from($value->status)->label(),
            self::KEY_CREATED_AT => $value->created_at,
            self::KEY_UPDATED_AT => $value->updated_at,
        ];
    }
}
