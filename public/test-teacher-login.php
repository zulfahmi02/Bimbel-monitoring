<?php
// Test Teacher Login
// Akses: https://monitor.pojoktic.my.id/test-teacher-login.php
// HAPUS FILE INI SETELAH SELESAI!

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

echo "<!DOCTYPE html><html><head><title>Test Teacher Login</title>";
echo "<style>body{font-family:Arial;padding:20px;} .error{color:red;} .success{color:green;} pre{background:#f4f4f4;padding:10px;border-radius:5px;}</style>";
echo "</head><body>";

echo "<h1>🧪 Test Teacher Login</h1><hr>";

$email = 'budi.santoso@padosilmu.com';
$password = 'password123';

echo "<h2>Testing Credentials:</h2>";
echo "<ul>";
echo "<li>Email: {$email}</li>";
echo "<li>Password: {$password}</li>";
echo "</ul>";

// Test 1: Cek apakah teacher ada di database
echo "<h2>Test 1: Cek Teacher di Database</h2>";
$teacher = App\Models\Teacher::where('email', $email)->first();

if (!$teacher) {
    echo "<p class='error'>❌ Teacher tidak ditemukan di database!</p>";
} else {
    echo "<p class='success'>✅ Teacher ditemukan:</p>";
    echo "<ul>";
    echo "<li>ID: {$teacher->id}</li>";
    echo "<li>Name: {$teacher->name}</li>";
    echo "<li>Email: {$teacher->email}</li>";
    echo "<li>Status: {$teacher->status}</li>";
    echo "<li>Password Hash: " . substr($teacher->password, 0, 30) . "...</li>";
    echo "</ul>";
    
    // Test 2: Cek password
    echo "<h2>Test 2: Verify Password</h2>";
    if (Hash::check($password, $teacher->password)) {
        echo "<p class='success'>✅ Password MATCH!</p>";
    } else {
        echo "<p class='error'>❌ Password TIDAK MATCH!</p>";
    }
    
    // Test 3: Attempt Login
    echo "<h2>Test 3: Attempt Login</h2>";
    $credentials = ['email' => $email, 'password' => $password];
    
    if (Auth::guard('teacher')->attempt($credentials)) {
        echo "<p class='success'>✅ Login BERHASIL!</p>";
        
        $loggedTeacher = Auth::guard('teacher')->user();
        echo "<ul>";
        echo "<li>Logged in as: {$loggedTeacher->name}</li>";
        echo "<li>Status: {$loggedTeacher->status}</li>";
        echo "</ul>";
        
        // Test 4: Cek status approval
        echo "<h2>Test 4: Status Approval Check</h2>";
        if ($loggedTeacher->status !== 'approved') {
            echo "<p class='error'>❌ Status BUKAN 'approved'! Status: {$loggedTeacher->status}</p>";
            echo "<p>User akan di-logout oleh controller...</p>";
        } else {
            echo "<p class='success'>✅ Status 'approved'! User bisa akses dashboard.</p>";
        }
        
        // Logout untuk cleanup
        Auth::guard('teacher')->logout();
        echo "<p><em>(User sudah di-logout untuk cleanup)</em></p>";
        
    } else {
        echo "<p class='error'>❌ Login GAGAL!</p>";
        echo "<p>Kemungkinan penyebab:</p>";
        echo "<ul>";
        echo "<li>Password tidak match</li>";
        echo "<li>Guard configuration salah</li>";
        echo "<li>Provider configuration salah</li>";
        echo "</ul>";
    }
}

echo "<h2>🔧 Auth Configuration:</h2>";
echo "<pre>";
echo "Guards:\n";
print_r(config('auth.guards'));
echo "\nProviders:\n";
print_r(config('auth.providers'));
echo "</pre>";

echo "<hr><p><strong>⚠️ IMPORTANT:</strong> Hapus file ini setelah selesai debugging!</p>";
echo "</body></html>";

$kernel->terminate($request, $response);
