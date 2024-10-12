<?php

use Modules\Discount\Http\Requests\StoreDiscountRequest;

return [
    StoreDiscountRequest::KEY_NAME . '.required' => __('validation.required', ['attribute' => __('Name')]),
    StoreDiscountRequest::KEY_NAME . '.string' => __('validation.string', ['attribute' => __('Name')]),
    StoreDiscountRequest::KEY_NAME . '.min' => __('validation.min.string', [
        'attribute' => __('Name'),
        'min' => StoreDiscountRequest::NAME_MIN_LENGTH,
    ]),
    StoreDiscountRequest::KEY_NAME . '.max' => __('validation.max.string', [
        'attribute' => __('Name'),
        'max' => StoreDiscountRequest::NAME_MAX_LENGTH,
    ]),
    StoreDiscountRequest::KEY_TYPE . '.required' => __('validation.required', ['attribute' => __('Type')]),
    StoreDiscountRequest::KEY_TYPE . '.integer' => __('validation.integer', ['attribute' => __('Type')]),
    StoreDiscountRequest::KEY_TYPE . '.in' => __('validation.in', ['attribute' => __('Type')]),
    StoreDiscountRequest::KEY_AMOUNT . '.required' => __('validation.required', ['attribute' => __('Amount')]),
    StoreDiscountRequest::KEY_AMOUNT . '.numeric' => __('validation.numeric', ['attribute' => __('Amount')]),
    StoreDiscountRequest::KEY_MAX_DISCOUNT_AMOUNT . '.nullable' => __('validation.nullable', ['attribute' => __('Max Discount Amount')]),
    StoreDiscountRequest::KEY_MAX_DISCOUNT_AMOUNT . '.numeric' => __('validation.numeric', ['attribute' => __('Max Discount Amount')]),
    StoreDiscountRequest::KEY_MAX_USES . '.required' => __('validation.required', ['attribute' => __('Max Uses')]),
    StoreDiscountRequest::KEY_MAX_USES . '.integer' => __('validation.integer', ['attribute' => __('Max Uses')]),
    StoreDiscountRequest::KEY_IS_ACTIVE . '.required' => __('validation.required', ['attribute' => __('Is Active')]),
    StoreDiscountRequest::KEY_IS_ACTIVE . '.boolean' => __('validation.boolean', ['attribute' => __('Is Active')]),
    StoreDiscountRequest::KEY_IS_ACTIVE . '.in' => __('validation.in', ['attribute' => __('Is Active')]),
    StoreDiscountRequest::KEY_CREATED_BY . '.required' => __('validation.required', ['attribute' => __('Created By')]),
    StoreDiscountRequest::KEY_CREATED_BY . '.integer' => __('validation.integer', ['attribute' => __('Created By')]),
    StoreDiscountRequest::KEY_UPDATED_BY . '.required' => __('validation.required', ['attribute' => __('Updated By')]),
    StoreDiscountRequest::KEY_UPDATED_BY . '.integer' => __('validation.integer', ['attribute' => __('Updated By')]),
    StoreDiscountRequest::KEY_RECURRING_AMOUNT . '.nullable' => __('validation.nullable', ['attribute' => __('Recurring Amount')]),
    StoreDiscountRequest::KEY_RECURRING_AMOUNT . '.numeric' => __('validation.numeric', ['attribute' => __('Recurring Amount')]),
    StoreDiscountRequest::KEY_FAMILY_MEMBER_AMOUNT . '.nullable' => __('validation.nullable', ['attribute' => __('Family Member Amount')]),
    StoreDiscountRequest::KEY_FAMILY_MEMBER_AMOUNT . '.numeric' => __('validation.numeric', ['attribute' => __('Family Member Amount')]),
    StoreDiscountRequest::KEY_PERCENTAGE . '.nullable' => __('validation.nullable', ['attribute' => __('Percentage')]),
    StoreDiscountRequest::KEY_PERCENTAGE . '.numeric' => __('validation.numeric', ['attribute' => __('Percentage')]),
    StoreDiscountRequest::KEY_FAMILY_MEMBER_PERCENTAGE . '.nullable' => __('validation.nullable', ['attribute' => __('Family Member Percentage')]),
    StoreDiscountRequest::KEY_FAMILY_MEMBER_PERCENTAGE . '.numeric' => __('validation.numeric', ['attribute' => __('Family Member Percentage')]),
    StoreDiscountRequest::KEY_RECURRING_PERCENTAGE . '.nullable' => __('validation.nullable', ['attribute' => __('Recurring Percentage')]),
    StoreDiscountRequest::KEY_RECURRING_PERCENTAGE . '.numeric' => __('validation.numeric', ['attribute' => __('Recurring Percentage')]),
];
