<?php

namespace Modules\Discount\Http\Requests;

use App\Enums\BookingStatus;
use App\Enums\FamilyMemberStatus;
use App\Enums\RecurringStatus;
use App\Models\Application;
use App\Models\Booking;
use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class FilterBookingRequest extends FormRequest {

    public const KEY_APPLICATION_ID = 'application_id';
    public const KEY_APPLICATION_API_KEY = 'application_api_key';
    public const KEY_BOOKING_ID = 'booking_id';
    public const KEY_USER_NAME = 'user_name';
    public const KEY_DISCOUNT_ID = 'discount_id';
    public const KEY_IS_RECURRING = 'is_recurring';
    public const KEY_IS_FAMILY_MEMBER_APPLIED = 'is_family_member_applied';
    public const KEY_FAMILY_MEMBER_NAME = 'family_member_name';
    public const KEY_STATUS = 'status';
    public const KEY_CREATED_AT = 'created_at';
    public const USER_NAME_MIN_LENGTH = 1;
    public const USER_NAME_MAX_LENGTH = 255;
    public const FAMILY_MEMBER_NAME_MIN_LENGTH = 1;
    public const FAMILY_MEMBER_NAME_MAX_LENGTH = 255;
    public const HEADER_KEY_APPLICATION_ID = 'Application-ID';
    public const HEADER_KEY_APPLICATION_API_KEY = 'Application-API-Key';
    public const KEY_APPLICATION_ID_FILTER = 'application_id_filter';

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
                self::KEY_APPLICATION_ID => [
                    'required',
                    'exists:' . Application::getTableName() . ',' . Application::APPLICATION_ID,
                ],
                self::KEY_APPLICATION_ID_FILTER => [
                    'required',
                ],
                self::KEY_APPLICATION_API_KEY => [
                    'required',
                    'exists:' . Application::getTableName() . ',' . Application::APPLICATION_API_KEY,
                ],
                self::KEY_BOOKING_ID => [
                    'nullable',
                    'integer',
                    'exists:' . Booking::getTableName() . ',' . Booking::BOOKING_ID,
                ],
                self::KEY_USER_NAME => [
                    'nullable',
                    'string',
                    'min:' . self::USER_NAME_MIN_LENGTH,
                    'max:' . self::USER_NAME_MAX_LENGTH,
                ],
                self::KEY_DISCOUNT_ID => [
                    'nullable',
                    'exists:' . Discount::getTableName() . ',' . Discount::ID,
                ],
                self::KEY_IS_RECURRING => [
                    'required',
                    'integer',
                    Rule::in(RecurringStatus::cases()),
                ],
                self::KEY_IS_FAMILY_MEMBER_APPLIED => [
                    'required',
                    'integer',
                    Rule::in(FamilyMemberStatus::cases()),
                ],
                self::KEY_FAMILY_MEMBER_NAME => [
                    'nullable',
                    'string',
                    'min:' . self::FAMILY_MEMBER_NAME_MIN_LENGTH,
                    'max:' . self::FAMILY_MEMBER_NAME_MAX_LENGTH,
                ],
                self::KEY_STATUS => [
                    'nullable',
                    'integer',
                    Rule::in(BookingStatus::cases()),
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
        return trans('filter-booking-validation');
    }

    /**
     * Prepare the data for storage.
     * @Override
     * 
     * @return void
     */
    protected function prepareForValidation(): void {

        $this->merge([
            self::KEY_APPLICATION_ID => $this->header(self::HEADER_KEY_APPLICATION_ID),
            self::KEY_APPLICATION_API_KEY => $this->header(self::HEADER_KEY_APPLICATION_API_KEY),
            self::KEY_APPLICATION_ID_FILTER => Application::where(Application::APPLICATION_ID, $this->header(self::HEADER_KEY_APPLICATION_ID))->value(Application::ID),
        ]);
    }
}
