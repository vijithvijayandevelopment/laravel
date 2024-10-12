<?php

use Modules\Discount\Http\Requests\FilterDiscountRequest;

return [
    FilterDiscountRequest::KEY_NAME . '.nullable' => __('validation.nullable', ['attribute' => __('Name')]),
    FilterDiscountRequest::KEY_NAME . '.string' => __('validation.string', ['attribute' => __('Name')]),
    FilterDiscountRequest::KEY_NAME . '.min' => __('validation.min.string', [
        'attribute' => __('Name'),
        'min' => FilterDiscountRequest::NAME_MIN_LENGTH,
    ]),
    FilterDiscountRequest::KEY_NAME . '.max' => __('validation.max.string', [
        'attribute' => __('Name'),
        'max' => FilterDiscountRequest::NAME_MAX_LENGTH,
    ]),
    FilterDiscountRequest::KEY_TYPE . '.nullable' => __('validation.nullable', ['attribute' => __('Type')]),
    FilterDiscountRequest::KEY_TYPE . '.integer' => __('validation.integer', ['attribute' => __('Type')]),
    FilterDiscountRequest::KEY_TYPE . '.in' => __('validation.in', ['attribute' => __('Type')]),
    FilterDiscountRequest::KEY_MAX_USES . '.nullable' => __('validation.nullable', ['attribute' => __('Max Uses')]),
    FilterDiscountRequest::KEY_MAX_USES . '.integer' => __('validation.integer', ['attribute' => __('Max Uses')]),
    FilterDiscountRequest::KEY_IS_ACTIVE . '.nullable' => __('validation.nullable', ['attribute' => __('Is Active')]),
    FilterDiscountRequest::KEY_IS_ACTIVE . '.boolean' => __('validation.boolean', ['attribute' => __('Is Active')]),
    FilterDiscountRequest::KEY_IS_ACTIVE . '.in' => __('validation.in', ['attribute' => __('Is Active')]),
    FilterDiscountRequest::KEY_CREATED_BY . '.nullable' => __('validation.nullable', ['attribute' => __('Created By')]),
    FilterDiscountRequest::KEY_CREATED_BY . '.integer' => __('validation.integer', ['attribute' => __('Created By')]),
    FilterDiscountRequest::KEY_CREATED_BY . '.exists' => __('validation.exists', ['attribute' => __('Created By')]),
    FilterDiscountRequest::KEY_CREATED_AT . '.nullable' => __('validation.nullable', ['attribute' => __('Created At')]),
    FilterDiscountRequest::KEY_CREATED_AT . '.date_format' => __('validation.date_format', [
        'attribute' => __('Created At'),
        'format' => 'm-d-Y',
    ]),
];
