<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsersSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        try {
            DB::transaction(function () {
                User::updateOrCreate(
                        [User::EMAIL => config('app.admin_email')],
                        [
                            User::NAME => config('app.admin_name'),
                            User::MOBILE => config('app.admin_mobile'),
                            User::USERNAME => config('app.admin_username'),
                            User::PASSWORD => config('app.admin_password'),
                        ]
                )->roles()->sync(Role::where(Role::NAME, RoleType::ADMIN->label())->pluck(Role::ID)->toArray());
            });
        } catch (Exception $e) {
            Log::error(__('messages.seeder_error') . ' ' . User::getTableName() . ': ' . $e->getMessage());
        }
    }
}
