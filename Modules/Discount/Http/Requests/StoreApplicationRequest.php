<?php

namespace Modules\Discount\Http\Requests;

use App\Enums\Status;
use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class StoreApplicationRequest extends FormRequest {

    public const KEY_APPLICATION_ID = 'application_id';
    public const KEY_APPLICATION_NAME = 'application_name';
    public const KEY_APPLICATION_API_KEY = 'application_api_key';
    public const KEY_USER_ID = 'user_id';
    public const KEY_IS_ACTIVE = 'is_active';
    public const APPLICATION_NAME_MIN_LENGTH = 3;
    public const APPLICATION_NAME_MAX_LENGTH = 255;
    public const APPLICATION_API_KEY_LENGTH = 255;
    public const APPLICATION_ID_LENGTH = 16;

    /**
     * Determine if the user is authorized to make this request.
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
                self::KEY_APPLICATION_ID => [
                    'required',
                    'integer',
                    'digits:' . self::APPLICATION_ID_LENGTH,
                    'unique:' . Application::getTableName()
                ],
                self::KEY_APPLICATION_NAME => [
                    'required',
                    'string',
                    'min:' . self::APPLICATION_NAME_MIN_LENGTH,
                    'max:' . self::APPLICATION_NAME_MAX_LENGTH,
                ],
                self::KEY_APPLICATION_API_KEY => [
                    'required',
                    'string',
                    'size:' . self::APPLICATION_API_KEY_LENGTH,
                    'unique:' . Application::getTableName()
                ],
                self::KEY_USER_ID => [
                    'required',
                    'exists:' . User::getTableName() . ',' . User::ID,
                ],
                self::KEY_IS_ACTIVE => [
                    'required',
                    'boolean',
                    Rule::in(Status::cases()),
                ],
            ],
            'PUT', 'PATCH' => [
                self::KEY_APPLICATION_NAME => [
                    'required',
                    'string',
                    'min:' . self::APPLICATION_NAME_MIN_LENGTH,
                    'max:' . self::APPLICATION_NAME_MAX_LENGTH,
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
        return trans('store-application-validation');
    }

    /**
     * Prepare the data for storage.
     * @Override
     * 
     * @return void
     */
    protected function prepareForValidation(): void {

        $this->isMethod('POST') && $this->merge([
                    self::KEY_USER_ID => auth()->id(),
                    self::KEY_APPLICATION_ID => $this->generateUniqueApplicationId(),
                    self::KEY_APPLICATION_API_KEY => $this->generateUniqueApiKey(),
        ]);
    }

    protected function generateUniqueApplicationId(): int {
        do {
            $min = 10 ** (self::APPLICATION_ID_LENGTH - 1);
            $max = (10 ** self::APPLICATION_ID_LENGTH) - 1;

            $applicationId = mt_rand($min, $max);
        } while (Application::where(Application::APPLICATION_ID, $applicationId)->exists());

        return $applicationId;
    }

    protected function generateUniqueApiKey(): string {
        do {
            $apiKey = Str::random(self::APPLICATION_API_KEY_LENGTH);
        } while (Application::where(Application::APPLICATION_API_KEY, $apiKey)->exists());

        return $apiKey;
    }
}
