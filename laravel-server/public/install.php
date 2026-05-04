<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/**
 * QuizLOS Deployment Helper for InfinityFree
 * This script runs migrations, seeders, and creates storage links.
 */

// 1. Basic Security: Check for a 'token' in the URL to prevent unauthorized access
$secretToken = "qlos_deploy_2026"; // You can change this
if (!isset($_GET['token']) || $_GET['token'] !== $secretToken) {
    die("Unauthorized access. Please provide the correct token.");
}

// 2. Fix for "Please provide a valid cache path" on InfinityFree
// Create missing storage directories before Laravel boots
$storageDirs = [
    __DIR__.'/../storage/app/public',
    __DIR__.'/../storage/framework/cache',
    __DIR__.'/../storage/framework/cache/data',
    __DIR__.'/../storage/framework/sessions',
    __DIR__.'/../storage/framework/views',
    __DIR__.'/../storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Load Laravel Environment
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

echo "<h2>QuizLOS Deployment Helper</h2>";

try {
    // A. Run Migrations
    echo "Running Migrations (Fresh)... ";
    Artisan::call('migrate:fresh', ['--force' => true]);
    echo "Done.<br>";

    // B. Run Seeders
    echo "Running Seeders... ";
    Artisan::call('db:seed', ['--force' => true]);
    echo "Done.<br>";

    // C. Create Storage Link
    echo "Creating Storage Link... ";
    // InfinityFree often has issues with symlinks, we'll try artisan first
    Artisan::call('storage:link');
    echo "Done.<br>";

    echo "<br><b style='color:green'>Deployment Tasks Completed Successfully!</b>";
    echo "<br>Please delete this file (public/install.php) for security.";

} catch (\Exception $e) {
    echo "<br><b style='color:red'>Error:</b> " . $e->getMessage();
}
