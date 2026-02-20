<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Employee;
use App\Models\Office;
use App\Models\Service;
use App\Models\Program;
use App\Models\News;
use App\Models\Inquiry;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin users
        Admin::create([
            'name' => 'Super Administrator',
            'email' => 'admin@clsu.edu.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'HRMO Admin',
            'email' => 'hrmo@clsu.edu.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'hrmo_admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'PMO Admin',
            'email' => 'pmo@clsu.edu.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'pmo_admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'PSO Admin',
            'email' => 'pso@clsu.edu.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'pso_admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'RMO Admin',
            'email' => 'rmo@clsu.edu.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'rmo_admin',
            'is_active' => true,
        ]);

        Admin::create([
            'name' => 'ADSO Admin',
            'email' => 'adso.admin@clsu.edu.ph',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'role' => 'admin',
            'is_active' => true,
        ]);


        // Create ADSO main office
        $adso = Office::create([
            'name' => 'Administrative and Development Services Office',
            'code' => 'ADSO',
            'acronym' => 'ADSO',
            'overview' => 'The Administrative and Development Services Office (ADSO) provides comprehensive administrative support and development services to ensure efficient operations across the university.',
            'parent_id' => null,
            'order' => 1,
            'is_active' => true,
        ]);

        // Create sub-offices under ADSO
        $hrmo = Office::create([
            'name' => 'Human Resource Management Office',
            'code' => 'HRMO',
            'acronym' => 'HRMO',
            'overview' => 'Manages all human resource functions including recruitment, employee relations, benefits administration, and personnel development.',
            'parent_id' => $adso->id,
            'order' => 1,
            'is_active' => true,
        ]);

        $pmo = Office::create([
            'name' => 'Procurement Management Office',
            'code' => 'PMO',
            'acronym' => 'PMO',
            'overview' => 'Ensures check and balance in the purchasing of goods, services, and infrastructure through delegated alternative methods of procurement.',
            'parent_id' => $adso->id,
            'order' => 2,
            'is_active' => true,
        ]);

        $supply = Office::create([
            'name' => 'Property and Supply Office',
            'code' => 'PSO',
            'acronym' => 'PSO',
            'overview' => 'Manages procurement, inventory, and property management for the university.',
            'parent_id' => $adso->id,
            'order' => 3,
            'is_active' => true,
        ]);

        $records = Office::create([
            'name' => 'Records Management Office',
            'code' => 'RMO',
            'acronym' => 'RMO',
            'overview' => 'Maintains and manages all official university records and documents.',
            'parent_id' => $adso->id,
            'order' => 4,
            'is_active' => true,
        ]);

        // Create Services
        Service::create([
            'name' => 'Employee Leave Application',
            'slug' => 'employee-leave-application',
            'description' => 'Process and manage employee leave applications including vacation, sick, and special leaves.',
            'details' => 'Employees can apply for various types of leave through the HRMO. Processing time is typically 3-5 working days.',
            'icon' => 'calendar',
            'office_id' => $hrmo->id,
            'requirements' => 'Valid ID, Leave application form, Medical certificate (for sick leave)',
            'process' => '1. Submit application form\n2. Department head approval\n3. HRMO processing\n4. Final approval',
            'contact_person' => 'Ms. Maria Santos',
            'contact_email' => 'hrmo@clsu.edu.ph',
            'contact_phone' => '(044) 456-0107',
            'order' => 1,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Service Record Request',
            'slug' => 'service-record-request',
            'description' => 'Request official service records for employment verification and other purposes.',
            'details' => 'Service records are official documents showing employment history at CLSU.',
            'icon' => 'document',
            'office_id' => $hrmo->id,
            'requirements' => 'Valid ID, Request form, Payment receipt',
            'process' => '1. Fill out request form\n2. Pay processing fee\n3. Wait for processing (3-5 days)\n4. Claim document',
            'contact_person' => 'Mr. Juan Dela Cruz',
            'contact_email' => 'hrmo@clsu.edu.ph',
            'contact_phone' => '(044) 456-0107',
            'order' => 2,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Facility Reservation',
            'slug' => 'facility-reservation',
            'description' => 'Reserve university facilities for events, meetings, and other activities.',
            'details' => 'PMO manages the reservation of various university facilities including halls, conference rooms, and outdoor spaces.',
            'icon' => 'building',
            'office_id' => $pmo->id,
            'requirements' => 'Reservation form, Event details, Department endorsement',
            'process' => '1. Submit reservation form\n2. PMO evaluation\n3. Approval confirmation\n4. Facility preparation',
            'contact_person' => 'Mr. Pedro Garcia',
            'contact_email' => 'pmo@clsu.edu.ph',
            'contact_phone' => '(044) 456-0108',
            'order' => 3,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Vehicle Request',
            'slug' => 'vehicle-request',
            'description' => 'Request university vehicles for official trips and activities.',
            'details' => 'University vehicles are available for official business and approved activities.',
            'icon' => 'truck',
            'office_id' => $pmo->id,
            'requirements' => 'Trip ticket, Department approval, Itinerary',
            'process' => '1. Submit vehicle request\n2. PMO approval\n3. Driver assignment\n4. Vehicle dispatch',
            'contact_person' => 'Mr. Pedro Garcia',
            'contact_email' => 'pmo@clsu.edu.ph',
            'contact_phone' => '(044) 456-0108',
            'order' => 4,
            'is_active' => true,
        ]);

        Service::create([
            'name' => 'Procurement Services',
            'slug' => 'procurement-services',
            'description' => 'Process procurement requests for supplies, equipment, and services.',
            'details' => 'PSO handles all procurement activities following government procurement guidelines.',
            'icon' => 'shopping-cart',
            'office_id' => $supply->id,
            'requirements' => 'Purchase request form, Budget allocation, Specifications',
            'process' => '1. Submit purchase request\n2. Budget verification\n3. Procurement process\n4. Delivery and acceptance',
            'contact_person' => 'Ms. Ana Reyes',
            'contact_email' => 'pso@clsu.edu.ph',
            'contact_phone' => '(044) 456-0109',
            'order' => 5,
            'is_active' => true,
        ]);

        // Create Programs
        Program::create([
            'name' => 'Employee Wellness Program',
            'slug' => 'employee-wellness-program',
            'description' => 'Comprehensive wellness program promoting physical and mental health of employees.',
            'details' => 'The program includes health screenings, fitness activities, mental health support, and wellness seminars.',
            'office_id' => $hrmo->id,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'benefits' => 'Free health screenings, Fitness classes, Mental health counseling, Wellness seminars',
            'eligibility' => 'All regular CLSU employees',
            'contact_person' => 'Ms. Maria Santos',
            'contact_email' => 'hrmo@clsu.edu.ph',
            'contact_phone' => '(044) 456-0107',
            'order' => 1,
            'is_active' => true,
        ]);

        Program::create([
            'name' => 'Professional Development Training',
            'slug' => 'professional-development-training',
            'description' => 'Training programs to enhance employee skills and competencies.',
            'details' => 'Regular training sessions covering leadership, technical skills, and professional development.',
            'office_id' => $hrmo->id,
            'start_date' => now(),
            'end_date' => now()->addMonths(6),
            'benefits' => 'Skill enhancement, Career advancement, Certification opportunities',
            'eligibility' => 'All CLSU employees',
            'contact_person' => 'Mr. Juan Dela Cruz',
            'contact_email' => 'hrmo@clsu.edu.ph',
            'contact_phone' => '(044) 456-0107',
            'order' => 2,
            'is_active' => true,
        ]);

        Program::create([
            'name' => 'Green Campus Initiative',
            'slug' => 'green-campus-initiative',
            'description' => 'Environmental sustainability program for the university campus.',
            'details' => 'Promotes environmental awareness and sustainable practices across the campus.',
            'office_id' => $pmo->id,
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'benefits' => 'Cleaner environment, Energy savings, Waste reduction',
            'eligibility' => 'All university community members',
            'contact_person' => 'Mr. Pedro Garcia',
            'contact_email' => 'pmo@clsu.edu.ph',
            'contact_phone' => '(044) 456-0108',
            'order' => 3,
            'is_active' => true,
        ]);

        // Create News
        News::create([
            'title' => 'ADSO Launches New Online Service Portal',
            'slug' => 'adso-launches-new-online-service-portal',
            'excerpt' => 'CLSU ADSO introduces a new online portal to streamline administrative services.',
            'content' => 'The Administrative and Development Services Office (ADSO) is proud to announce the launch of its new online service portal. This digital platform aims to provide easier access to administrative services for all CLSU employees and stakeholders. The portal features online application forms, service tracking, and real-time updates on requests.',
            'office_id' => $adso->id,
            'author' => 'ADSO Communications',
            'is_published' => true,
            'published_at' => now(),
            'views' => 150,
        ]);

        News::create([
            'title' => 'HRMO Announces Employee Benefits Enhancement',
            'slug' => 'hrmo-announces-employee-benefits-enhancement',
            'excerpt' => 'Enhanced benefits package now available for all regular employees.',
            'content' => 'The Human Resource Management Office announces significant enhancements to the employee benefits package. The improvements include increased health insurance coverage, additional leave credits, and expanded wellness programs. All regular employees are encouraged to visit the HRMO for details on how to avail of these enhanced benefits.',
            'office_id' => $hrmo->id,
            'author' => 'HRMO Staff',
            'is_published' => true,
            'published_at' => now()->subDays(2),
            'views' => 230,
        ]);

        News::create([
            'title' => 'Campus Facilities Undergo Major Upgrades',
            'slug' => 'campus-facilities-undergo-major-upgrades',
            'excerpt' => 'PMO oversees comprehensive facility improvements across campus.',
            'content' => 'The Procurement Management Office is currently overseeing major upgrades to various campus facilities. The improvements include renovated conference rooms, upgraded air conditioning systems, and enhanced security features. These upgrades are part of the university\'s commitment to providing a better working and learning environment.',
            'office_id' => $pmo->id,
            'author' => 'PMO Team',
            'is_published' => true,
            'published_at' => now()->subDays(5),
            'views' => 180,
        ]);

        News::create([
            'title' => 'New Procurement Guidelines Released',
            'slug' => 'new-procurement-guidelines-released',
            'excerpt' => 'PSO releases updated procurement procedures for 2026.',
            'content' => 'The Property and Supply Office has released updated procurement guidelines for the year 2026. The new guidelines aim to streamline the procurement process while ensuring compliance with government regulations. All departments are advised to familiarize themselves with the new procedures.',
            'office_id' => $supply->id,
            'author' => 'PSO Staff',
            'is_published' => false,
            'published_at' => null,
            'views' => 0,
        ]);

        // Create Sample Inquiries
        Inquiry::create([
            'name' => 'John Smith',
            'email' => 'john.smith@example.com',
            'phone' => '09171234567',
            'subject' => 'Question about leave application process',
            'message' => 'Hi, I would like to know the requirements for filing a vacation leave. How many days in advance should I file my application?',
            'office_id' => $hrmo->id,
            'inquiry_type' => 'general',
            'status' => 'pending',
        ]);

        Inquiry::create([
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'phone' => '09187654321',
            'subject' => 'Facility reservation inquiry',
            'message' => 'Good day! I would like to reserve the conference hall for a department seminar next month. What are the procedures and requirements?',
            'office_id' => $pmo->id,
            'inquiry_type' => 'service',
            'status' => 'pending',
        ]);

        Inquiry::create([
            'name' => 'Robert Johnson',
            'email' => 'robert.j@example.com',
            'phone' => '09191234567',
            'subject' => 'Service record request status',
            'message' => 'I submitted a service record request last week. May I know the status of my request?',
            'office_id' => $hrmo->id,
            'inquiry_type' => 'service',
            'status' => 'responded',
            'response' => 'Your service record is ready for pickup. Please bring a valid ID when claiming.',
            'responded_at' => now()->subDay(),
        ]);

        // Create Sample Employees
        Employee::create([
            'employee_id' => 'EMP-2024-001',
            'first_name' => 'Maria',
            'middle_name' => 'Santos',
            'last_name' => 'Cruz',
            'email' => 'maria.cruz@clsu.edu.ph',
            'phone' => '09171234567',
            'office_id' => $hrmo->id,
            'position' => 'HR Officer',
            'department' => 'Human Resources',
            'date_hired' => now()->subYears(5),
            'employment_status' => 'regular',
            'status' => 'active',
            'address' => 'Science City of Muñoz, Nueva Ecija',
            'birth_date' => now()->subYears(35),
        ]);

        Employee::create([
            'employee_id' => 'EMP-2024-002',
            'first_name' => 'Juan',
            'middle_name' => 'Reyes',
            'last_name' => 'Dela Cruz',
            'email' => 'juan.delacruz@clsu.edu.ph',
            'phone' => '09187654321',
            'office_id' => $hrmo->id,
            'position' => 'Administrative Assistant',
            'department' => 'Human Resources',
            'date_hired' => now()->subYears(3),
            'employment_status' => 'regular',
            'status' => 'active',
            'address' => 'Cabanatuan City, Nueva Ecija',
            'birth_date' => now()->subYears(28),
        ]);

        Employee::create([
            'employee_id' => 'EMP-2024-003',
            'first_name' => 'Pedro',
            'middle_name' => 'Lopez',
            'last_name' => 'Garcia',
            'email' => 'pedro.garcia@clsu.edu.ph',
            'phone' => '09191234567',
            'office_id' => $pmo->id,
            'position' => 'Facilities Manager',
            'department' => 'Procurement Management',
            'date_hired' => now()->subYears(8),
            'employment_status' => 'regular',
            'status' => 'active',
            'address' => 'Science City of Muñoz, Nueva Ecija',
            'birth_date' => now()->subYears(42),
        ]);

        Employee::create([
            'employee_id' => 'EMP-2024-004',
            'first_name' => 'Ana',
            'middle_name' => 'Torres',
            'last_name' => 'Reyes',
            'email' => 'ana.reyes@clsu.edu.ph',
            'phone' => '09201234567',
            'office_id' => $supply->id,
            'position' => 'Supply Officer',
            'department' => 'Supply and Property',
            'date_hired' => now()->subYears(4),
            'employment_status' => 'regular',
            'status' => 'active',
            'address' => 'Talavera, Nueva Ecija',
            'birth_date' => now()->subYears(32),
        ]);

        Employee::create([
            'employee_id' => 'EMP-2024-005',
            'first_name' => 'Roberto',
            'middle_name' => 'Mendoza',
            'last_name' => 'Santos',
            'email' => 'roberto.santos@clsu.edu.ph',
            'phone' => '09211234567',
            'office_id' => $records->id,
            'position' => 'Records Officer',
            'department' => 'Records Management',
            'date_hired' => now()->subYears(6),
            'employment_status' => 'regular',
            'status' => 'active',
            'address' => 'Science City of Muñoz, Nueva Ecija',
            'birth_date' => now()->subYears(38),
        ]);
    }
}
