<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReportStatus;

class ReportStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['code' => 'pending', 'name' => 'Pending'],
            ['code' => 'generated', 'name' => 'Generated'],
            ['code' => 'printed', 'name' => 'Printed'],
            ['code' => 'sended', 'name' => 'Sended'],
        ];

        foreach ($statuses as $status) {
            ReportStatus::create($status);
        }
    }
}