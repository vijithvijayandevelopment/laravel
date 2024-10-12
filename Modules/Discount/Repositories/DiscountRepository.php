<?php

namespace Modules\Discount\Repositories;

use App\Models\Discount;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Modules\Discount\Contracts\DiscountRepositoryInterface;
use Modules\Discount\Http\Requests\FilterDiscountRequest;

class DiscountRepository implements DiscountRepositoryInterface {

    /**
     * @Override
     * 
     * @param array $request
     * @return Collection
     */
    public function getDiscounts(array $request): Collection {
        try {

            $query = Discount::query();

            return $query->when(!empty($request[FilterDiscountRequest::KEY_NAME]), function ($q) use ($request) {
                                return $q->where(Discount::NAME, 'like', '%' . $request[FilterDiscountRequest::KEY_NAME] . '%');
                            })
                            ->when(!empty($request[FilterDiscountRequest::KEY_TYPE]), function ($q) use ($request) {
                                return $q->where(Discount::TYPE, $request[FilterDiscountRequest::KEY_TYPE]);
                            })
                            ->when(!empty($request[FilterDiscountRequest::KEY_MAX_USES]), function ($q) use ($request) {
                                return $q->where(Discount::MAX_USES, $request[FilterDiscountRequest::KEY_MAX_USES]);
                            })
                            ->when(!empty($request[FilterDiscountRequest::KEY_IS_ACTIVE]), function ($q) use ($request) {
                                return $q->where(Discount::IS_ACTIVE, $request[FilterDiscountRequest::KEY_IS_ACTIVE]);
                            })
                            ->when(!empty($request[FilterDiscountRequest::KEY_CREATED_BY]), function ($q) use ($request) {
                                return $q->where(Discount::CREATED_BY, $request[FilterDiscountRequest::KEY_CREATED_BY]);
                            })
                            ->when(!empty($request[FilterDiscountRequest::KEY_CREATED_AT]), function ($q) use ($request) {
                                return $q->whereDate(Discount::CREATED_AT, Carbon::createFromFormat('m-d-Y', $request[FilterDiscountRequest::KEY_CREATED_AT])->format('Y-m-d'));
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
     * @return Discount
     */
    public function getDiscount(string $id): ?Discount {
        try {
            return Discount::findOrFail($id);
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
     * @return Discount
     */
    public function createDiscount(array $request): ?Discount {
        try {
            return Discount::create($request);
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @Override
     * 
     * @param array $request
     * @return Discount
     */
    public function updateDiscount(array $request, string $id): ?Discount {
        try {
            return tap(Discount::findOrFail($id))?->update($request);
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @Override
     * 
     * @param string $id
     * @return bool
     */
    public function deleteDiscount(string $id): ?bool {
        try {
            Discount::findOrFail($id)?->delete();
            return true;
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }
}
