<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Exportação genérica (Excel/CSV) para qualquer relatório definido em
 * ReportService — evita uma classe de export por tipo de relatório.
 */
class ArrayExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    use Exportable;

    public function __construct(private readonly array $headings, private readonly array $rows)
    {
        //
    }

    public function array(): array
    {
        return $this->rows;
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
