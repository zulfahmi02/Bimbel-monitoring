<?php
// Clear All Caches - Quick Fix for 419 Error
// Akses: https://monitor.pojoktic.my.id/clear-all.php
// HAPUS FILE INI SETELAH SELESAI!

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<!DOCTYPE html><html><head><title>Clear All Caches</title></head><body>";
echo "<h1>🧹 Clearing All Caches...</h1><hr>";

try {
    echo "<p>✅ Clearing config cache...</p>";
    $kernel->call('config:clear');
    
    echo "<p>✅ Clearing application cache...</p>";
    $kernel->call('cache:clear');
    
    echo "<p>✅ Clearing route cache...</p>";
    $kernel->call('route:clear');
    
    echo "<p>✅ Clearing view cache...</p>";
    $kernel->call('view:clear');
    
    echo "<hr>";
    echo "<h2 style='color: green;'>✅ All caches cleared!</h2>";
    echo "<p><strong>Next steps:</strong></p>";
    echo "<ol>";
    echo "<li>Clear your browser cache (Ctrl+Shift+Delete)</li>";
    echo "<li>Open incognito/private window</li>";
    echo "<li>Try login again at <a href='/teacher/login'>/teacher/login</a></li>";
    echo "<li><strong>DELETE THIS FILE (clear-all.php) NOW!</strong></li>";
    echo "</ol>";
} catch (Exception $e) {
    echo "<h2 style='color: red;'>❌ Error:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}

echo "</body></html>";
