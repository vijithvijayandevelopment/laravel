<?php

use Modules\Discount\Http\Requests\StoreApplicationRequest;

return [
    StoreApplicationRequest::KEY_APPLICATION_ID . '.required' => __('validation.required', ['attribute' => __('Application ID')]),
    StoreApplicationRequest::KEY_APPLICATION_ID . '.integer' => __('validation.integer', ['attribute' => __('Application ID')]),
    StoreApplicationRequest::KEY_APPLICATION_ID . '.unique' => __('validation.unique', ['attribute' => __('Application ID')]),
    StoreApplicationRequest::KEY_APPLICATION_ID . '.digits' => __('validation.digits', [
        'attribute' => __('Application ID'),
        'digits' => StoreApplicationRequest::APPLICATION_ID_LENGTH,
    ]),
    StoreApplicationRequest::KEY_APPLICATION_NAME . '.required' => __('validation.required', ['attribute' => __('Application Name')]),
    StoreApplicationRequest::KEY_APPLICATION_NAME . '.string' => __('validation.string', ['attribute' => __('Application Name')]),
    StoreApplicationRequest::KEY_APPLICATION_NAME . '.min' => __('validation.min.string', [
        'attribute' => __('Application Name'),
        'min' => StoreApplicationRequest::APPLICATION_NAME_MIN_LENGTH,
    ]),
    StoreApplicationRequest::KEY_APPLICATION_NAME . '.max' => __('validation.max.string', [
        'attribute' => __('Application Name'),
        'max' => StoreApplicationRequest::APPLICATION_NAME_MAX_LENGTH,
    ]),
    StoreApplicationRequest::KEY_APPLICATION_API_KEY . '.required' => __('validation.required', ['attribute' => __('Application API Key')]),
    StoreApplicationRequest::KEY_APPLICATION_API_KEY . '.string' => __('validation.string', ['attribute' => __('Application API Key')]),
    StoreApplicationRequest::KEY_APPLICATION_API_KEY . '.size' => __('validation.size.string', [
        'attribute' => __('Application API Key'),
        'size' => StoreApplicationRequest::APPLICATION_API_KEY_LENGTH,
    ]),
    StoreApplicationRequest::KEY_APPLICATION_API_KEY . '.unique' => __('validation.unique', ['attribute' => __('Application API Key')]),
    StoreApplicationRequest::KEY_USER_ID . '.required' => __('validation.required', ['attribute' => __('User ID')]),
    StoreApplicationRequest::KEY_USER_ID . '.exists' => __('validation.exists', ['attribute' => __('User ID')]),
    StoreApplicationRequest::KEY_IS_ACTIVE . '.required' => __('validation.required', ['attribute' => __('Is Active')]),
    StoreApplicationRequest::KEY_IS_ACTIVE . '.boolean' => __('validation.boolean', ['attribute' => __('Is Active')]),
    StoreApplicationRequest::KEY_IS_ACTIVE . '.in' => __('validation.in', ['attribute' => __('Is Active')]),
];
