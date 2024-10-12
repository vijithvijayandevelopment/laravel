<?php

namespace Modules\Auth\Http\Resources;

use App\Enums\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    private const KEY_ID = 'id';
    private const KEY_NAME = 'name';
    private const KEY_EMAIL = 'email';
    private const KEY_MOBILE = 'mobile';
    private const KEY_USERNAME = 'username';
    private const KEY_CREATED_AT = 'created_at';
    private const KEY_UPDATED_AT = 'updated_at';
    private const KEY_IS_ACTIVE = 'is_active';
    private const KEY_ACTIVE_LABEL = 'active_label';
    private const KEY_ROLES = 'roles';
    private const KEY_ROLE_ID = 'id';
    private const KEY_ROLE_NAME = 'name';

    /**
     * Transform the resource into an array.
     * @Override
     * 
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array {

        return [
            self::KEY_ID => $this->id,
            self::KEY_NAME => $this->name,
            self::KEY_EMAIL => $this->email,
            self::KEY_MOBILE => $this->mobile,
            self::KEY_USERNAME => $this->username,
            self::KEY_CREATED_AT => $this->created_at,
            self::KEY_UPDATED_AT => $this->updated_at,
            self::KEY_IS_ACTIVE => $this->is_active,
            self::KEY_ACTIVE_LABEL => Status::from($this->is_active)->label(),
            self::KEY_ROLES => $this->roles->map(function ($role) {
                return [
            self::KEY_ROLE_ID => $role->id,
            self::KEY_ROLE_NAME => $role->name,
                ];
            }),
        ];
    }
}
