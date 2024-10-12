<?php

use Modules\Discount\Http\Requests\GetBookingRequest;

return [
    GetBookingRequest::KEY_APPLICATION_ID . '.required' => __('validation.required', ['attribute' => __('Application ID')]),
    GetBookingRequest::KEY_APPLICATION_ID . '.exists' => __('validation.exists', ['attribute' => __('Application ID')]),
    GetBookingRequest::KEY_APPLICATION_API_KEY . '.required' => __('validation.required', ['attribute' => __('Application Api Key')]),
    GetBookingRequest::KEY_APPLICATION_API_KEY . '.exists' => __('validation.exists', ['attribute' => __('Application Api Key')]),
];
