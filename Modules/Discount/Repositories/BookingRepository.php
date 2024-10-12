<?php

namespace Modules\Discount\Repositories;

use App\Models\Booking;
use App\Models\Discount;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Discount\Contracts\BookingRepositoryInterface;
use Modules\Discount\Http\Resources\BookingResource;
use Modules\Discount\Http\Requests\FilterBookingRequest;
use Modules\Discount\Http\Requests\StoreBookingRequest;

class BookingRepository implements BookingRepositoryInterface {

    /**
     * @Override
     * 
     * @param array $request
     * @return Collection
     */
    public function getBookings(array $request): Collection {
        try {
            $query = Booking::query();

            return $query->when(!empty($request[FilterBookingRequest::KEY_APPLICATION_ID_FILTER]), function ($q) use ($request) {
                                return $q->where(Booking::APPLICATION_ID, $request[FilterBookingRequest::KEY_APPLICATION_ID_FILTER]);
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_BOOKING_ID]), function ($q) use ($request) {
                                return $q->where(Booking::BOOKING_ID, $request[FilterBookingRequest::KEY_BOOKING_ID]);
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_USER_NAME]), function ($q) use ($request) {
                                return $q->where(Booking::USER_NAME, 'like', '%' . $request[FilterBookingRequest::KEY_USER_NAME] . '%');
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_DISCOUNT_ID]), function ($q) use ($request) {
                                return $q->where(Booking::DISCOUNT_ID, $request[FilterBookingRequest::KEY_DISCOUNT_ID]);
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_STATUS]), function ($q) use ($request) {
                                return $q->where(Booking::STATUS, $request[FilterBookingRequest::KEY_STATUS]);
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_CREATED_AT]), function ($q) use ($request) {
                                return $q->whereDate(Booking::CREATED_AT, Carbon::createFromFormat('m-d-Y', $request[FilterBookingRequest::KEY_CREATED_AT])->format('Y-m-d'));
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_IS_RECURRING]), function ($q) use ($request) {
                                return $q->where(Booking::IS_RECURRING, $request[FilterBookingRequest::KEY_IS_RECURRING]);
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_IS_FAMILY_MEMBER_APPLIED]), function ($q) use ($request) {
                                return $q->where(Booking::IS_FAMILY_MEMBER_APPLIED, $request[FilterBookingRequest::KEY_IS_FAMILY_MEMBER_APPLIED]);
                            })
                            ->when(!empty($request[FilterBookingRequest::KEY_FAMILY_MEMBER_NAME]), function ($q) use ($request) {
                                return $q->where(Booking::FAMILY_MEMBER_NAME, 'like', '%' . $request[FilterBookingRequest::KEY_FAMILY_MEMBER_NAME] . '%');
                            })
                            ->get();
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * @Override
     * 
     * @param string $id
     * @return Booking
     */
    public function getBooking(string $id): ?Booking {
        try {
            return Booking::findOrFail($id);
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @Override
     * 
     * @param array $request
     * @param string $id
     * @return Collection
     */
    public function createBooking(array $request): Collection {

        try {

            $request[StoreBookingRequest::KEY_BOOKINGS] = collect($request[StoreBookingRequest::KEY_BOOKINGS])->map(function ($booking) {
                return collect($booking)->forget([
                    BookingResource::KEY_IS_RECURRING_LABEL,
                    BookingResource::KEY_IS_FAMILY_MEMBER_APPLIED_LABEL,
                ]);
            });

            DB::transaction(function () use ($request) {

                Booking::insert($request[StoreBookingRequest::KEY_BOOKINGS]->toArray());

                collect($request[StoreBookingRequest::KEY_DISCOUNT_IDS])->each(function ($discountId) {
                    $discount = Discount::find($discountId);
                    if ($discount && $discount->max_uses > 0) {
                        $discount->decrement(Discount::MAX_USES);
                    }
                });
            });

            return Booking::whereIn(Booking::BOOKING_ID, collect($request[StoreBookingRequest::KEY_BOOKINGS])->pluck(Booking::BOOKING_ID))->get();
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return collect();
        }
    }
}
