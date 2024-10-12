<?php

namespace Modules\Discount\Traits;

use App\Enums\DiscountApplyStatus;
use App\Enums\DiscountType;
use App\Enums\FamilyMemberStatus;
use App\Enums\RecurringStatus;
use App\Enums\Status;
use App\Models\Booking;
use App\Models\Discount;
use Modules\Discount\Http\Resources\BookingResource;
use Modules\Discount\Http\Requests\StoreBookingRequest;

trait DiscountTrait {

    /**
     * Discount Logic.
     * 
     * @param array $request
     * @return array
     */
    public function discount(array $request): array {
        $bookings = collect($request[StoreBookingRequest::KEY_BOOKINGS]);
        $discounts = Discount::whereIn(Discount::ID, $request[StoreBookingRequest::KEY_DISCOUNT_IDS])
                ->where(Discount::IS_ACTIVE, Status::ACTIVE->value)
                ->get();

        $updatedBookings = $bookings->map(function ($booking, $index) use ($discounts) {
            $bookingAmount = $booking[Booking::PURCHASE_AMOUNT];
            $discountAmount = 0;
            $discountPercentage = 0;
            $isRecurring = RecurringStatus::NO->value;
            $isFamilyMemberApplied = FamilyMemberStatus::NO->value;

            $discount = $discounts[$index];

            if (static::isRecurringBooking($booking[Booking::USER_ID], $booking[Booking::APPLICATION_ID], $booking[Booking::BOOKING_ID], $booking[Booking::DISCOUNT_ID]) && $discount->max_uses > 0) {
                $isRecurring = RecurringStatus::YES->value;
                if ($discount->type == DiscountType::PERCENTAGE->value) {
                    $discountPercentage += $discount->recurring_percentage ?? 0;
                    $discountAmount += min(($bookingAmount * $discountPercentage) / 100, $discount->max_discount_amount);
                } else {
                    $discountAmount += min($discount->recurring_amount ?? 0, $discount->max_discount_amount);
                }
            }

            if ($isRecurring == RecurringStatus::NO->value && static::hasFamilyMemberDiscount($booking[Booking::FAMILY_MEMBER_ID], $booking[Booking::APPLICATION_ID], $booking[Booking::BOOKING_ID], $booking[Booking::DISCOUNT_ID]) && $discount->max_uses > 0) {
                $isFamilyMemberApplied = FamilyMemberStatus::YES->value;
                if ($discount->type == DiscountType::PERCENTAGE->value) {
                    $discountPercentage += $discount->family_member_percentage ?? 0;
                    $discountAmount += min(($bookingAmount * $discountPercentage) / 100, $discount->max_discount_amount);
                } else {
                    $discountAmount += min($discount->family_member_amount ?? 0, $discount->max_discount_amount);
                }
            }

            if ($isRecurring == RecurringStatus::NO->value && $isFamilyMemberApplied == FamilyMemberStatus::NO->value && $discount->max_uses > 0) {
                if ($discount->type == DiscountType::PERCENTAGE->value) {
                    $discountPercentage += $discount->percentage ?? 0;
                    $discountAmount += min(($bookingAmount * $discountPercentage) / 100, $discount->max_discount_amount);
                } else {
                    $discountAmount += min($discount->amount ?? 0, $discount->max_discount_amount);
                }
            }

            $booking[Booking::DISCOUNT_AMOUNT] = $discountAmount;
            $booking[Booking::DISCOUNT_PERCENTAGE] = $discountPercentage;
            $booking[Booking::IS_RECURRING] = (string) $isRecurring;
            $booking[BookingResource::KEY_IS_RECURRING_LABEL] = RecurringStatus::from($isRecurring)->label();
            $booking[Booking::IS_FAMILY_MEMBER_APPLIED] = (string) $isFamilyMemberApplied;
            $booking[BookingResource::KEY_IS_FAMILY_MEMBER_APPLIED_LABEL] = FamilyMemberStatus::from($isFamilyMemberApplied)->label();

            return $booking;
        });

        $response = [StoreBookingRequest::KEY_BOOKINGS => $updatedBookings];

        if ($request[StoreBookingRequest::KEY_APPLY] == DiscountApplyStatus::YES->value) {
            $response[StoreBookingRequest::KEY_DISCOUNT_IDS] = $request[StoreBookingRequest::KEY_DISCOUNT_IDS];
        }

        return $response;
    }

    /**
     * Check if a user has a recurring booking.
     *
     * @param int $userId
     * @param int $applicationId
     * @param int $bookingId
     * @param int $discountId
     * @return bool
     */
    private static function isRecurringBooking(int $userId, int $applicationId, int $bookingId, int $discountId): bool {

        return Booking::where(Booking::USER_ID, $userId)
                        ->where(Booking::APPLICATION_ID, $applicationId)
                        ->where(Booking::BOOKING_ID, '!=', $bookingId)
                        ->where(Booking::DISCOUNT_ID, $discountId)
                        ->exists();
    }

    /**
     * Check if a family member has previously purchased the same schedule.
     *
     * @param int|null $familyMemberId
     * @param int $applicationId
     * @param int $bookingId
     * @param int $discountId
     * @return bool
     */
    private static function hasFamilyMemberDiscount(?int $familyMemberId, int $applicationId, int $bookingId, int $discountId): bool {

        return Booking::where(Booking::USER_ID, $familyMemberId)
                        ->where(Booking::APPLICATION_ID, $applicationId)
                        ->where(Booking::BOOKING_ID, '!=', $bookingId)
                        ->where(Booking::DISCOUNT_ID, $discountId)
                        ->exists();
    }
}
