<?php

namespace App\Http\Controllers;

use App\Services\PdfService;
use App\Services\EmailService;
use App\Services\PrintService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Tag(
 *     name="Reports",
 *     description="API Endpoints for Reports"
 * )
 * @OA\PathItem(
 *     path="/api/reports"
 * )
 */
class ReportController extends Controller
{
    protected $pdfService;
    protected $emailService;
    protected $printService;

    public function __construct(PdfService $pdfService, EmailService $emailService, PrintService $printService)
    {
        $this->pdfService = $pdfService;
        $this->emailService = $emailService;
        $this->printService = $printService;
    }

    /**
     * Generate a PDF report
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generatePdf(Request $request): JsonResponse
    {

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
          
            $filePath = $this->pdfService->generateReportPdf(
                $request->input('report_id'),
                $request->input('format_id')
            );

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

    /**
     * Send a report by email
     *
     * @OA\Post(
     *     path="/api/reports/send-by-email",
     *     tags={"Reports"},
     *     summary="Send a report by email",
     *     description="Simulates sending a report by email and updates the report status to 'sended'",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"report_id"},
     *             @OA\Property(property="report_id", type="integer", example=1, description="ID of the report to send")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report sent successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Report sent by email successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="report_id", type="integer", example=1),
     *                 @OA\Property(property="report_generated_id", type="integer", example=1),
     *                 @OA\Property(property="format", type="string", example="pdf"),
     *                 @OA\Property(property="status", type="string", example="sended")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to send report by email")
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendReportByEmail(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'report_id' => 'required|integer|exists:reports,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = $this->emailService->sendReportByEmail($request->input('report_id'));

            if ($result['success']) {
                return response()->json($result);
            } else {
                return response()->json($result, 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send report by email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Print a report
     *
     * @OA\Post(
     *     path="/api/reports/print",
     *     tags={"Reports"},
     *     summary="Print a report",
     *     description="Simulates printing a report and updates the report status to 'printed'",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"report_id"},
     *             @OA\Property(property="report_id", type="integer", example=1, description="ID of the report to print")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report printed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Report printed successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="report_id", type="integer", example=1),
     *                 @OA\Property(property="report_generated_id", type="integer", example=1),
     *                 @OA\Property(property="format", type="string", example="pdf"),
     *                 @OA\Property(property="status", type="string", example="printed")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed"),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to print report")
     *         )
     *     )
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function printReport(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'report_id' => 'required|integer|exists:reports,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = $this->printService->printReport($request->input('report_id'));

            if ($result['success']) {
                return response()->json($result);
            } else {
                return response()->json($result, 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to print report: ' . $e->getMessage()
            ], 500);
        }
    }
}