<?php

namespace Modules\Discount\Http\Controllers;

use App\Enums\DiscountApplyStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\JsonResponseTrait;
use Modules\Discount\Contracts\BookingRepositoryInterface;
use Modules\Discount\Http\Requests\FilterBookingRequest;
use Modules\Discount\Http\Requests\GetBookingRequest;
use Modules\Discount\Http\Requests\StoreBookingRequest;
use Modules\Discount\Traits\DiscountTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Discount\Http\Resources\BookingResource;

class BookingController extends Controller {

    public const MESSAGE_DISCOUNT_APPLIED = 'messages.create_booking_success';
    public const MESSAGE_DISCOUNT_FETCHED = 'messages.get_discount_details_success';

    use JsonResponseTrait,
        DiscountTrait;

    public function __construct(
            protected BookingRepositoryInterface $bookingRepository
    ) {
        
    }

    /**
     * Display a listing of the resource.
     * 
     * @param FilterBookingtRequest $request
     * @return JsonResponse
     */
    public function index(FilterBookingRequest $request): JsonResponse {

        $data = $this->bookingRepository->getBookings($request->validated());

        if ($data->isEmpty()) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new BookingResource($data), Response::HTTP_OK, __('messages.get_all_bookings_success'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return JsonResponse
     */
    public function create(): JsonResponse {
        return $this->jsonResponse(null, Response::HTTP_OK, __('messages.method_not_supported'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param StoreBookingRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookingRequest $request): JsonResponse {

        $response = $this->discount($request->all());

        $message = self::MESSAGE_DISCOUNT_FETCHED;
        $responseCode = Response::HTTP_OK;

        if ($request[StoreBookingRequest::KEY_APPLY] == DiscountApplyStatus::YES->value) {
            $data = $this->bookingRepository->createBooking($response);
            $response = new BookingResource($data);
            $message = self::MESSAGE_DISCOUNT_APPLIED;
            $responseCode = Response::HTTP_CREATED;

            if (!$data) {
                return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
            }
        }

        return $this->jsonResponse($response, $responseCode, __($message));
    }

    /**
     * Show the specified resource.
     * 
     * @param int $id
     * @param StoreBookingRequest $request
     * @return JsonResponse
     */
    public function show(string $id, GetBookingRequest $request): JsonResponse {

        $data = $this->bookingRepository->getBooking($id);

        if (!$data) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new BookingResource($data), Response::HTTP_OK, __('messages.get_booking_success'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function edit(string $id): JsonResponse {
        return $this->jsonResponse(null, Response::HTTP_OK, __('messages.method_not_supported'));
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param StoreBookingRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreBookingRequest $request, string $id): JsonResponse {

        return $this->jsonResponse(null, Response::HTTP_OK, __('messages.method_not_supported'));
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse {
        return $this->jsonResponse(null, Response::HTTP_OK, __('messages.method_not_supported'));
    }
}
