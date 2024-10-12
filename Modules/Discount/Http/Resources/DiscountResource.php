<?php

namespace Modules\Discount\Http\Resources;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountResource extends JsonResource {

    private const KEY_ID = 'id';
    private const KEY_NAME = 'name';
    private const KEY_TYPE = 'type';
    private const KEY_AMOUNT = 'amount';
    private const KEY_RECURRING_AMOUNT = 'recurring_amount';
    private const KEY_FAMILY_MEMBER_AMOUNT = 'family_member_amount';
    private const KEY_PERCENTAGE = 'percentage';
    private const KEY_FAMILY_MEMBER_PERCENTAGE = 'family_member_percentage';
    private const KEY_RECURRING_PERCENTAGE = 'recurring_percentage';
    private const KEY_MAX_USES = 'max_uses';
    private const KEY_MAX_DISCOUNT_AMOUNT = 'max_discount_amount';
    private const KEY_IS_ACTIVE = 'is_active';
    private const KEY_ACTIVE_LABEL = 'active_label';
    private const KEY_CREATED_BY = 'created_by';
    private const KEY_UPDATED_BY = 'updated_by';
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
        return ($this->resource instanceof Collection ? $this->resource : collect([$this]))->map(fn($discount) => $this->transform($discount))->toArray();
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
            self::KEY_NAME => $value->name,
            self::KEY_TYPE => $value->type,
            self::KEY_AMOUNT => $value->amount,
            self::KEY_RECURRING_AMOUNT => $value->recurring_amount,
            self::KEY_FAMILY_MEMBER_AMOUNT => $value->family_member_amount,
            self::KEY_PERCENTAGE => $value->percentage,
            self::KEY_FAMILY_MEMBER_PERCENTAGE => $value->family_member_percentage,
            self::KEY_RECURRING_PERCENTAGE => $value->recurring_percentage,
            self::KEY_MAX_USES => $value->max_uses,
            self::KEY_MAX_DISCOUNT_AMOUNT => $value->max_discount_amount,
            self::KEY_IS_ACTIVE => $value->is_active,
            self::KEY_ACTIVE_LABEL => Status::from($value->is_active)->label(),
            self::KEY_CREATED_BY => $value->created_by,
            self::KEY_UPDATED_BY => $value->updated_by,
            self::KEY_CREATED_AT => $value->created_at,
            self::KEY_UPDATED_AT => $value->updated_at,
        ];
    }
}
