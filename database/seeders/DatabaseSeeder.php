<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User for Filament
        User::create([
            'name' => 'Admin Bimbel Pados Ilmu',
            'email' => 'admin@padosilmu.com',
            'password' => Hash::make('admin123'),
        ]);

        // Run all seeders in proper order
        $this->call([
            SubjectSeeder::class,
            TeacherSeeder::class,
            ParentSeeder::class,
            StudentSeeder::class,
            GameTemplateSeeder::class,
            GameSeeder::class,
            GameQuestionSeeder::class,
            ScheduleSeeder::class,
        ]);

        $this->command->info('✅ Database seeded successfully!');
        $this->command->info('');
        $this->command->info('📝 Login Credentials:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🔐 Admin (Filament):');
        $this->command->info('   Email: admin@padosilmu.com');
        $this->command->info('   Password: admin123');
        $this->command->info('');
        $this->command->info('👨‍🏫 Teacher (Approved):');
        $this->command->info('   Email: budi.santoso@padosilmu.com');
        $this->command->info('   Password: password123');
        $this->command->info('');
        $this->command->info('👨‍👩‍👧‍👦 Parent (Approved):');
        $this->command->info('   Email: agus.setiawan@gmail.com');
        $this->command->info('   Password: password123');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
