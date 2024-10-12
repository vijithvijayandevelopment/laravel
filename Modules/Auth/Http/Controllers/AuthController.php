<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\JsonResponseTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Modules\Auth\Contracts\UserRepositoryInterface;
use Modules\Auth\Http\Requests\LoginUserRequest;
use Modules\Auth\Http\Requests\StoreUserRequest;
use Modules\Auth\Http\Resources\UserResource;

class AuthController extends Controller {

    use JsonResponseTrait;

    private const KEY_LOGIN_ACCESS_TOKEN = 'access_token';
    private const KEY_LOGIN_TOKEN_TYPE = 'token_type';
    private const KEY_LOGIN_USER = 'user';

    public function __construct(
            protected UserRepositoryInterface $userRepository
    ) {
        
    }

    /**
     * Display a listing of the resource.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        return $this->jsonResponse(null, Response::HTTP_OK, __('messages.method_not_supported'));
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
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse {

        $user = $this->userRepository->createUser($request->validated());

        if (!$user) {
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.no_data_found'));
        }

        return $this->jsonResponse(new UserResource($user), Response::HTTP_CREATED, __('messages.register_success'));
    }

    /**
     * Show the specified resource.
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse {
        return $this->jsonResponse(null, Response::HTTP_OK, __('messages.method_not_supported'));
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
     * @param StoreUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(StoreUserRequest $request, string $id): JsonResponse {
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

    /**
     * User Login.
     * 
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse {

        $user = $this->userRepository->loginUser($request);

        $data = [
            self::KEY_LOGIN_ACCESS_TOKEN => $user->createToken('auth_token')->plainTextToken,
            self::KEY_LOGIN_TOKEN_TYPE => config('app.api_token_type'),
            self::KEY_LOGIN_USER => new UserResource($user),
        ];

        return $this->jsonResponse($data, Response::HTTP_OK, __('messages.login_success'));
    }

    /**
     * Remove the current user token from storage.
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): ?JsonResponse {
        try {
            $request->user()->tokens()->delete();
            return $this->jsonResponse(null, Response::HTTP_OK, __('messages.logout_success'));
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }
}
