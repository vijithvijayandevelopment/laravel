<?php

use Modules\Auth\Http\Requests\StoreUserRequest;

return [
    StoreUserRequest::KEY_NAME . '.required' => __('validation.required', ['attribute' => __('Name')]),
    StoreUserRequest::KEY_NAME . '.string' => __('validation.string', ['attribute' => __('Name')]),
    StoreUserRequest::KEY_NAME . '.min' => __('validation.min.string', [
        'attribute' => __('Name'),
        'min' => StoreUserRequest::NAME_MIN_LENGTH,
    ]),
    StoreUserRequest::KEY_NAME . '.max' => __('validation.max.string', [
        'attribute' => __('Name'),
        'max' => StoreUserRequest::NAME_MAX_LENGTH,
    ]),
    StoreUserRequest::KEY_NAME . '.regex' => __('validation.regex', [
        'attribute' => __('Name'),
    ]),
    StoreUserRequest::KEY_EMAIL . '.required' => __('validation.required', ['attribute' => __('Email')]),
    StoreUserRequest::KEY_EMAIL . '.string' => __('validation.string', ['attribute' => __('Email')]),
    StoreUserRequest::KEY_EMAIL . '.email' => __('validation.email', ['attribute' => __('Email')]),
    StoreUserRequest::KEY_EMAIL . '.min' => __('validation.min.string', [
        'attribute' => __('Email'),
        'min' => StoreUserRequest::EMAIL_MIN_LENGTH,
    ]),
    StoreUserRequest::KEY_EMAIL . '.max' => __('validation.max.string', [
        'attribute' => __('Email'),
        'max' => StoreUserRequest::EMAIL_MAX_LENGTH,
    ]),
    StoreUserRequest::KEY_EMAIL . '.unique' => __('validation.unique', ['attribute' => __('Email')]),
    StoreUserRequest::KEY_PASSWORD . '.required' => __('validation.required', ['attribute' => __('Password')]),
    StoreUserRequest::KEY_PASSWORD . '.string' => __('validation.string', ['attribute' => __('Password')]),
    StoreUserRequest::KEY_PASSWORD . '.min' => __('validation.min.string', [
        'attribute' => __('Password'),
        'min' => StoreUserRequest::PASSWORD_MIN_LENGTH,
    ]),
    StoreUserRequest::KEY_PASSWORD . '.confirmed' => __('validation.confirmed', ['attribute' => __('Password')]),
    StoreUserRequest::KEY_MOBILE . '.required' => __('validation.required', ['attribute' => __('Mobile')]),
    StoreUserRequest::KEY_MOBILE . '.string' => __('validation.string', ['attribute' => __('Mobile')]),
    StoreUserRequest::KEY_MOBILE . '.regex' => __('validation.regex', [
        'attribute' => __('Mobile'),
    ]),
    StoreUserRequest::KEY_MOBILE . '.unique' => __('validation.unique', ['attribute' => __('Mobile')]),
    StoreUserRequest::KEY_USERNAME . '.required' => __('validation.required', ['attribute' => __('Username')]),
    StoreUserRequest::KEY_USERNAME . '.string' => __('validation.string', ['attribute' => __('Username')]),
    StoreUserRequest::KEY_USERNAME . '.min' => __('validation.min.string', [
        'attribute' => __('Username'),
        'min' => StoreUserRequest::USERNAME_MIN_LENGTH,
    ]),
    StoreUserRequest::KEY_USERNAME . '.max' => __('validation.max.string', [
        'attribute' => __('Username'),
        'max' => StoreUserRequest::USERNAME_MAX_LENGTH,
    ]),
    StoreUserRequest::KEY_USERNAME . '.regex' => __('validation.regex', [
        'attribute' => __('Username'),
    ]),
    StoreUserRequest::KEY_USERNAME . '.unique' => __('validation.unique', ['attribute' => __('Username')]),
];
