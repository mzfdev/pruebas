<?php

namespace App\Services;

use App\Models\Report;
use App\Models\ReportFormat;
use App\Models\ReportGenerated;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PdfService
{
    /**
     * Generate a PDF report based on the report ID and format ID
     *
     * @param int $reportId
     * @param int $formatId
     * @return string
     */
    public function generateReportPdf(int $reportId, int $formatId): string
    {
        $report = Report::with(['reportStatus', 'reportInscriptions.student', 'reportInscriptions.subject'])->findOrFail($reportId);
        $format = ReportFormat::findOrFail($formatId);
        
        $reportGenerated = ReportGenerated::create([
            'report_id' => $reportId,
            'report_format_id' => $formatId,
        ]);
        
        $pdfContent = $this->generatePdfContent($report, $format);
        
        $fileName = 'report_' . $reportId . '_format_' . $formatId . '_' . $reportGenerated->id . '.pdf';
        $filePath = 'reports/' . $fileName;
        
        Storage::disk('public')->put($filePath, $pdfContent);
        
        return $filePath;
    }
    
    /**
     * Generate the actual PDF content based on the format
     *
     * @param Report $report
     * @param ReportFormat $format
     * @return string
     */
    private function generatePdfContent(Report $report, ReportFormat $format): string
    {
        $data = [
            'report' => $report,
            'format' => $format,
            'title' => 'Report - ' . $report->description,
            'generatedAt' => now()->format('Y-m-d H:i:s'),
        ];

        $viewName = $this->getViewForFormat($format->code);
        
        $pdf = Pdf::loadView($viewName, $data);

        return $pdf->output();
    }
    
    /**
     * Get the appropriate view based on the format code
     *
     * @param string $formatCode
     * @return string
     */
    private function getViewForFormat(string $formatCode): string
    {
        $view = 'reports.default';
        
        switch ($formatCode) {
            case 'SUMMARY':
                $view = 'reports.summary';
                break;
            case 'DETAILED':
                $view = 'reports.detailed';
                break;
            case 'STATISTICS':
                $view = 'reports.statistics';
                break;
        }
        
        return $view;
    }
}