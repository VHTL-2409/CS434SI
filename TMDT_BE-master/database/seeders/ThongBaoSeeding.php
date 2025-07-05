<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThongBaoSeeding extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('thong_baos')->delete();

        DB::table('thong_baos')->truncate();
        
        DB::table('thong_baos')->insert([
                [
                    'id'                =>   1,
                    'tieu_de'           =>   'Đăng nhập',
                    'noi_dung'          =>   'Bạn đã đăng nhập',
                    'icon_thong_bao'    =>   'bx bx-group',
                    'color_thong_bao'   =>   'text-primary',
                    'id_nhan_vien'      =>   1 
                ],
                [
                    'id'                =>   2,
                    'tieu_de'           =>   'Thêm mới',
                    'noi_dung'          =>   'Đã thêm mới sản phẩm',
                    'icon_thong_bao'    =>   'fa-solid fa-plus',
                    'color_thong_bao'   =>   'text-warning',
                    'id_nhan_vien'      =>   1 
                ]
        ]);
    }
}
