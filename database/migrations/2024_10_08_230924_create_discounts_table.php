<?php

use App\Enums\DiscountType;
use App\Enums\Status;
use App\Models\Discount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create(Discount::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->string(Discount::NAME);
            $table->enum(Discount::TYPE, collect(DiscountType::cases())->pluck('value')->toArray());
            $table->decimal(Discount::AMOUNT, 10, 2)->nullable();
            $table->decimal(Discount::RECURRING_AMOUNT, 10, 2)->nullable();
            $table->decimal(Discount::FAMILY_MEMBER_AMOUNT, 10, 2)->nullable();
            $table->unsignedInteger(Discount::MAX_USES)->default(1);
            $table->decimal(Discount::MAX_DISCOUNT_AMOUNT, 10, 2)->nullable();
            $table->decimal(Discount::PERCENTAGE, 5, 2)->nullable()->nullable();
            $table->decimal(Discount::RECURRING_PERCENTAGE, 5, 2)->nullable();
            $table->decimal(Discount::FAMILY_MEMBER_PERCENTAGE, 5, 2)->nullable();
            $table->enum(Discount::IS_ACTIVE, collect(Status::cases())->pluck('value')->toArray())->default(Status::ACTIVE->value);
            $table->unsignedBigInteger(Discount::CREATED_BY);
            $table->unsignedBigInteger(Discount::UPDATED_BY)->nullable();
            $table->dateTime(Discount::CREATED_AT)->useCurrent();
            $table->dateTime(Discount::UPDATED_AT)->nullable()->useCurrentOnUpdate();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists(Discount::getTableName());
    }
};
