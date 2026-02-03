<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportGenerated;
use App\Models\ReportFormat;
use App\Models\ReportStatus;
use Illuminate\Support\Facades\Log;

class PrintService
{
    /**
     * Simulate printing a report
     *
     * @param int $reportId
     * @return array
     */
    public function printReport(int $reportId): array
    {
        try {
            $report = Report::findOrFail($reportId);
            
            $pdfFormat = ReportFormat::where('code', 'pdf')->first();
            
            $reportGenerated = ReportGenerated::create([
                'report_id' => $reportId,
                'report_format_id' => $pdfFormat->id,
            ]);
            
            $printedStatus = ReportStatus::where('code', 'printed')->first();
            $report->update(['report_status_id' => $printedStatus->id]);
            
            Log::info("Report {$reportId} has been printed successfully");
            
            return [
                'success' => true,
                'message' => 'Report printed successfully',
                'data' => [
                    'report_id' => $reportId,
                    'report_generated_id' => $reportGenerated->id,
                    'format' => 'pdf',
                    'status' => 'printed'
                ]
            ];
        } catch (\Exception $e) {
            Log::error("Failed to print report {$reportId}: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to print report: ' . $e->getMessage()
            ];
        }
    }
}