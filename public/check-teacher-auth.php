<?php
// Diagnostic untuk Teacher Login
// Akses: https://monitor.pojoktic.my.id/check-teacher-auth.php
// HAPUS FILE INI SETELAH SELESAI!

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

echo "<!DOCTYPE html><html><head><title>Teacher Auth Check</title>";
echo "<style>body{font-family:Arial;padding:20px;} table{border-collapse:collapse;width:100%;margin:20px 0;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#4CAF50;color:white;} .error{color:red;} .success{color:green;}</style>";
echo "</head><body>";

echo "<h1>🔍 Teacher Authentication Check</h1><hr>";

// Cek apakah teacher sudah login
$teacher = Auth::guard('teacher')->user();

if (!$teacher) {
    echo "<p class='error'>❌ Tidak ada teacher yang login.</p>";
    echo "<p><a href='/teacher/login'>Login sebagai Teacher</a></p>";
    
    echo "<h2>📋 Daftar Teacher di Database:</h2>";
    $teachers = App\Models\Teacher::all();
    
    if ($teachers->isEmpty()) {
        echo "<p class='error'>⚠️ Tidak ada teacher di database!</p>";
    } else {
        echo "<table>";
        echo "<tr><th>ID</th><th>ID Type</th><th>Name</th><th>Email</th><th>Status</th><th>Password (hashed)</th></tr>";
        foreach ($teachers as $t) {
            echo "<tr>";
            echo "<td>{$t->id}</td>";
            echo "<td>" . gettype($t->id) . "</td>";
            echo "<td>{$t->name}</td>";
            echo "<td>{$t->email}</td>";
            echo "<td>{$t->status}</td>";
            echo "<td>" . substr($t->password, 0, 20) . "...</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<h3>Test Login Credentials:</h3>";
        echo "<ul>";
        echo "<li>Email: budi.santoso@padosilmu.com</li>";
        echo "<li>Password: password123</li>";
        echo "<li>Status: approved</li>";
        echo "</ul>";
    }
} else {
    echo "<h2 class='success'>✅ Teacher yang Login:</h2>";
    echo "<table>";
    echo "<tr><th>Field</th><th>Value</th><th>Type</th></tr>";
    echo "<tr><td>ID</td><td>{$teacher->id}</td><td>" . gettype($teacher->id) . "</td></tr>";
    echo "<tr><td>Name</td><td>{$teacher->name}</td><td>" . gettype($teacher->name) . "</td></tr>";
    echo "<tr><td>Email</td><td>{$teacher->email}</td><td>" . gettype($teacher->email) . "</td></tr>";
    echo "<tr><td>Status</td><td>{$teacher->status}</td><td>" . gettype($teacher->status) . "</td></tr>";
    echo "</table>";
    
    echo "<h2>🔐 Auth Guard Check:</h2>";
    echo "<table>";
    echo "<tr><th>Guard</th><th>Authenticated?</th><th>User</th></tr>";
    
    $guards = ['web', 'teacher', 'parent'];
    foreach ($guards as $guard) {
        $isAuth = Auth::guard($guard)->check();
        $user = Auth::guard($guard)->user();
        echo "<tr>";
        echo "<td>{$guard}</td>";
        echo "<td>" . ($isAuth ? '✅ YES' : '❌ NO') . "</td>";
        echo "<td>" . ($user ? $user->name : 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<h2>⚙️ Session Configuration:</h2>";
echo "<table>";
echo "<tr><th>Config</th><th>Value</th></tr>";
echo "<tr><td>Session Driver</td><td>" . config('session.driver') . "</td></tr>";
echo "<tr><td>Session Cookie</td><td>" . config('session.cookie') . "</td></tr>";
echo "<tr><td>Session Domain</td><td>" . (config('session.domain') ?: 'null') . "</td></tr>";
echo "<tr><td>Session Secure</td><td>" . (config('session.secure') ? 'true' : 'false') . "</td></tr>";
echo "</table>";

echo "<h2>📊 Current Session Data:</h2>";
echo "<pre>";
print_r(session()->all());
echo "</pre>";

echo "<hr><p><strong>⚠️ IMPORTANT:</strong> Hapus file ini setelah selesai debugging!</p>";
echo "</body></html>";

$kernel->terminate($request, $response);
