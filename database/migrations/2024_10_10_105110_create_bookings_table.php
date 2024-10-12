<?php

use App\Enums\BookingStatus;
use App\Enums\FamilyMemberStatus;
use App\Enums\RecurringStatus;
use App\Models\Booking;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
        Schema::create(Booking::getTableName(), function (Blueprint $table) {
            $table->id();
            $table->foreignId(Booking::APPLICATION_ID)->constrained()->onDelete('cascade');
            $table->unsignedBigInteger(Booking::BOOKING_ID);
            $table->unsignedBigInteger(Booking::USER_ID);
            $table->string(Booking::USER_NAME);
            $table->foreignId(Booking::DISCOUNT_ID)->constrained()->onDelete('cascade');
            $table->decimal(Booking::PURCHASE_AMOUNT, 10, 2)->default(0);
            $table->decimal(Booking::DISCOUNT_AMOUNT, 10, 2)->default(0);
            $table->decimal(Booking::DISCOUNT_PERCENTAGE, 5, 2)->nullable();
            $table->enum(Booking::IS_RECURRING, collect(RecurringStatus::cases())->pluck('value')->toArray())->default(RecurringStatus::NO->value);
            $table->enum(Booking::IS_FAMILY_MEMBER_APPLIED, collect(FamilyMemberStatus::cases())->pluck('value')->toArray())->default(FamilyMemberStatus::NO->value);
            $table->unsignedBigInteger(Booking::FAMILY_MEMBER_ID)->nullable();
            $table->string(Booking::FAMILY_MEMBER_NAME)->nullable();
            $table->enum(Booking::STATUS, collect(BookingStatus::cases())->pluck('value')->toArray())->default(BookingStatus::COMPLETED->value);
            $table->dateTime(Booking::CREATED_AT)->useCurrent();
            $table->dateTime(Booking::UPDATED_AT)->nullable()->useCurrentOnUpdate();
        });
    }

    public function down() {
        Schema::dropIfExists(Booking::getTableName());
    }
};
