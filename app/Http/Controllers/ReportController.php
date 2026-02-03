<?php

namespace App\Http\Controllers;

use App\Services\PdfService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    protected $pdfService;

    public function __construct(PdfService $pdfService)
    {
        $this->pdfService = $pdfService;
    }

    /**
     * Generate a PDF report
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generatePdf(Request $request): JsonResponse
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'report_id' => 'required|integer|exists:reports,id',
            'format_id' => 'required|integer|exists:report_formats,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Generate the PDF
            $filePath = $this->pdfService->generateReportPdf(
                $request->input('report_id'),
                $request->input('format_id')
            );

            // Get the full URL to the file
            $url = Storage::url($filePath);

            return response()->json([
                'success' => true,
                'message' => 'PDF generated successfully',
                'data' => [
                    'file_path' => $filePath,
                    'url' => $url,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate PDF: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a generated PDF
     *
     * @param string $fileName
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf(string $fileName)
    {
        $filePath = 'reports/' . $fileName;
        
        if (!Storage::disk('public')->exists($filePath)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        return Storage::disk('public')->download($filePath);
    }
}