<?php

namespace Modules\Auth\Repositories;

use App\Enums\RoleType;
use App\Models\Role;
use App\Models\User;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Contracts\UserRepositoryInterface;
use Modules\Auth\Http\Requests\LoginUserRequest;

class UserRepository implements UserRepositoryInterface {

    /**
     * @Override
     * 
     * @param array $request
     * @return User
     */
    public function createUser(array $request): ?User {
        try {
            return DB::transaction(fn() => tap(User::create($request), fn($user) => $user->roles()->sync(Role::where(Role::NAME, RoleType::USER->label())->pluck(Role::ID)->toArray()))->load('roles'));
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @Override
     * 
     * @param array $request
     * @return User
     */
    public function loginUser(object $request): ?User {

        $identifier = $request->input(LoginUserRequest::KEY_IDENTIFIER);
        $password = $request->input(LoginUserRequest::KEY_PASSWORD);

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                User::EMAIL => $identifier,
                User::PASSWORD => $password,
            ];
        } elseif (preg_match('/^\+\d{1,3}\s?\d{1,14}$/', $identifier)) {
            $credentials = [
                User::MOBILE => $identifier,
                User::PASSWORD => $password,
            ];
        } elseif (preg_match('/^[a-zA-Z0-9_]+$/', $identifier)) {
            $credentials = [
                User::USERNAME => $identifier,
                User::PASSWORD => $password,
            ];
        } else {
            throw new InvalidArgumentException(__('messages.invalid_identifier'));
        }

        Auth::attempt($credentials) ?: throw ValidationException::withMessages([
                            LoginUserRequest::KEY_IDENTIFIER => [__('auth.failed')],
        ]);

        return Auth::user();
    }
}
