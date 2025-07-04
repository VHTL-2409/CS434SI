<?php

namespace App\Http\Controllers;

use App\Http\Requests\KhachHangDangKyRequest;
use App\Http\Requests\KhachHangDangNhapRequest;
use App\Http\Requests\KhachHangDoiMatKhauRequest;
use App\Mail\MasterMail;
use App\Models\ChiTietPhanQuyen;
use App\Models\KhachHang;
use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KhachHangController extends Controller
{
    public function logout(Request $request)
    {

    }

    public function logoutAll(Request $request)
    {
        
    }

    public function dataKhachHang()
    {
        
        $id_chuc_nang = 28;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $data = KhachHang::get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function kichHoatTaiKhoan(Request $request)
    {
        
        $id_chuc_nang = 29;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            if ($khach_hang->is_active == 0) {
                $khach_hang->is_active = 1;
                $khach_hang->save();

                return response()->json([
                    'status' => true,
                    'message' => "Đã kích hoạt tài khoản thành công!"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function doiTrangThaiKhachHang(Request $request)
    {
        
        $id_chuc_nang = 30;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->is_block = !$khach_hang->is_block;
            $khach_hang->save();

            return response()->json([
                'status' => true,
                'message' => "Đã đổi trạng thái tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!" 
            ]);
        }
    }

    public function updateTaiKhoan(Request $request)
    {
        
        $id_chuc_nang = 31;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->update([
                'email'             => $request->email,
                'so_dien_thoai'     => $request->so_dien_thoai,
                'ho_va_ten'         => $request->ho_va_ten,
            ]);

            return response()->json([
                'status' => true,
                'message' => "Đã cập nhật tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function deleteTaiKhoan(Request $request)
    {
        
        $id_chuc_nang = 32;
        $login = Auth::guard('sanctum')->user();
        $id_quyen = $login->$id_chuc_nang;
        $check_quyen = ChiTietPhanQuyen::where('id_quyen', $id_quyen)
            ->where('id_chuc_nang', $id_chuc_nang)
            ->first();
        if ($check_quyen) {
            return response()->json([
                'data' => false,
                'message' => "bạn không có quyền thực hiện chức năng này!"
            ]);
        }
        $khach_hang = KhachHang::where('id', $request->id)->first();

        if ($khach_hang) {
            $khach_hang->delete();

            return response()->json([
                'status' => true,
                'message' => "Đã đổi trạng thái tài khoản thành công!"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => "Có lỗi xảy ra!"
            ]);
        }
    }

    public function dangKy(KhachHangDangKyRequest $request)
    {
        $hash_active    = Str::uuid();

        $khachHang = KhachHang::create([
            'email'             => $request->email,
            'so_dien_thoai'     => $request->so_dien_thoai,
            'ho_va_ten'         => $request->ho_va_ten,
            'password'          => bcrypt($request->password),
            'hash_active'       => $hash_active
        ]);

        $data['ho_va_ten']  = $request->ho_va_ten;
        $data['link']       = 'http://localhost:5173/khach-hang/kich-hoat/' . $hash_active;

        Mail::to($request->email)->send(new MasterMail('Kích Hoạt Tài Khoản', 'dang_ky', $data));

        return response()->json([
            'status' => true,
            'message' => "Đăng Kí Tài Khoản Thành Công!"
        ]);
    }

    public function dangNhap(KhachHangDangNhapRequest $request)
    {
        $check  =   Auth::guard('khachhang')->attempt([
            'email'     => $request->email,
            'password'  => $request->password
        ]);

        if ($check) {
            // Lấy thông tin tài khoản đã đăng nhập thành công
            $khach_hang  =   Auth::guard('khachhang')->user(); // Lấy được thông tin đại lý đã đăng nhập
            ThongBao::create([
                'tieu_de'           =>  'Đăng nhập',        
                'noi_dung'          =>  'Bạn đã đăng nhập thành công',  
                'icon_thong_bao'    =>   'fa-solid fa-plus',
                'color_thong_bao'   =>  'text-info',
                'id_nhan_vien'      => $khach_hang->id,  
            ]);
            return response()->json([
                'status'    => true,
                'message'   => "Đã đăng nhập thành công!",
                'token'     => $khach_hang->createToken('token_khach_hang')->plainTextToken,
                'ten_kh'    => $khach_hang->ho_va_ten
            ]);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => "Tài khoản hoặc mật khẩu không đúng!",
            ]);
        }
    }

    public function kiemTraKhachHang()
    {
        $tai_khoan_dang_dang_nhap   = Auth::guard('sanctum')->user();
        if($tai_khoan_dang_dang_nhap && $tai_khoan_dang_dang_nhap instanceof \App\Models\KhachHang) {
            return response()->json([
                'status'    =>  true
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Bạn cần đăng nhập hệ thống trước'
            ]);
        }
    }

    public function getDataProfile()
    {
        $tai_khoan_dang_dang_nhap   = Auth::guard('sanctum')->user();
        return response()->json([
            'data'    =>  $tai_khoan_dang_dang_nhap
        ]);
    }

    public function updateProfile(Request $request)
    {
        $tai_khoan_dang_dang_nhap   = Auth::guard('sanctum')->user();
        $check = KhachHang::where('id', $tai_khoan_dang_dang_nhap->id)->update([
            'email'         => $request->email,
            'so_dien_thoai' => $request->so_dien_thoai,
            'ho_va_ten'     => $request->ho_va_ten,
        ]);

        if($check) {
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Cập nhật profile thành công'
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Cập nhật thất bại'
            ]);
        }
    }

    public function kichHoat(Request $request)
    {
        $khach_hang = KhachHang::where('hash_active', $request->id_khach_hang)->first();
        if ($khach_hang && $khach_hang->is_active == 0) {
            $khach_hang->is_active = 1;
            $khach_hang->save();

            return response()->json([
                'status'    =>  true,
                'message'   =>  'Đã kích hoạt tài khoản thành công'
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Liên kết không tồn tại'
            ]);
        }
    }
    public function quenMK(Request $request)
    {
        $khach_hang = KhachHang::where('email', $request->email)->first();
        if($khach_hang){
            $hash_reset         = Str::uuid();
            $x['ho_va_ten']     = $khach_hang->ho_va_ten;
            $x['link']          = 'http://localhost:5173/khach-hang/doi-mat-khau/' . $hash_reset;
            Mail::to($request->email)->send(new MasterMail('Đổi Mật Khẩu Của Bạn', 'quen_mat_khau', $x));
            $khach_hang->hash_reset = $hash_reset;
            $khach_hang->save();
            return response()->json([
                'status'    =>  true,
                'message'   =>  'Vui Lòng kiểm tra lại email'
            ]);
        } else {
            return response()->json([
                'status'    =>  false,
                'message'   =>  'Email không có trong hệ thống'
            ]);
        }
    }

    public function doiMK(KhachHangDoiMatKhauRequest $request)
    {
        $khachHang           = KhachHang::where('hash_reset', $request->id)->first();
        $khachHang->password = bcrypt($request->password);
        $khachHang->hash_reset = NULL;
        $khachHang->save();

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã đổi mật khẩu thành công'
        ]);
    }
    public function updateAvatar(Request $request)
    {
        $user           = Auth::guard('sanctum')->user();
        $data           = $request->all();
        $file           = $data['hinh_anh'];
        $file_extension = $file->getClientOriginalExtension();
        $file_name      = Str::slug($user->ho_va_ten). "." .$file_extension;
        $saved          = "KhachHangAva\\".$file_name;
        $file->move("KhachHangAva",$file_name);
        $hinh_anh ="http://127.0.0.1:8000/". $saved;
        
        KhachHang::find($user->id)->update([
            'hinh_anh'  => $hinh_anh
        ]);
        return response()->json([
            'status'    =>  true,
            'message'   =>  'Đã đổi ảnh đại diện thành công'
        ]);
       
    }
}
