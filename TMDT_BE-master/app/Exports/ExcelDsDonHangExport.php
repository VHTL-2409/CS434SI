<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelDsDonHangExport implements FromCollection ,WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            $invoice->ma_don_hang,
            $invoice->id_khach_hang,
            $invoice->id_dia_chi,
            $invoice->tong_tien,
            $invoice->ma_code_giam,
            $invoice->so_tien_giam,
            $invoice->so_tien_thanh_toan,
            $invoice->is_thanh_toan,
         
        ];
    }

    public function headings(): array
    {
        return [
            'STT',
            'ma_don_hang',
            'id_khach_hang',
            'id_dia_chi',
            'tong_tien',
            'ma_code_giam',
            'so_tien_giam',
            'so_tien_thanh_toan',
            'is_thanh_toan',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
