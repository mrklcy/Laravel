<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $adso = Office::where('code', 'ADSO')->first();
        $hrm = Office::where('code', 'HRM')->first();
        $procurement = Office::where('code', 'PROCUREMENT')->first();

        $newsItems = [
            [
                'title' => 'ADSO Launches New Employee Portal',
                'excerpt' => 'The Administrative Services Office is pleased to announce the launch of our new online employee portal.',
                'content' => 'The Administrative Services Office is pleased to announce the launch of our new online employee portal. This portal will provide employees with easy access to their records, benefits information, and various ADSO services. Employees can now submit requests, track applications, and access important documents online.',
                'office_id' => $adso->id ?? null,
                'author' => 'ADSO Admin',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'HRMO Announces New Wellness Program',
                'excerpt' => 'The Human Resources Management Office is launching a comprehensive wellness program for all employees.',
                'content' => 'The Human Resources Management Office is launching a comprehensive wellness program designed to promote the physical and mental health of all CLSU employees. The program includes health screenings, fitness activities, stress management workshops, and wellness seminars. Registration is now open.',
                'office_id' => $hrm->id ?? null,
                'author' => 'HRMO Staff',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Procurement Office Updates Bidding Procedures',
                'excerpt' => 'New guidelines and procedures for procurement and bidding processes have been implemented.',
                'content' => 'The Procurement Office has updated its bidding procedures to streamline the procurement process and ensure transparency. All departments are encouraged to review the new guidelines available on the ADSO website.',
                'office_id' => $procurement->id ?? null,
                'author' => 'Procurement Office',
                'published_at' => now()->subDays(7),
            ],
            [
                'title' => 'Annual Performance Evaluation Schedule Released',
                'excerpt' => 'The schedule for the annual performance evaluation has been released.',
                'content' => 'The Human Resources Management Office has released the schedule for the annual performance evaluation. All employees are required to complete their self-assessment forms and meet with their supervisors during the designated period.',
                'office_id' => $hrm->id ?? null,
                'author' => 'HRMO Staff',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Property Office Conducts Asset Inventory',
                'excerpt' => 'The Property Office is conducting a comprehensive inventory of all university assets.',
                'content' => 'The Property Office is conducting a comprehensive inventory of all university assets. All departments are requested to cooperate and provide necessary information. This inventory will help improve asset management and tracking.',
                'office_id' => $adso->id ?? null,
                'author' => 'Property Office',
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Records Office Implements Digital Filing System',
                'excerpt' => 'The Records Office has implemented a new digital filing system for better document management.',
                'content' => 'The Records Office has implemented a new digital filing system to improve document management and retrieval. This system will make it easier to access and manage important university records.',
                'office_id' => $adso->id ?? null,
                'author' => 'Records Office',
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($newsItems as $news) {
            News::create([
                'title' => $news['title'],
                'slug' => Str::slug($news['title']),
                'excerpt' => $news['excerpt'],
                'content' => $news['content'],
                'office_id' => $news['office_id'],
                'author' => $news['author'],
                'is_published' => true,
                'published_at' => $news['published_at'],
                'views' => rand(10, 500),
            ]);
        }
    }
}
