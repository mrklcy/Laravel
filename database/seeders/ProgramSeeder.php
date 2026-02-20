<?php

namespace Database\Seeders;

use App\Models\Program;
use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $adso = Office::where('code', 'ADSO')->first();
        $hrm = Office::where('code', 'HRM')->first();

        $programs = [
            [
                'name' => 'Employee Wellness Program',
                'description' => 'Comprehensive wellness program promoting physical and mental health of employees.',
                'details' => 'This program includes health screenings, fitness activities, stress management workshops, and wellness seminars.',
                'office_id' => $hrm->id ?? null,
                'benefits' => 'Improved employee health, reduced absenteeism, increased productivity, better work-life balance',
                'eligibility' => 'All regular employees of CLSU',
                'contact_person' => 'HRMO Wellness Coordinator',
                'contact_email' => 'wellness@clsu.edu.ph',
                'order' => 1,
            ],
            [
                'name' => 'Professional Development Program',
                'description' => 'Training and development opportunities for employee growth and career advancement.',
                'details' => 'Offers various training programs, seminars, workshops, and educational opportunities.',
                'office_id' => $hrm->id ?? null,
                'benefits' => 'Skill enhancement, career advancement, improved job performance',
                'eligibility' => 'All employees',
                'order' => 2,
            ],
            [
                'name' => 'Employee Recognition Program',
                'description' => 'Recognition and rewards program for outstanding employee performance.',
                'details' => 'Annual awards ceremony recognizing employees for their contributions and achievements.',
                'office_id' => $hrm->id ?? null,
                'benefits' => 'Recognition, awards, certificates, monetary incentives',
                'eligibility' => 'All employees with outstanding performance',
                'order' => 3,
            ],
            [
                'name' => 'Retirement Planning Program',
                'description' => 'Assistance and guidance for employees planning for retirement.',
                'details' => 'Provides information, counseling, and support for employees approaching retirement.',
                'office_id' => $hrm->id ?? null,
                'benefits' => 'Financial planning, retirement benefits information, transition support',
                'eligibility' => 'Employees within 5 years of retirement',
                'order' => 4,
            ],
        ];

        foreach ($programs as $program) {
            Program::create([
                'name' => $program['name'],
                'slug' => Str::slug($program['name']),
                'description' => $program['description'],
                'details' => $program['details'] ?? null,
                'office_id' => $program['office_id'],
                'benefits' => $program['benefits'] ?? null,
                'eligibility' => $program['eligibility'] ?? null,
                'contact_person' => $program['contact_person'] ?? null,
                'contact_email' => $program['contact_email'] ?? null,
                'order' => $program['order'],
                'is_active' => true,
            ]);
        }
    }
}
