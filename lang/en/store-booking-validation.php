<?php

use Modules\Discount\Http\Requests\StoreBookingRequest;

return [
    StoreBookingRequest::KEY_APPLICATION_ID . '.required' => __('validation.required', ['attribute' => __('Application ID')]),
    StoreBookingRequest::KEY_APPLICATION_ID . '.exists' => __('validation.exists', ['attribute' => __('Application ID')]),
    StoreBookingRequest::KEY_APPLICATION_API_KEY . '.required' => __('validation.required', ['attribute' => __('Application API Key')]),
    StoreBookingRequest::KEY_APPLICATION_API_KEY . '.exists' => __('validation.exists', ['attribute' => __('Application API Key')]),
    StoreBookingRequest::KEY_BOOKING_ID . '.required' => __('validation.required', ['attribute' => __('Booking ID')]),
    StoreBookingRequest::KEY_BOOKING_ID . '.integer' => __('validation.integer', ['attribute' => __('Booking ID')]),
    StoreBookingRequest::KEY_USER_ID . '.required' => __('validation.required', ['attribute' => __('User ID')]),
    StoreBookingRequest::KEY_USER_ID . '.integer' => __('validation.integer', ['attribute' => __('User ID')]),
    StoreBookingRequest::KEY_USER_NAME . '.required' => __('validation.required', ['attribute' => __('User Name')]),
    StoreBookingRequest::KEY_USER_NAME . '.string' => __('validation.string', ['attribute' => __('User Name')]),
    StoreBookingRequest::KEY_USER_NAME . '.min' => __('validation.min.string', [
        'attribute' => __('User Name'),
        'min' => StoreBookingRequest::USER_NAME_MIN_LENGTH,
    ]),
    StoreBookingRequest::KEY_USER_NAME . '.max' => __('validation.max.string', [
        'attribute' => __('User Name'),
        'max' => StoreBookingRequest::USER_NAME_MAX_LENGTH,
    ]),
    StoreBookingRequest::KEY_DISCOUNT_IDS . '.required' => __('validation.required', ['attribute' => __('Discount IDs')]),
    StoreBookingRequest::KEY_DISCOUNT_IDS . '.*.exists' => __('validation.exists', ['attribute' => __('Discount ID')]),
    StoreBookingRequest::KEY_PURCHASE_AMOUNT . '.required' => __('validation.required', ['attribute' => __('Purchase Amount')]),
    StoreBookingRequest::KEY_PURCHASE_AMOUNT . '.numeric' => __('validation.numeric', ['attribute' => __('Purchase Amount')]),
    StoreBookingRequest::KEY_FAMILY_MEMBER_IDS . '.nullable' => __('validation.nullable', ['attribute' => __('Family Member IDs')]),
    StoreBookingRequest::KEY_FAMILY_MEMBER_IDS . '.*.integer' => __('validation.integer', ['attribute' => __('Family Member ID')]),
    StoreBookingRequest::KEY_FAMILY_MEMBER_IDS . '.*.integer' => __('validation.integer', ['attribute' => __('Family Member ID')]),
    StoreBookingRequest::KEY_FAMILY_MEMBER_NAMES . '.*.string' => __('validation.string', ['attribute' => __('Family Member Name')]),
    StoreBookingRequest::KEY_FAMILY_MEMBER_NAMES . '.*.min' => __('validation.min.string', [
        'attribute' => __('Family Member Name'),
        'min' => StoreBookingRequest::FAMILY_MEMBER_NAME_MIN_LENGTH,
    ]),
    StoreBookingRequest::KEY_FAMILY_MEMBER_NAMES . '.*.max' => __('validation.max.string', [
        'attribute' => __('Family Member Name'),
        'max' => StoreBookingRequest::FAMILY_MEMBER_NAME_MAX_LENGTH,
    ]),
    StoreBookingRequest::KEY_STATUS . '.required' => __('validation.required', ['attribute' => __('Status')]),
    StoreBookingRequest::KEY_STATUS . '.integer' => __('validation.integer', ['attribute' => __('Status')]),
    StoreBookingRequest::KEY_APPLY . '.required' => __('validation.required', ['attribute' => __('Apply')]),
    StoreBookingRequest::KEY_APPLY . '.*.integer' => __('validation.integer', ['attribute' => __('Apply')]),
];
