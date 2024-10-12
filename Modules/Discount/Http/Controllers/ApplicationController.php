<?php

namespace Modules\Discount\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\JsonResponseTrait;
use Modules\Discount\Contracts\ApplicationRepositoryInterface;
use Modules\Discount\Http\Requests\StoreApplicationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Modules\Discount\Http\Resources\ApplicationResource;

class ApplicationController extends Controller {

    use JsonResponseTrait;

    public function __construct(
            protected ApplicationRepositoryInterface $applicationRepository
    ) {
        
    }

    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse {

        $data = $this->applicationRepository->getApplications();

        if ($data->isEmpty()) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new ApplicationResource($data), Response::HTTP_OK, __('messages.get_all_applications_success'));
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
     * @param StoreApplicationRequest $request
     * @return JsonResponse
     */
    public function store(StoreApplicationRequest $request): JsonResponse {

        $data = $this->applicationRepository->createApplication($request->validated());

        if (!$data) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new ApplicationResource($data), Response::HTTP_CREATED, __('messages.create_application_success'));
    }

    /**
     * Show the specified resource.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse {

        $data = $this->applicationRepository->getApplication($id);

        if (!$data) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new ApplicationResource($data), Response::HTTP_OK, __('messages.get_application_success'));
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
     * @param StoreApplicationRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreApplicationRequest $request, string $id): JsonResponse {

        $data = $this->applicationRepository->updateApplication($request->validated(), $id);

        if (!$data) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new ApplicationResource($data), Response::HTTP_OK, __('messages.update_application_success'));
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse {
        return $this->jsonResponse($this->applicationRepository->deleteApplication($id), Response::HTTP_OK, __('messages.delete_application_success'));
    }
}
