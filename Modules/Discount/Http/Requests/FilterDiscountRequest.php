<?php

namespace Modules\Discount\Http\Requests;

use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FilterDiscountRequest extends FormRequest {

    public const KEY_NAME = 'name';
    public const KEY_TYPE = 'type';
    public const KEY_AMOUNT = 'amount';
    public const KEY_MAX_USES = 'max_uses';
    public const KEY_MAX_DISCOUNT_AMOUNT = 'max_discount_amount';
    public const KEY_IS_ACTIVE = 'is_active';
    public const KEY_CREATED_BY = 'created_by';
    public const KEY_CREATED_AT = 'created_at';
    public const NAME_MIN_LENGTH = 1;
    public const NAME_MAX_LENGTH = 255;

    /**
     * Determine if the user is authorized to make this request.
     * @Override
     * 
     * @return bool
     */
    public function authorize(): bool {
        return $this->isMethod('GET');
    }

    /**
     * Get the validation rules that apply to the request.
     * @Override
     * 
     * @return array
     */
    public function rules(): array {
        return match ($this->method()) {
            'GET' => [
                self::KEY_NAME => [
                    'nullable',
                    'string',
                    'min:' . self::NAME_MIN_LENGTH,
                    'max:' . self::NAME_MAX_LENGTH,
                ],
                self::KEY_TYPE => [
                    'nullable',
                    'integer',
                    Rule::in(DiscountType::cases()),
                ],
                self::KEY_MAX_USES => [
                    'nullable',
                    'integer',
                ],
                self::KEY_IS_ACTIVE => [
                    'nullable',
                    'boolean',
                    Rule::in(Status::cases()),
                ],
                self::KEY_CREATED_BY => [
                    'nullable',
                    'integer',
                    'exists:' . User::getTableName() . ',' . User::ID,
                ],
                self::KEY_CREATED_AT => [
                    'nullable',
                    'date_format:m-d-Y',
                ],
            ],
            default => throw ValidationException::withMessages([
                'method' => __('messages.method_not_supported'),
            ]),
        };
    }

    /**
     * Get the error messages for the defined validation rules.
     * @Override
     * 
     * @return array
     */
    public function messages(): array {
        return trans('filter-discount-validation');
    }
}
