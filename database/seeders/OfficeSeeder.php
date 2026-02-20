<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Administrative Services Office (ADSO)
        $adso = Office::create([
            'name' => 'Administrative Services Office',
            'code' => 'ADSO',
            'acronym' => 'ADSO',
            'overview' => 'The ADSO provides a responsive, relevant organization complement capable of adapting to emerging demands and trends in the environment, and providing all necessary, implementable welfare programs for all employees of the University.',
            'parent_id' => null,
            'order' => 1,
            'is_active' => true,
        ]);

        // Create sub-offices under ADSO
        $subOffices = [
            [
                'name' => 'Human Resources Management Office',
                'code' => 'HRM',
                'acronym' => 'HRMO',
                'overview' => 'The HRMO is responsible for the recruitment and appointment of personnel including the terms and conditions of their employment, performance evaluation, personnel relation and welfare services, and other employee benefits and privileges.',
                'order' => 1,
            ],
            [
                'name' => 'Property',
                'code' => 'PROPERTY',
                'acronym' => 'PROPERTY',
                'overview' => 'Manages university property, assets, facilities, and infrastructure.',
                'order' => 2,
            ],
            [
                'name' => 'Procurement',
                'code' => 'PROCUREMENT',
                'acronym' => 'PROCUREMENT',
                'overview' => 'Handles procurement processes, purchasing, and supply chain management.',
                'order' => 3,
            ],
            [
                'name' => 'Records',
                'code' => 'RECORDS',
                'acronym' => 'RECORDS',
                'overview' => 'Manages document records, filing systems, and archival services.',
                'order' => 4,
            ],
        ];

        foreach ($subOffices as $subOffice) {
            Office::create([
                'name' => $subOffice['name'],
                'code' => $subOffice['code'],
                'acronym' => $subOffice['acronym'],
                'overview' => $subOffice['overview'],
                'parent_id' => $adso->id,
                'order' => $subOffice['order'],
                'is_active' => true,
            ]);
        }
    }
}
