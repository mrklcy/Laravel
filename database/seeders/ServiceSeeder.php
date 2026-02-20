<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Office;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $adso = Office::where('code', 'ADSO')->first();
        $hrm = Office::where('code', 'HRM')->first();
        $property = Office::where('code', 'PROPERTY')->first();
        $procurement = Office::where('code', 'PROCUREMENT')->first();
        $records = Office::where('code', 'RECORDS')->first();

        $services = [
            // HRMO Services
            [
                'name' => 'Employee Recruitment & Selection',
                'description' => 'Comprehensive recruitment and selection process for all university positions.',
                'details' => 'We handle the entire recruitment process from job posting, application screening, interviews, to final selection and appointment.',
                'office_id' => $hrm->id ?? null,
                'requirements' => 'Job vacancy announcement, application letter, resume/CV, supporting documents',
                'process' => '1. Submit application\n2. Initial screening\n3. Interview\n4. Final selection\n5. Appointment',
                'contact_person' => 'HRMO Staff',
                'contact_email' => 'hrmo@clsu.edu.ph',
                'contact_phone' => '(044) 456-0107',
                'order' => 1,
            ],
            [
                'name' => 'Performance Evaluation',
                'description' => 'Annual performance evaluation and assessment for all employees.',
                'details' => 'Conduct regular performance evaluations to assess employee productivity and identify areas for improvement.',
                'office_id' => $hrm->id ?? null,
                'order' => 2,
            ],
            [
                'name' => 'Employee Benefits Administration',
                'description' => 'Management of employee benefits including health insurance, retirement plans, and other privileges.',
                'details' => 'We assist employees with their benefits enrollment, claims processing, and benefit-related inquiries.',
                'office_id' => $hrm->id ?? null,
                'order' => 3,
            ],
            [
                'name' => 'Personnel Records Management',
                'description' => 'Maintenance and management of employee personnel files and records.',
                'details' => 'Secure storage and management of all employee documents, contracts, and personnel records.',
                'office_id' => $hrm->id ?? null,
                'order' => 4,
            ],
            // Property Services
            [
                'name' => 'Asset Inventory & Tracking',
                'description' => 'Comprehensive tracking and management of university assets and equipment.',
                'details' => 'Maintain accurate records of all university assets including equipment, furniture, and facilities.',
                'office_id' => $property->id ?? null,
                'order' => 1,
            ],
            [
                'name' => 'Facilities Maintenance',
                'description' => 'Regular maintenance and repair of university facilities and infrastructure.',
                'details' => 'Coordinate maintenance activities for buildings, grounds, and facilities.',
                'office_id' => $property->id ?? null,
                'order' => 2,
            ],
            // Procurement Services
            [
                'name' => 'Purchase Request Processing',
                'description' => 'Processing and management of purchase requests from various departments.',
                'details' => 'We handle purchase requisitions, conduct procurement processes, and ensure timely delivery of goods and services.',
                'office_id' => $procurement->id ?? null,
                'requirements' => 'Purchase Request Form, Budget allocation, Specifications',
                'process' => '1. Submit PR\n2. Review and approval\n3. Procurement process\n4. Delivery\n5. Inspection and acceptance',
                'order' => 1,
            ],
            [
                'name' => 'Bidding & Contract Management',
                'description' => 'Management of public bidding processes and contract administration.',
                'details' => 'Conduct competitive bidding, evaluate proposals, and manage contracts for goods, services, and infrastructure projects.',
                'office_id' => $procurement->id ?? null,
                'order' => 2,
            ],
            [
                'name' => 'Supplier Registration',
                'description' => 'Registration and accreditation of suppliers and vendors.',
                'details' => 'Maintain database of qualified suppliers and facilitate supplier registration process.',
                'office_id' => $procurement->id ?? null,
                'order' => 3,
            ],
            // Records Services
            [
                'name' => 'Document Filing & Retrieval',
                'description' => 'Organized filing system and document retrieval services.',
                'details' => 'Efficient filing system for easy document storage and retrieval.',
                'office_id' => $records->id ?? null,
                'order' => 1,
            ],
            [
                'name' => 'Records Archival',
                'description' => 'Long-term storage and preservation of important university records.',
                'details' => 'Secure archival services for historical and important documents.',
                'office_id' => $records->id ?? null,
                'order' => 2,
            ],
        ];

        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'details' => $service['details'] ?? null,
                'office_id' => $service['office_id'],
                'requirements' => $service['requirements'] ?? null,
                'process' => $service['process'] ?? null,
                'contact_person' => $service['contact_person'] ?? null,
                'contact_email' => $service['contact_email'] ?? null,
                'contact_phone' => $service['contact_phone'] ?? null,
                'order' => $service['order'],
                'is_active' => true,
            ]);
        }
    }
}
