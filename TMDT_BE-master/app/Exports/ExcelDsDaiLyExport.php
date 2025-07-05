<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelDsDaiLyExport implements FromCollection ,WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            $invoice->ho_va_ten,
            $invoice->email,
            $invoice->so_dien_thoai,
            $invoice->ngay_sinh,
            $invoice->ten_doanh_nghiep,
            $invoice->ma_so_thue,
            $invoice->dia_chi_kinh_doanh,
        ];
    }

    public function headings(): array
    {
        return [
            'STT',
            'ho_va_ten'             ,
            'email'                 ,
            'so_dien_thoai'         ,
            'ngay_sinh'             ,
            'ten_doanh_nghiep'      ,
            'ma_so_thue'            ,
            'dia_chi_kinh_doanh'    ,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
