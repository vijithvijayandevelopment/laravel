<?php

use App\Enums\Status;
use App\Models\Application;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create(Application::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Application::APPLICATION_ID)->unique();
            $table->string(Application::APPLICATION_NAME);
            $table->string(Application::APPLICATION_API_KEY)->unique();
            $table->foreignId(Application::USER_ID)->constrained()->onDelete('cascade');
            $table->enum(Application::IS_ACTIVE, collect(Status::cases())->pluck('value')->toArray())->default(Status::ACTIVE->value);
            $table->dateTime(Application::CREATED_AT)->useCurrent();
            $table->dateTime(Application::UPDATED_AT)->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    public function down() {
        Schema::dropIfExists(Platform::getTableName());
    }
};
