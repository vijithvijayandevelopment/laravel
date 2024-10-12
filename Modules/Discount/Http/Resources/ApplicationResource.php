<?php

namespace Modules\Discount\Http\Resources;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource {

    private const KEY_ID = 'id';
    private const KEY_APPLICATION_ID = 'application_id';
    private const KEY_APPLICATION_NAME = 'application_name';
    private const KEY_APPLICATION_API_KEY = 'application_api_key';
    private const KEY_USER_ID = 'user_id';
    private const KEY_IS_ACTIVE = 'is_active';
    private const KEY_ACTIVE_LABEL = 'active_label';
    private const KEY_CREATED_AT = 'created_at';
    private const KEY_UPDATED_AT = 'updated_at';

    /**
     * Transform the resource into an array.
     * @Override
     * 
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array {
        return ($this->resource instanceof Collection ? $this->resource : collect([$this]))->map(fn($platform) => $this->transform($platform))->toArray();
    }

    /**
     * Transform the resource into an array.
     * @Override
     * 
     * @param $value
     * @param $callback
     * @param $default
     * @return array
     */
    protected function transform($value, callable $callback = null, $default = null): array {
        return [
            self::KEY_ID => $value->id,
            self::KEY_APPLICATION_ID => $value->application_id,
            self::KEY_APPLICATION_NAME => $value->application_name,
            self::KEY_APPLICATION_API_KEY => $value->application_api_key,
            self::KEY_USER_ID => $value->user_id,
            self::KEY_IS_ACTIVE => $value->is_active,
            self::KEY_ACTIVE_LABEL => Status::from($value->is_active)->label(),
            self::KEY_CREATED_AT => $value->created_at,
            self::KEY_UPDATED_AT => $value->updated_at,
        ];
    }
}
