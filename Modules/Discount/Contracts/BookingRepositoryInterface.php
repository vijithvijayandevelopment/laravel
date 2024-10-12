<?php

namespace Modules\Discount\Contracts;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

interface BookingRepositoryInterface {

    public function getBookings(array $request): Collection;

    public function getBooking(string $id): ?Booking;

    public function createBooking(array $request): Collection;
}
