<?php

namespace Modules\Discount\Http\Requests;

use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class GetBookingRequest extends FormRequest {

    public const KEY_APPLICATION_ID = 'application_id';
    public const KEY_APPLICATION_API_KEY = 'application_api_key';
    public const HEADER_KEY_APPLICATION_ID = 'Application-ID';
    public const HEADER_KEY_APPLICATION_API_KEY = 'Application-API-Key';

    /**
     * Determine if the user is authorized to make this request.
     * @Override
     * 
     * @return bool
     */
    public function authorize(): bool {
        return $this->isMethod('GET');
    }

    /**
     * Get the validation rules that apply to the request.
     * @Override
     * 
     * @return array
     */
    public function rules(): array {
        return match ($this->method()) {
            'GET' => [
                self::KEY_APPLICATION_ID => [
                    'required',
                    'exists:' . Application::getTableName() . ',' . Application::APPLICATION_ID,
                ],
                self::KEY_APPLICATION_API_KEY => [
                    'required',
                    'exists:' . Application::getTableName() . ',' . Application::APPLICATION_API_KEY,
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
        return trans('get-booking-validation');
    }

    /**
     * Prepare the data for storage.
     * @Override
     * 
     * @return void
     */
    protected function prepareForValidation(): void {

        $this->merge([
            self::KEY_APPLICATION_ID => $this->header(self::HEADER_KEY_APPLICATION_ID),
            self::KEY_APPLICATION_API_KEY => $this->header(self::HEADER_KEY_APPLICATION_API_KEY),
        ]);
    }
}
