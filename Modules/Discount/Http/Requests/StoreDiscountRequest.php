<?php

namespace Modules\Discount\Http\Requests;

use App\Enums\DiscountType;
use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class StoreDiscountRequest extends FormRequest {

    public const KEY_NAME = 'name';
    public const KEY_TYPE = 'type';
    public const KEY_AMOUNT = 'amount';
    public const KEY_RECURRING_AMOUNT = 'recurring_amount';
    public const KEY_FAMILY_MEMBER_AMOUNT = 'family_member_amount';
    public const KEY_MAX_DISCOUNT_AMOUNT = 'max_discount_amount';
    public const KEY_PERCENTAGE = 'percentage';
    public const KEY_RECURRING_PERCENTAGE = 'recurring_percentage';
    public const KEY_FAMILY_MEMBER_PERCENTAGE = 'family_member_percentage';
    public const KEY_MAX_USES = 'max_uses';
    public const KEY_IS_ACTIVE = 'is_active';
    public const KEY_CREATED_BY = 'created_by';
    public const KEY_UPDATED_BY = 'updated_by';
    public const NAME_MIN_LENGTH = 3;
    public const NAME_MAX_LENGTH = 255;

    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
     */
    public function authorize(): bool {
        return $this->isMethod('POST') || $this->isMethod('PUT') || $this->isMethod('PATCH');
    }

    /**
     * Get the validation rules that apply to the request.
     * @Override
     * 
     * @return array
     */
    public function rules(): array {
        return match ($this->method()) {
            'POST', 'PUT', 'PATCH' => $this->getRulesForMethod(),
            default => throw ValidationException::withMessages([
                'method' => __('messages.method_not_supported'),
            ]),
        };
    }

    private function getRulesForMethod(): array {
        $rules = [
            self::KEY_NAME => [
                'required',
                'string',
                'min:' . self::NAME_MIN_LENGTH,
                'max:' . self::NAME_MAX_LENGTH,
            ],
            self::KEY_TYPE => [
                'required',
                'integer',
                Rule::in(DiscountType::cases()),
            ],
            self::KEY_MAX_USES => [
                'required',
                'integer',
            ],
            self::KEY_IS_ACTIVE => [
                'required',
                'boolean',
                Rule::in(Status::cases()),
            ],
            self::KEY_MAX_DISCOUNT_AMOUNT => [
                'nullable',
                'numeric'
            ],
        ];

        if ($this->input(self::KEY_TYPE) == DiscountType::FIXED->value) {
            $rules[self::KEY_AMOUNT] = ['required', 'numeric'];
            $rules[self::KEY_FAMILY_MEMBER_AMOUNT] = ['nullable', 'numeric'];
            $rules[self::KEY_RECURRING_AMOUNT] = ['nullable', 'numeric'];
        }

        if ($this->input(self::KEY_TYPE) == DiscountType::PERCENTAGE->value) {
            $rules[self::KEY_PERCENTAGE] = ['required', 'numeric'];
            $rules[self::KEY_FAMILY_MEMBER_PERCENTAGE] = ['nullable', 'numeric'];
            $rules[self::KEY_RECURRING_PERCENTAGE] = ['nullable', 'numeric'];
        }

        if ($this->isMethod('POST')) {
            $rules[self::KEY_CREATED_BY] = ['required', 'integer'];
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules[self::KEY_UPDATED_BY] = ['required', 'integer'];
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     * @Override
     * 
     * @return array
     */
    public function messages(): array {
        return trans('store-discount-validation');
    }

    /**
     * Prepare the data for storage.
     * @Override
     * 
     * @return void
     */
    protected function prepareForValidation(): void {
        $this->isMethod('POST') && $this->merge([
                    self::KEY_CREATED_BY => auth()->id(),
        ]);

        ($this->isMethod('PUT') || $this->isMethod('PUT')) && $this->merge([
                    self::KEY_UPDATED_BY => auth()->id(),
        ]);
    }
}
