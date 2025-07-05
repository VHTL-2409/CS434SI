<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhachHangSeeding extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('khach_hangs')->delete();
        DB::table('khach_hangs')->truncate();
        DB::table('khach_hangs')->insert([
            [
                'ho_va_ten' => 'Nguyễn Thái',
                'email' => 'kkdn011@gmail.com',
                'so_dien_thoai' => '0905666888',
                'password' => bcrypt('123456'),
                'is_active' => 1,
            ],
            [
                'ho_va_ten' => 'Thái Nguyễn',
                'email' => 'thainguyen@gmail.com',
                'so_dien_thoai' => '0905111333',
                'password' => bcrypt('123456'),
                'is_active' => 1,
            ],
        ]);
    }
}
