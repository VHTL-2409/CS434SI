<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KhachHangDiaChiRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'dia_chi'           => 'required|min:10|max:40',
            'ten_nguoi_nhan'    => 'required|min:5|max:25',
            'so_dien_thoai'     => 'required|digits:10',
        ];
    }
    public function messages()
    {
        return  [
            'ten_nguoi_nhan.required' => 'Họ và tên không được để trống',
            'ten_nguoi_nhan.min' => 'Họ và tên phải có ít nhất 5 ký tự',
            'ten_nguoi_nhan.max' => 'Họ và tên tối đa 25 kí tự',
            'dia_chi.required' => 'Địa chỉ không được để trống',
            'dia_chi.min' => 'Địa chỉ phải có ít nhất 10 ký tự',
            'dia_chi.max' => 'Địa chỉ tối đa 40 kí tự',
            'so_dien_thoai.required' => 'Số điện thoại không được để trống',
            'so_dien_thoai.digits' => 'Số điện thoại phải đủ 10 số',
        ];
    }
}
