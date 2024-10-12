<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create(Role::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string(Role::NAME)->unique();
            $table->dateTime(Role::CREATED_AT)->useCurrent();
            $table->dateTime(Role::UPDATED_AT)->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists(Role::getTableName());
    }
};
