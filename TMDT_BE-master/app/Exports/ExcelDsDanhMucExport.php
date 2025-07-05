<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelDsDanhMucExport implements FromCollection ,WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return $this->data;
    }
    public function map($invoice): array
    {
        return [
            $invoice->stt,
            $invoice->ten_danh_muc,
            $invoice->icon_danh_muc,
            $invoice->slug_danh_muc,
            $invoice->id_danh_muc_cha,
            $invoice->tinh_trang,
            
        ];
    }

    public function headings(): array
    {
        return [
            'STT',
            'ten_danh_muc',
            'icon_danh_muc',
            'slug_danh_muc',
            'id_danh_muc_cha',
            'tinh_trang',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
