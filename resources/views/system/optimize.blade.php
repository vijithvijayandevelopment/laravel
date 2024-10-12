<?php

use Illuminate\Support\Facades\Artisan;

try {
    Artisan::call('optimize');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    echo "Optimization completed successfully.\n";
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}
