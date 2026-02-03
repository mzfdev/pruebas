<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReportFormat;

class ReportFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $formats = [
            ['code' => 'pdf', 'name' => 'PDF'],
            ['code' => 'SUMMARY', 'name' => 'Summary Report'],
            ['code' => 'DETAILED', 'name' => 'Detailed Report'],
            ['code' => 'STATISTICS', 'name' => 'Statistics Report'],
        ];

        foreach ($formats as $format) {
            ReportFormat::firstOrCreate(['code' => $format['code']], $format);
        }
    }
}