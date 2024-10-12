<?php

use Modules\Discount\Http\Requests\FilterBookingRequest;

return [
    FilterBookingRequest::KEY_APPLICATION_ID . '.required' => __('validation.required', ['attribute' => __('Application ID')]),
    FilterBookingRequest::KEY_APPLICATION_ID . '.exists' => __('validation.exists', ['attribute' => __('Application ID')]),
    FilterBookingRequest::KEY_APPLICATION_ID_FILTER . '.required' => __('validation.required', ['attribute' => __('Application ID Filter')]),
    FilterBookingRequest::KEY_APPLICATION_API_KEY . '.required' => __('validation.required', ['attribute' => __('Application Api Key')]),
    FilterBookingRequest::KEY_APPLICATION_API_KEY . '.exists' => __('validation.exists', ['attribute' => __('Application Api Key')]),
    FilterBookingRequest::KEY_BOOKING_ID . '.nullable' => __('validation.nullable', ['attribute' => __('Booking ID')]),
    FilterBookingRequest::KEY_BOOKING_ID . '.integer' => __('validation.integer', ['attribute' => __('Booking ID')]),
    FilterBookingRequest::KEY_BOOKING_ID . '.exists' => __('validation.exists', ['attribute' => __('Booking ID')]),
    FilterBookingRequest::KEY_USER_NAME . '.nullable' => __('validation.nullable', ['attribute' => __('User Name')]),
    FilterBookingRequest::KEY_USER_NAME . '.string' => __('validation.string', ['attribute' => __('User Name')]),
    FilterBookingRequest::KEY_USER_NAME . '.min' => __('validation.min.string', [
        'attribute' => __('User Name'),
        'min' => FilterBookingRequest::USER_NAME_MIN_LENGTH,
    ]),
    FilterBookingRequest::KEY_USER_NAME . '.max' => __('validation.max.string', [
        'attribute' => __('User Name'),
        'max' => FilterBookingRequest::USER_NAME_MAX_LENGTH,
    ]),
    FilterBookingRequest::KEY_DISCOUNT_ID . '.nullable' => __('validation.nullable', ['attribute' => __('Discount ID')]),
    FilterBookingRequest::KEY_DISCOUNT_ID . '.exists' => __('validation.exists', ['attribute' => __('Discount ID')]),
    FilterBookingRequest::KEY_IS_RECURRING . '.nullable' => __('validation.nullable', ['attribute' => __('Is Recurring')]),
    FilterBookingRequest::KEY_IS_RECURRING . '.integer' => __('validation.integer', ['attribute' => __('Is Recurring')]),
    FilterBookingRequest::KEY_IS_RECURRING . '.in' => __('validation.in', ['attribute' => __('Is Recurring')]),
    FilterBookingRequest::KEY_IS_FAMILY_MEMBER_APPLIED . '.nullable' => __('validation.nullable', ['attribute' => __('Is Family Member Applied')]),
    FilterBookingRequest::KEY_IS_FAMILY_MEMBER_APPLIED . '.integer' => __('validation.integer', ['attribute' => __('Is Family Member Applied')]),
    FilterBookingRequest::KEY_IS_FAMILY_MEMBER_APPLIED . '.in' => __('validation.in', ['attribute' => __('Is Family Member Applied')]),
    FilterBookingRequest::KEY_FAMILY_MEMBER_NAME . '.nullable' => __('validation.nullable', ['attribute' => __('Family Member Name')]),
    FilterBookingRequest::KEY_FAMILY_MEMBER_NAME . '.string' => __('validation.string', ['attribute' => __('Family Member Name')]),
    FilterBookingRequest::KEY_FAMILY_MEMBER_NAME . '.min' => __('validation.min.string', [
        'attribute' => __('Family Member Name'),
        'min' => FilterBookingRequest::FAMILY_MEMBER_NAME_MIN_LENGTH,
    ]),
    FilterBookingRequest::KEY_FAMILY_MEMBER_NAME . '.max' => __('validation.max.string', [
        'attribute' => __('Family Member Name'),
        'max' => FilterBookingRequest::FAMILY_MEMBER_NAME_MAX_LENGTH,
    ]),
    FilterBookingRequest::KEY_STATUS . '.nullable' => __('validation.nullable', ['attribute' => __('Status')]),
    FilterBookingRequest::KEY_STATUS . '.string' => __('validation.string', ['attribute' => __('Status')]),
    FilterBookingRequest::KEY_STATUS . '.in' => __('validation.in', ['attribute' => __('Status')]),
    FilterBookingRequest::KEY_CREATED_AT . '.nullable' => __('validation.nullable', ['attribute' => __('Created At')]),
    FilterBookingRequest::KEY_CREATED_AT . '.date_format' => __('validation.date_format', [
        'attribute' => __('Created At'),
        'format' => 'Y-m-d',
    ]),
];
