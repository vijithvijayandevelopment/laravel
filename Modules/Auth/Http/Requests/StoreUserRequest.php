<?php

namespace Modules\Auth\Http\Requests;

use App\Enums\Status;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest {

    public const KEY_NAME = 'name';
    public const KEY_EMAIL = 'email';
    public const KEY_MOBILE = 'mobile';
    public const KEY_USERNAME = 'username';
    public const KEY_PASSWORD = 'password';
    public const KEY_IS_ACTIVE = 'is_active';
    public const NAME_MIN_LENGTH = 3;
    public const NAME_MAX_LENGTH = 255;
    public const EMAIL_MIN_LENGTH = 3;
    public const EMAIL_MAX_LENGTH = 255;
    public const USERNAME_MIN_LENGTH = 3;
    public const USERNAME_MAX_LENGTH = 255;
    public const PASSWORD_MIN_LENGTH = 8;

    /**
     * Determine if the user is authorized to make this request.
     * @Override
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
            'POST' => [
                self::KEY_NAME => [
                    'required',
                    'string',
                    'min:' . self::NAME_MIN_LENGTH,
                    'max:' . self::NAME_MAX_LENGTH,
                    'regex:/^[a-zA-Z0-9\s]+$/',
                ],
                self::KEY_EMAIL => [
                    'required',
                    'string',
                    'email',
                    'min:' . self::EMAIL_MIN_LENGTH,
                    'max:' . self::EMAIL_MAX_LENGTH,
                    'unique:' . User::getTableName(),
                ],
                self::KEY_PASSWORD => [
                    'required',
                    'string',
                    'min:' . self::PASSWORD_MIN_LENGTH,
                    'confirmed',
                ],
                self::KEY_MOBILE => [
                    'required',
                    'string',
                    'regex:/^\+\d{1,3}\s?\d{1,14}$/',
                    'unique:' . User::getTableName(),
                ],
                self::KEY_USERNAME => [
                    'required',
                    'string',
                    'min:' . self::NAME_MIN_LENGTH,
                    'max:' . self::NAME_MAX_LENGTH,
                    'regex:/^[a-zA-Z0-9_]+$/',
                    'unique:' . User::getTableName(),
                ],
                self::KEY_IS_ACTIVE => [
                    'required',
                    'boolean',
                    Rule::in(Status::cases()),
                ],
            ],
            'PUT', 'PATCH' => [
                self::KEY_NAME => [
                    'required',
                    'string',
                    'min:' . self::NAME_MIN_LENGTH,
                    'max:' . self::NAME_MAX_LENGTH,
                    'regex:/^[a-zA-Z0-9\s]+$/',
                ],
                self::KEY_EMAIL => [
                    'required',
                    'string',
                    'email',
                    'min:' . self::EMAIL_MIN_LENGTH,
                    'max:' . self::EMAIL_MAX_LENGTH,
                    'unique:' . User::getTableName() . ',' . User::EMAIL . ',' . $this->user()->id,
                ],
                self::KEY_PASSWORD => [
                    'present',
                    'nullable',
                    'string',
                    'min:' . self::PASSWORD_MIN_LENGTH,
                    'confirmed',
                ],
                self::KEY_USERNAME => [
                    'required',
                    'string',
                    'min:' . self::USERNAME_MIN_LENGTH,
                    'max:' . self::USERNAME_MAX_LENGTH,
                    'regex:/^[a-zA-Z0-9_]+$/',
                    'unique:' . User::getTableName() . ',' . User::USERNAME . ',' . $this->user()->id,
                ],
                self::KEY_IS_ACTIVE => [
                    'required',
                    'boolean',
                    Rule::in(Status::cases()),
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
        return trans('store-user-validation');
    }

    /**
     * Prepare the data for validation.
     * @Override
     * 
     * @return void
     */
    protected function prepareForValidation(): void {
        $this->merge([
            self::KEY_IS_ACTIVE => $this->input(self::KEY_IS_ACTIVE, Status::ACTIVE->value),
        ]);
    }
}
