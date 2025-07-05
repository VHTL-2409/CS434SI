<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SanPhamThemMoiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ten_san_pham'     => 'required|min:3|max:255',
            'slug_san_pham'    => 'required|max:255',
            'so_luong'         => 'required|numeric|min:0',
            'hinh_anh'         => 'required', 
            'tinh_trang'       => 'required|boolean', 
            'mo_ta_ngan'       => 'required|max:500',
            'mo_ta_chi_tiet'   => 'required|max:500',
            'gia_ban'          => 'required|numeric|min:0',
            'gia_khuyen_mai'   => 'required|numeric|min:0|lt:gia_ban', 
            'sao_danh_gia'     => 'required|numeric|min:0|max:5', 
            'tag'              => 'required|max:255',
        ];
    }
    public function messages(): array
{
    return [
        'ten_san_pham.required'         => 'Tên sản phẩm là bắt buộc.',
        'ten_san_pham.min'              => 'Tên sản phẩm phải có ít nhất 3 ký tự.',
        'ten_san_pham.max'              => 'Tên sản phẩm không được vượt quá 255 ký tự.',
        
        'slug_san_pham.required'   => 'Slug sản phẩm là bắt buộc.',
        'slug_san_pham.max'        => 'Slug sản phẩm không được vượt quá 255 ký tự.',
        
        'so_luong.required'        => 'Số lượng là bắt buộc.',
        'so_luong.numeric'         => 'Số lượng phải là một số.',
        'so_luong.min'             => 'Số lượng không được nhỏ hơn 0.',
        
        'hinh_anh.required'        => 'Hình ảnh là bắt buộc.',
        
        'tinh_trang.required'      => 'Tình trạng sản phẩm là bắt buộc.',
        'tinh_trang.boolean'       => 'Tình trạng sản phẩm phải là true hoặc false.',
        
        'mo_ta_ngan.required'      => 'Mô tả ngắn là bắt buộc.',
        'mo_ta_ngan.max'           => 'Mô tả ngắn không được vượt quá 500 ký tự.',
        
        'mo_ta_chi_tiet.required'  => 'Mô tả chi tiết là bắt buộc.',
        'mo_ta_chi_tiet.max'       => 'Mô tả chi tiết không được vượt quá 500 ký tự.',
        
        'gia_ban.required'         => 'Giá bán là bắt buộc.',
        'gia_ban.numeric'          => 'Giá bán phải là một số.',
        'gia_ban.min'              => 'Giá bán không được nhỏ hơn 0.',
        
        'gia_khuyen_mai.required'  => 'Giá khuyến mãi là bắt buộc.',
        'gia_khuyen_mai.numeric'   => 'Giá khuyến mãi phải là một số.',
        'gia_khuyen_mai.min'       => 'Giá khuyến mãi không được nhỏ hơn 0.',
        'gia_khuyen_mai.lt'        => 'Giá khuyến mãi phải nhỏ hơn giá bán.',
        
        'sao_danh_gia.required'    => 'Số sao đánh giá là bắt buộc.',
        'sao_danh_gia.numeric'     => 'Số sao đánh giá phải là một số.',
        'sao_danh_gia.min'         => 'Số sao đánh giá không được nhỏ hơn 0.',
        'sao_danh_gia.max'         => 'Số sao đánh giá không được vượt quá 5.',
        
        'tag.required'             => 'Tag sản phẩm là bắt buộc.',
        'tag.max'                  => 'Tag sản phẩm không được vượt quá 255 ký tự.',
    ];
}

}
