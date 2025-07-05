<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelDsNhanVienExport implements FromCollection ,WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            $invoice->email,
            $invoice->ho_va_ten,
            $invoice->so_dien_thoai,
            $invoice->dia_chi,
            $invoice->tinh_trang,
            $invoice->is_master,
            $invoice->id_quyen,
         
        ];
    }

    public function headings(): array
    {
        return [
            'STT',
            'email',
            'ho_va_ten',
            'so_dien_thoai',
            'dia_chi',
            'tinh_trang',
            'is_master',
            'id_quyen',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
