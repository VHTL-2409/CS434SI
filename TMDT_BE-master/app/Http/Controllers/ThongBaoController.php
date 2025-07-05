<?php

namespace App\Http\Controllers;

use App\Models\ThongBao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ThongBaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getData()
    {
        $user = Auth::guard('sanctum')->user();
        $data = ThongBao::where('id_nhan_vien',$user->id)->orderByDESC('id')->get();
        return response()->json([
            'data'    =>  $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        ThongBao::create([
                'tieu_de'  => $request->tieu_de,        
                'noi_dung'     => $request->noi_dung,     
                'icon_thong_bao'    => $request->icon_thong_bao,
                'color_thong_bao'  => $request->color_thong_bao,
                'id_nhan_vien'    => $request->id_nhan_vien, 
        ]);
        return response()->json([
            'status'    =>true,
            'message'   => "đã tạo mới thông báo" 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ThongBao $thongBao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThongBao $thongBao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThongBao $thongBao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThongBao $thongBao)
    {
        //
    }
}
