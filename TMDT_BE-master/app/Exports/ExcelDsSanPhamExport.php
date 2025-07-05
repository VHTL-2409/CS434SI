<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelDsSanPhamExport implements FromCollection ,WithHeadings, WithMapping, ShouldAutoSize, WithStyles
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
            $invoice->ten_san_pham,
            $invoice->slug_san_pham,
            $invoice->so_luong,
            $invoice->hinh_anh,
            $invoice->tinh_trang,
            $invoice->mo_ta_ngan,
            $invoice->mo_ta_chi_tiet,
            $invoice->gia_ban,
            $invoice->gia_khuyen_mai,
            $invoice->id_dai_ly,
            $invoice->is_noi_bat,
            $invoice->is_flash_sale,
            $invoice->sao_danh_gia,
            $invoice->tag,

        ];
    }

    public function headings(): array
    {
        return [
            'STT',
            'ten_san_pham',
            'slug_san_pham',
            'so_luong',
            'hinh_anh',
            'tinh_trang',
            'mo_ta_ngan',
            'mo_ta_chi_tiet',
            'gia_ban',
            'gia_khuyen_mai',
            'id_dai_ly',
            'is_noi_bat',
            'is_flash_sale',
            'sao_danh_gia',
            'tag',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:O1')->getFont()->setBold(true);
        $sheet->getStyle('A')->getAlignment()->setHorizontal('center');
    }
}
