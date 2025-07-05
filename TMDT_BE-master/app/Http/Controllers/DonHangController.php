<?php

namespace App\Http\Controllers;

use App\Exports\ExcelDsDonHangExport;
use App\Mail\MasterMail;
use App\Models\ChiTietDonHang;
use App\Models\DiaChi;
use App\Models\DonHang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class DonHangController extends Controller
{
    public function store(Request $request)
    {
        $khachHang  = Auth::guard('sanctum')->user();
        $diaChi  = DiaChi::where('id', $request->id_dia_chi_khach_hang)
            ->where('id_khach_hang', $khachHang->id)
            ->first();
        if (!$diaChi) {
            return response()->json([
                'status' => false,
                'message' => "Địa chỉ chưa được chọn"
            ]);
        } else if (count($request->ds_mua_sp) < 1) {
            return response()->json([
                'status' => false,
                'message' => "Giỏ hàng chưa có sản phẩm"
            ]);
        } else {
            $DonHang = DonHang::create([
                'ma_don_hang'           =>  'Em chưa có, chờ xíu',
                'id_khach_hang'         =>  $khachHang->id,
                'id_dia_chi'            =>  $request->id_dia_chi,
                'tong_tien'             =>  $request->tong_tien,
                'ma_code_giam'          =>  $request->ma_code_giam,
                'so_tien_giam'          =>  $request->so_tien_giam,
                'so_tien_thanh_toan'    =>  $request->so_tien_thanh_toan,
            ]);
        }
        $DonHang->ma_don_hang    = 'DZ' . $DonHang->id;
        $DonHang->save();

        $tienThanhToan    = 0;

        foreach ($request->list_san_pham_can_mua as $key => $value) {
            $chiTiet    = ChiTietDonHang::where('id', $value)
                ->where('id_khach_hang', $khachHang->id)
                ->where('is_gio_hang', 1)
                ->first();
            if ($chiTiet) {
                $chiTiet->is_gio_hang   = 0;
                $chiTiet->id_don_hang   = $DonHang->id;
                $chiTiet->save();
            }
        }
        // Gửi mail

        $x['ho_ten']                    = $khachHang->ho_va_ten;
        $x['so_tien_thanh_toan']        = $request->so_tien_thanh_toan;
        $x['link_qr']                   = "https://img.vietqr.io/image/MBBank-1910061030119-qr_only.png?amount=" . $request->so_tien_thanh_toan . "&addInfo=DZ" . $DonHang->id;
        $x['ds_for']    =  ChiTietDonHang::where('id_khach_hang', $khachHang->id)
            ->where('id_don_hang', $DonHang->id)
            ->where('is_gio_hang', 0)
            ->join('san_phams', 'chi_tiet_don_hangs.id_san_pham', 'san_phams.id')
            ->select('chi_tiet_don_hangs.*', 'san_phams.hinh_anh',)
            ->get();
        Mail::to($khachHang->email)->send(new MasterMail('Xác Nhận Đơn Hàng', 'xac_nhan_don_hang', $x));

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Mua hàng thành công! <br> Vui lòng kiểm tra mail để thanh toán!'
        ]);
    }

    public function getDataLS()
    {
        $khachHang  = Auth::guard('sanctum')->user();
        $data = ChiTietDonHang::where('chi_tiet_don_hangs.id_khach_hang', $khachHang->id)
                            ->join('don_hangs' , 'chi_tiet_don_hangs.id_don_hang', 'don_hangs.id')
                            ->join('san_phams', 'chi_tiet_don_hangs.id_san_pham', 'san_phams.id')
                            ->join('khach_hangs', 'chi_tiet_don_hangs.id_khach_hang', 'khach_hangs.id')
                            ->join('dia_chis', 'khach_hangs.id', 'dia_chis.id_khach_hang')
                            ->join('dai_lys', 'chi_tiet_don_hangs.id_dai_ly', 'dai_lys.id')
                            ->select('don_hangs.ma_don_hang', 'don_hangs.is_thanh_toan', 'san_phams.ten_san_pham', 'dai_lys.ten_doanh_nghiep', 'dia_chis.ten_nguoi_nhan', 'dia_chis.dia_chi', 'dia_chis.so_dien_thoai', 'chi_tiet_don_hangs.*')
                            ->get();
        return response()->json([
            'data'    =>  $data,
        ]);
    }

    public function getDataLSDL()
    {
        $daiLy  = Auth::guard('sanctum')->user();
        $data = ChiTietDonHang::where('chi_tiet_don_hangs.id_dai_ly', $daiLy->id)
                            ->join('don_hangs' , 'chi_tiet_don_hangs.id_don_hang', 'don_hangs.id')
                            ->join('san_phams', 'chi_tiet_don_hangs.id_san_pham', 'san_phams.id')
                            ->join('khach_hangs', 'chi_tiet_don_hangs.id_khach_hang', 'khach_hangs.id')
                            ->join('dia_chis', 'khach_hangs.id', 'dia_chis.id_khach_hang')
                            ->join('dai_lys', 'chi_tiet_don_hangs.id_dai_ly', 'dai_lys.id')
                            ->select('don_hangs.ma_don_hang', 'don_hangs.is_thanh_toan', 'san_phams.ten_san_pham', 'dai_lys.ten_doanh_nghiep', 'dia_chis.ten_nguoi_nhan', 'dia_chis.dia_chi', 'dia_chis.so_dien_thoai', 'chi_tiet_don_hangs.*')
                            ->get();
        return response()->json([
            'data'    =>  $data,
        ]);
    }
    public function xuatExcelDonHang()
    {
        $data = DonHang::get();
        foreach ($data as $key => $value) {
            $value->stt = $key + 1;
        }
        return Excel::download(new ExcelDsDonHangExport($data), 'don_hang.xlsx');
    }
    public function changeStatusLSDL(Request $request)
    {
        $daiLy  = Auth::guard('sanctum')->user();
        $ctdh = ChiTietDonHang::where('id', $request->id)->where('id_dai_ly', $daiLy->id)->first();
        if($ctdh) {
            $ctdh->tinh_trang = $request->tinh_trang;
            $ctdh->save();
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đổi tình trạng đơn hàng thành công!'
            ]);
        }   
        return response()->json([
            'status'    =>  false,
            'message'   =>  'Có lỗi xảy ra!'
        ]);     
    }

    public function getDataLSAD()
    {
        $data = ChiTietDonHang::join('don_hangs' , 'chi_tiet_don_hangs.id_don_hang', 'don_hangs.id')
                            ->join('san_phams', 'chi_tiet_don_hangs.id_san_pham', 'san_phams.id')
                            ->join('khach_hangs', 'chi_tiet_don_hangs.id_khach_hang', 'khach_hangs.id')
                            ->join('dia_chis', 'khach_hangs.id', 'dia_chis.id_khach_hang')
                            ->join('dai_lys', 'chi_tiet_don_hangs.id_dai_ly', 'dai_lys.id')
                            ->select('don_hangs.ma_don_hang', 'don_hangs.is_thanh_toan', 'san_phams.ten_san_pham', 'dai_lys.ten_doanh_nghiep', 'dia_chis.ten_nguoi_nhan', 'dia_chis.dia_chi', 'dia_chis.so_dien_thoai', 'chi_tiet_don_hangs.*')
                            ->get();
        return response()->json([
            'data'    =>  $data,
        ]);
    }
}
