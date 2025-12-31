<?php
// Diagnostic untuk cek relasi Parent-Student
// Akses: https://monitor.pojoktic.my.id/check-parent-student.php
// HAPUS FILE INI SETELAH SELESAI!

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

echo "<!DOCTYPE html><html><head><title>Parent-Student Check</title>";
echo "<style>body{font-family:Arial;padding:20px;} table{border-collapse:collapse;width:100%;} th,td{border:1px solid #ddd;padding:8px;text-align:left;} th{background:#4CAF50;color:white;}</style>";
echo "</head><body>";

echo "<h1>🔍 Parent-Student Relationship Check</h1><hr>";

// Cek apakah parent sudah login
$parent = Auth::guard('parent')->user();

if (!$parent) {
    echo "<p style='color:red;'>❌ Tidak ada parent yang login. Silakan login terlebih dahulu.</p>";
    echo "<p><a href='/parent/login'>Login sebagai Parent</a></p>";
} else {
    echo "<h2>✅ Parent yang Login:</h2>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th></tr>";
    echo "<tr>";
    echo "<td>{$parent->id}</td>";
    echo "<td>{$parent->name}</td>";
    echo "<td>{$parent->email}</td>";
    echo "<td>{$parent->status}</td>";
    echo "</tr>";
    echo "</table>";
    
    echo "<h2>📋 Daftar Anak (Students):</h2>";
    $students = App\Models\Student::where('parent_id', $parent->id)->get();
    
    if ($students->isEmpty()) {
        echo "<p style='color:orange;'>⚠️ Tidak ada student yang terhubung dengan parent ini.</p>";
    } else {
        echo "<table>";
        echo "<tr><th>Student ID</th><th>Name</th><th>Parent ID</th><th>Parent ID Type</th><th>Logged Parent ID</th><th>Logged Parent Type</th><th>Match (===)?</th><th>Match (==)?</th><th>Match (int cast)?</th><th>Education</th><th>Class</th></tr>";
        foreach ($students as $student) {
            $strictMatch = $student->parent_id === $parent->id ? '✅ YES' : '❌ NO';
            $looseMatch = $student->parent_id == $parent->id ? '✅ YES' : '❌ NO';
            $intMatch = ((int)$student->parent_id) === ((int)$parent->id) ? '✅ YES' : '❌ NO';
            
            $strictColor = $student->parent_id === $parent->id ? 'green' : 'red';
            $looseColor = $student->parent_id == $parent->id ? 'green' : 'red';
            $intColor = ((int)$student->parent_id) === ((int)$parent->id) ? 'green' : 'red';
            
            echo "<tr>";
            echo "<td>{$student->id}</td>";
            echo "<td>{$student->name}</td>";
            echo "<td>{$student->parent_id}</td>";
            echo "<td>" . gettype($student->parent_id) . "</td>";
            echo "<td>{$parent->id}</td>";
            echo "<td>" . gettype($parent->id) . "</td>";
            echo "<td style='color:{$strictColor};font-weight:bold;'>{$strictMatch}</td>";
            echo "<td style='color:{$looseColor};font-weight:bold;'>{$looseMatch}</td>";
            echo "<td style='color:{$intColor};font-weight:bold;'>{$intMatch}</td>";
            echo "<td>{$student->education_level}</td>";
            echo "<td>{$student->class_level}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<p><strong>Penjelasan:</strong></p>";
        echo "<ul>";
        echo "<li><strong>Match (===)</strong>: Strict comparison (value dan type harus sama)</li>";
        echo "<li><strong>Match (==)</strong>: Loose comparison (hanya value yang harus sama)</li>";
        echo "<li><strong>Match (int cast)</strong>: Comparison setelah di-cast ke integer</li>";
        echo "</ul>";
    }
    
    echo "<h2>🔗 Test Select Child URLs:</h2>";
    echo "<ul>";
    foreach ($students as $student) {
        $url = route('parent.select-child', $student);
        echo "<li><a href='{$url}' target='_blank'>Select {$student->name} (ID: {$student->id})</a></li>";
    }
    echo "</ul>";
    
    echo "<h2>📊 All Students in Database:</h2>";
    $allStudents = App\Models\Student::with('parent')->get();
    echo "<table>";
    echo "<tr><th>Student ID</th><th>Student Name</th><th>Parent ID</th><th>Parent Name</th></tr>";
    foreach ($allStudents as $s) {
        echo "<tr>";
        echo "<td>{$s->id}</td>";
        echo "<td>{$s->name}</td>";
        echo "<td>{$s->parent_id}</td>";
        echo "<td>" . ($s->parent ? $s->parent->name : 'N/A') . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

echo "<hr><p><strong>⚠️ IMPORTANT:</strong> Hapus file ini setelah selesai debugging!</p>";
echo "</body></html>";

$kernel->terminate($request, $response);
