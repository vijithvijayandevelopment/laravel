<?php

namespace Modules\Auth\Contracts;

use App\Models\User;

interface UserRepositoryInterface {

    public function createUser(array $request): ?User;

    public function loginUser(object $request): ?User;
}
