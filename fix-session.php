<?php
// Fix Session Configuration
// Akses: https://monitor.pojoktic.my.id/fix-session.php
// HAPUS FILE INI SETELAH SELESAI!

echo "<!DOCTYPE html><html><head><title>Fix Session Config</title></head><body>";
echo "<h1>🔧 Fixing Session Configuration...</h1><hr>";

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    echo "<p style='color:red;'>❌ File .env tidak ditemukan!</p>";
    exit;
}

$envContent = file_get_contents($envFile);

// Backup .env
$backupFile = __DIR__ . '/.env.backup.' . date('YmdHis');
file_put_contents($backupFile, $envContent);
echo "<p>✅ Backup .env dibuat: " . basename($backupFile) . "</p>";

// Update session config
$updates = [
    'SESSION_DRIVER' => 'file',
    'SESSION_LIFETIME' => '120',
    'SESSION_ENCRYPT' => 'false',
    'SESSION_PATH' => '/',
    'SESSION_DOMAIN' => 'null',
    'SESSION_SECURE_COOKIE' => 'false',
    'SESSION_HTTP_ONLY' => 'true',
    'SESSION_SAME_SITE' => 'lax',
];

foreach ($updates as $key => $value) {
    // Check if key exists
    if (preg_match("/^{$key}=/m", $envContent)) {
        // Update existing
        $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
        echo "<p>✅ Updated: {$key}={$value}</p>";
    } else {
        // Add new
        $envContent .= "\n{$key}={$value}";
        echo "<p>✅ Added: {$key}={$value}</p>";
    }
}

// Write updated .env
file_put_contents($envFile, $envContent);

echo "<hr>";
echo "<h2 style='color:green;'>✅ Session configuration updated!</h2>";
echo "<p><strong>Changes made:</strong></p>";
echo "<ul>";
echo "<li>SESSION_DRIVER changed to 'file' (more reliable on shared hosting)</li>";
echo "<li>SESSION_SECURE_COOKIE set to 'false' (for HTTP testing)</li>";
echo "<li>Other session configs optimized</li>";
echo "</ul>";

echo "<p><strong>Next steps:</strong></p>";
echo "<ol>";
echo "<li>Clear cache: <a href='/clear-all.php'>Run clear-all.php</a></li>";
echo "<li>Clear browser cache (Ctrl+Shift+Delete)</li>";
echo "<li>Try login again at <a href='/teacher/login'>/teacher/login</a></li>";
echo "<li><strong>DELETE THIS FILE (fix-session.php) NOW!</strong></li>";
echo "</ol>";

echo "<p><em>Backup file: {$backupFile}</em></p>";

echo "</body></html>";
