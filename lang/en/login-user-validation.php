<?php

use Modules\Auth\Http\Requests\LoginUserRequest;

return [
    LoginUserRequest::KEY_IDENTIFIER . '.required' => __('validation.required', ['attribute' => __('Identifier')]),
    LoginUserRequest::KEY_IDENTIFIER . '.string' => __('validation.string', ['attribute' => __('Identifier')]),
    LoginUserRequest::KEY_IDENTIFIER . '.min' => __('validation.min.string', [
        'attribute' => __('Identifier'),
        'min' => LoginUserRequest::IDENTIFIER_MIN_LENGTH,
    ]),
    LoginUserRequest::KEY_IDENTIFIER . '.max' => __('validation.max.string', [
        'attribute' => __('Identifier'),
        'max' => LoginUserRequest::IDENTIFIER_MAX_LENGTH,
    ]),
    LoginUserRequest::KEY_IDENTIFIER . '.regex' => __('validation.regex', [
        'attribute' => __('Identifier'),
    ]),
    LoginUserRequest::KEY_PASSWORD . '.required' => __('validation.required', ['attribute' => __('Password')]),
    LoginUserRequest::KEY_PASSWORD . '.string' => __('validation.string', ['attribute' => __('Password')]),
];
