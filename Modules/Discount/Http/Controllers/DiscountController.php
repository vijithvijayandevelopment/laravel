<?php

namespace Modules\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\JsonResponseTrait;
use Modules\Discount\Contracts\DiscountRepositoryInterface;
use Modules\Discount\Http\Requests\FilterDiscountRequest;
use Modules\Discount\Http\Requests\StoreDiscountRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Discount\Http\Resources\DiscountResource;

class DiscountController extends Controller {

    use JsonResponseTrait;

    public function __construct(
            protected DiscountRepositoryInterface $discountRepository
    ) {
        
    }

    /**
     * Display a listing of the resource.
     * 
     * @param FilterDiscountRequest $request
     * @return JsonResponse
     */
    public function index(FilterDiscountRequest $request): JsonResponse {

        $data = $this->discountRepository->getDiscounts($request->validated());

        if ($data->isEmpty()) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new DiscountResource($data), Response::HTTP_OK, __('messages.get_all_discounts_success'));
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
     * @param StoreDiscountRequest $request
     * @return JsonResponse
     */
    public function store(StoreDiscountRequest $request): JsonResponse {

        $data = $this->discountRepository->createDiscount($request->validated());

        if (!$data) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new DiscountResource($data), Response::HTTP_CREATED, __('messages.create_discount_success'));
    }

    /**
     * Show the specified resource.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse {

        $data = $this->discountRepository->getDiscount($id);

        if (!$data) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new DiscountResource($data), Response::HTTP_OK, __('messages.get_discount_success'));
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
     * @param StoreDiscountRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreDiscountRequest $request, string $id): JsonResponse {

        $data = $this->discountRepository->updateDiscount($request->validated(), $id);

        if (!$data) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new DiscountResource($data), Response::HTTP_OK, __('messages.update_discount_success'));
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse {
        return $this->jsonResponse($this->discountRepository->deleteDiscount($id), Response::HTTP_OK, __('messages.delete_discount_success'));
    }
}
