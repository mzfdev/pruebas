<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportGenerated;
use App\Models\ReportFormat;
use App\Models\ReportStatus;
use Illuminate\Support\Facades\Log;

class EmailService
{
    /**
     * Simulate sending a report by email
     *
     * @param int $reportId
     * @return array
     */
    public function sendReportByEmail(int $reportId): array
    {
        try {
           
            $report = Report::findOrFail($reportId);
            
            $pdfFormat = ReportFormat::where('code', 'pdf')->first();
            
            $reportGenerated = ReportGenerated::create([
                'report_id' => $reportId,
                'report_format_id' => $pdfFormat->id,
            ]);
            
            $sendedStatus = ReportStatus::where('code', 'sended')->first();
            $report->update(['report_status_id' => $sendedStatus->id]);
            
            Log::info("Report {$reportId} has been sent by email successfully");
            
            return [
                'success' => true,
                'message' => 'Report sent by email successfully',
                'data' => [
                    'report_id' => $reportId,
                    'report_generated_id' => $reportGenerated->id,
                    'format' => 'pdf',
                    'status' => 'sended'
                ]
            ];
        } catch (\Exception $e) {
            Log::error("Failed to send report {$reportId} by email: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to send report by email: ' . $e->getMessage()
            ];
        }
    }
}