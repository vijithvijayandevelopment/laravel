<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        try {
            DB::transaction(function () {
                Role::updateOrCreate(
                        [Role::NAME => RoleType::ADMIN->label()],
                        [Role::NAME => RoleType::ADMIN->label()]
                );

                Role::updateOrCreate(
                        [Role::NAME => RoleType::USER->label()],
                        [Role::NAME => RoleType::USER->label()]
                );
            });
        } catch (Exception $e) {
            Log::error(__('messages.seeder_error') . ' ' . Role::getTableName() . ': ' . $e->getMessage());
        }
    }
}
