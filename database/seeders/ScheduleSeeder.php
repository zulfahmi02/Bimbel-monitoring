<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $students = Student::all();
        $subjects = Subject::all();

        // Days of week
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        // Time slots
        $timeSlots = [
            ['start' => '15:00', 'end' => '16:30'],
            ['start' => '16:30', 'end' => '18:00'],
            ['start' => '19:00', 'end' => '20:30'],
        ];

        foreach ($students as $student) {
            // Each student gets 3-4 schedules per week
            $schedulesPerWeek = rand(3, 4);
            $usedDays = [];

            for ($i = 0; $i < $schedulesPerWeek; $i++) {
                // Pick a random day that hasn't been used
                do {
                    $day = $days[array_rand($days)];
                } while (in_array($day, $usedDays) && count($usedDays) < count($days));
                
                $usedDays[] = $day;

                // Pick random subject appropriate for student's level
                $appropriateSubjects = $subjects->filter(function($subject) use ($student) {
                    // Filter subjects based on education level
                    if ($student->education_level === 'MI') {
                        // Elementary subjects
                        return in_array($subject->name, [
                            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 
                            'IPA (Ilmu Pengetahuan Alam)', 'IPS (Ilmu Pengetahuan Sosial)',
                            'Pendidikan Agama Islam', 'Seni Budaya', 'Pendidikan Jasmani'
                        ]);
                    } elseif ($student->education_level === 'SMP') {
                        // Junior high subjects
                        return in_array($subject->name, [
                            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
                            'IPA (Ilmu Pengetahuan Alam)', 'IPS (Ilmu Pengetahuan Sosial)',
                            'Pendidikan Agama Islam', 'Pendidikan Kewarganegaraan'
                        ]);
                    } else {
                        // Senior high subjects
                        return in_array($subject->name, [
                            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris',
                            'Fisika', 'Kimia', 'Biologi', 'Sejarah', 'Geografi',
                            'Pendidikan Kewarganegaraan'
                        ]);
                    }
                });

                if ($appropriateSubjects->isEmpty()) {
                    $subject = $subjects->random();
                } else {
                    $subject = $appropriateSubjects->random();
                }

                // Pick random time slot
                $timeSlot = $timeSlots[array_rand($timeSlots)];

                Schedule::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'day_of_week' => $day,
                    'start_time' => $timeSlot['start'],
                    'end_time' => $timeSlot['end'],
                ]);
            }
        }
    }
}
