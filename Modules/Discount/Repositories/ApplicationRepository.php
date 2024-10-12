<?php

namespace Modules\Discount\Repositories;

use App\Models\Application;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Discount\Contracts\ApplicationRepositoryInterface;

class ApplicationRepository implements ApplicationRepositoryInterface {

    /**
     * @Override
     * 
     * @return Collection
     */
    public function getApplications(): Collection {
        try {
            return Application::all();
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * @Override
     * 
     * @param string $id
     * @return Application
     */
    public function getApplication(string $id): ?Application {
        try {
            return Application::findOrFail($id);
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
     * @return Application
     */
    public function createApplication(array $request): ?Application {
        try {
            return Application::create($request);
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }

    /**
     * @Override
     * 
     * @param array $request
     * @return Platform
     */
    public function updateApplication(array $request, string $id): ?Application {
        try {
            return tap(Application::findOrFail($id))?->update($request);
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
    public function deleteApplication(string $id): ?bool {
        try {
            Application::findOrFail($id)?->delete();
            return true;
        } catch (Exception $e) {
            Log::error(__('messages.error') . ': ' . $e->getMessage());
            return null;
        }
    }
}
