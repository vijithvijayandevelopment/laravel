<?php

namespace Modules\Discount\Contracts;

use App\Models\Application;
use Illuminate\Database\Eloquent\Collection;

interface ApplicationRepositoryInterface {

    public function getApplications(): Collection;

    public function getApplication(string $id): ?Application;

    public function createApplication(array $request): ?Application;

    public function updateApplication(array $request, string $id): ?Application;

    public function deleteApplication(string $id): ?bool;
}
