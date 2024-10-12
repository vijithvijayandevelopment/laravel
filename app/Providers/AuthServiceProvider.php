<?php

namespace App\Providers;

use App\Enums\RoleType;
use App\Models\Role;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider {

    protected $policies = [];

    public const IS_ADMIN = 'is-admin';

    public function boot(): void {
        // Define a gate for admin access
        Gate::define(self::IS_ADMIN, function ($user) {
            return $user->roles()->where(Role::NAME, RoleType::ADMIN->label())->exists();
        });
    }
}
