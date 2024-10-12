<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginUserRequest extends FormRequest {

    public const KEY_IDENTIFIER = 'identifier';
    public const KEY_PASSWORD = 'password';
    public const IDENTIFIER_MIN_LENGTH = 3;
    public const IDENTIFIER_MAX_LENGTH = 255;

    /**
     * Determine if the user is authorized to make this request.
     * @Override
     * 
     * @return bool
     */
    public function authorize(): bool {
        return $this->isMethod('POST');
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
                self::KEY_IDENTIFIER => [
                    'required',
                    'string',
                    'min:' . self::IDENTIFIER_MIN_LENGTH . '',
                    'max:' . self::IDENTIFIER_MAX_LENGTH . '',
                    'regex:/^[\w\.-]+@[\w\.-]+\.\w+$|^\+\d{1,3}\s?\d{1,14}$|^[a-zA-Z0-9_]+$/'
                ],
                self::KEY_PASSWORD => [
                    'required',
                    'string',
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
        return trans('login-user-validation');
    }
}
