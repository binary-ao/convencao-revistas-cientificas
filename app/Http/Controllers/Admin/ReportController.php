<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ArrayExport;
use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\View\View;
use InvalidArgumentException;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index', ['reports' => ReportService::REPORTS]);
    }

    public function show(string $type, ReportService $service): View
    {
        $report = $this->resolve($type, $service);

        return view('admin.reports.show', ['type' => $type] + $report);
    }

    public function export(string $type, string $format, ReportService $service): BinaryFileResponse|StreamedResponse|Response
    {
        $report = $this->resolve($type, $service);
        $filename = $type.'-'.now()->format('Y-m-d');

        return match ($format) {
            'xlsx' => Excel::download(new ArrayExport($report['headers'], $report['rows']), "{$filename}.xlsx", ExcelFormat::XLSX),
            'csv' => Excel::download(new ArrayExport($report['headers'], $report['rows']), "{$filename}.csv", ExcelFormat::CSV),
            'pdf' => Pdf::loadView('pdf.report', $report)->setPaper('a4', 'landscape')->download("{$filename}.pdf"),
            default => abort(404),
        };
    }

    private function resolve(string $type, ReportService $service): array
    {
        try {
            return $service->build($type);
        } catch (InvalidArgumentException) {
            abort(404);
        }
    }
}
