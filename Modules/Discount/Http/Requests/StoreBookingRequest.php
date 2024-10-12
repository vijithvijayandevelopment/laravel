<?php

namespace Modules\Discount\Http\Requests;

use App\Enums\BookingStatus;
use App\Enums\DiscountApplyStatus;
use App\Models\Application;
use App\Models\Booking;
use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest {

    public const KEY_APPLICATION_ID = 'application_id';
    public const KEY_APPLICATION_API_KEY = 'application_api_key';
    public const KEY_BOOKING_ID = 'booking_id';
    public const KEY_USER_ID = 'user_id';
    public const KEY_USER_NAME = 'user_name';
    public const KEY_DISCOUNT_IDS = 'discount_ids';
    public const KEY_PURCHASE_AMOUNT = 'purchase_amount';
    public const KEY_IS_RECURRING = 'is_recurring';
    public const KEY_IS_FAMILY_MEMBER_APPLIED = 'is_family_member_applied';
    public const KEY_FAMILY_MEMBER_IDS = 'family_member_ids';
    public const KEY_FAMILY_MEMBER_NAMES = 'family_member_names';
    public const KEY_STATUS = 'status';
    public const KEY_CREATED_BY = 'created_by';
    public const KEY_UPDATED_BY = 'updated_by';
    public const KEY_APPLY = 'apply';
    public const USER_NAME_MIN_LENGTH = 1;
    public const USER_NAME_MAX_LENGTH = 255;
    public const FAMILY_MEMBER_NAME_MIN_LENGTH = 1;
    public const FAMILY_MEMBER_NAME_MAX_LENGTH = 255;
    public const HEADER_KEY_APPLICATION_ID = 'Application-ID';
    public const HEADER_KEY_APPLICATION_API_KEY = 'Application-API-Key';
    public const KEY_BOOKINGS = 'bookings';

    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
     */
    public function authorize(): bool {
        return $this->isMethod('POST');
    }

    /**
     * Get the validation rules that apply to the request.
     * @Override
     * 
     * @return array
     */
    public function rules(): array {
        return match ($this->method()) {
            'POST' => [
                self::KEY_APPLICATION_ID => [
                    'required',
                    'exists:' . Application::getTableName() . ',' . Application::APPLICATION_ID,
                ],
                self::KEY_APPLICATION_API_KEY => [
                    'required',
                    'exists:' . Application::getTableName() . ',' . Application::APPLICATION_API_KEY,
                ],
                self::KEY_BOOKING_ID => [
                    'required',
                    'integer',
                ],
                self::KEY_USER_ID => [
                    'required',
                    'integer',
                ],
                self::KEY_USER_NAME => [
                    'required',
                    'string',
                    'min:' . self::USER_NAME_MIN_LENGTH,
                    'max:' . self::USER_NAME_MAX_LENGTH,
                ],
                self::KEY_DISCOUNT_IDS => [
                    'required',
                    'array',
                ],
                self::KEY_DISCOUNT_IDS . '.*' => [
                    'integer',
                    'exists:' . Discount::getTableName() . ',' . Discount::ID,
                ],
                self::KEY_PURCHASE_AMOUNT => [
                    'required',
                    'numeric',
                ],
                self::KEY_FAMILY_MEMBER_IDS => [
                    'nullable',
                    'array',
                ],
                self::KEY_FAMILY_MEMBER_IDS . '.*' => [
                    'integer',
                ],
                self::KEY_FAMILY_MEMBER_NAMES => [
                    'nullable',
                    'array',
                ],
                self::KEY_FAMILY_MEMBER_NAMES . '.*' => [
                    'string',
                    'min:' . self::FAMILY_MEMBER_NAME_MIN_LENGTH,
                    'max:' . self::FAMILY_MEMBER_NAME_MAX_LENGTH,
                ],
                self::KEY_STATUS => [
                    'required',
                    'integer',
                    Rule::in(BookingStatus::cases()),
                ],
                self::KEY_APPLY . '.*' => [
                    'required',
                    'integer',
                    Rule::in(DiscountApplyStatus::cases()),
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
        return trans('store-booking-validation');
    }

    /**
     * 
     * @return void
     */
    public function withValidator(Validator $validator): void {
        $validator->after(function ($validator) {
            if (Booking::where(Booking::BOOKING_ID, $this->input(self::KEY_BOOKING_ID))->exists()) {
                $validator->errors()->add(self::KEY_BOOKING_ID, __('messages.booking_id_already_present'));
            }
        });
    }

    /**
     * Prepare the data for storage.
     * @Override
     * 
     * @return void
     */
    protected function prepareForValidation(): void {
        if ($this->isMethod('POST')) {
            $this->merge([
                self::KEY_APPLICATION_ID => $this->header(self::HEADER_KEY_APPLICATION_ID),
                self::KEY_APPLICATION_API_KEY => $this->header(self::HEADER_KEY_APPLICATION_API_KEY),
            ]);

            if ($this->has(self::KEY_DISCOUNT_IDS)) {
                $discountIds = $this->input(self::KEY_DISCOUNT_IDS);
                $bookings = collect($discountIds)->map(function ($discountId, $index) {
                    return [
                Booking::APPLICATION_ID => Application::where(Application::APPLICATION_ID, $this->input(self::KEY_APPLICATION_ID))->value(Application::ID),
                Booking::BOOKING_ID => $this->input(self::KEY_BOOKING_ID),
                Booking::USER_ID => $this->input(self::KEY_USER_ID),
                Booking::USER_NAME => $this->input(self::KEY_USER_NAME),
                Booking::DISCOUNT_ID => $discountId,
                Booking::PURCHASE_AMOUNT => $this->input(self::KEY_PURCHASE_AMOUNT),
                Booking::FAMILY_MEMBER_ID => $this->input(self::KEY_FAMILY_MEMBER_IDS)[$index] ?? null,
                Booking::FAMILY_MEMBER_NAME => $this->input(self::KEY_FAMILY_MEMBER_NAMES)[$index] ?? null,
                Booking::STATUS => $this->input(self::KEY_STATUS),
                    ];
                });

                $this->merge([self::KEY_BOOKINGS => $bookings]);
            }
        }
    }
}
