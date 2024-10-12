<?php

namespace Modules\Discount\Contracts;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Collection;

interface DiscountRepositoryInterface {

    public function getDiscounts(array $request): Collection;

    public function getDiscount(string $id): ?Discount;

    public function createDiscount(array $request): ?Discount;

    public function updateDiscount(array $request, string $id): ?Discount;

    public function deleteDiscount(string $id): ?bool;
}
