<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        // tạo ra 1 mảng
        $rules = [];
        // lấy ra tên phương thức cần xử lí
        $currentAction = $this->route()->getActionMethod();
        switch ($this->method()):
            case 'POST':
                switch ($currentAction):
                    case 'addProduct':
                        // xây dựng rules vadilate trong này
                        $rules = [
                            'name' => 'required',
                            'price_import' => 'required',
                            'price' => 'required',
                            'category_id' => 'required',
                            'information' => 'required',
                            'date' => 'required',
                            'quantity' => 'required',                            
                            'image' => 'required' //|image|mimes:jpeg,jpg,png|max:5210'//5210 kb = 5mb
                        ];
                    case 'editProduct':
                        // xây dựng rules vadilate trong này
                        $rules = [
                            'name' => 'required',
                            'price_import' => 'required',
                            'price' => 'required',
                            'category_id' => 'required',
                            'information' => 'required',
                            'date' => 'required',
                            'quantity' => 'required',
                            'image' => 'required' //|image|mimes:jpeg,jpg,png|max:5210'//5210 kb = 5mb
                        ];
                endswitch;
                break;

        endswitch;
        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống',
            'price_import' => 'Giá nhập không được để trống',
            'price' => 'Giá bán không được để trống',
            'category_id' => 'Loại sản phẩm không được để trống',
            'information' => 'Thông tin không được để trống',
            'date' => 'Ngày nhập không được để trống',
            'quantity' => 'Số lượng không được để trống',
            'image' => 'Không được để trống ảnh'
        ];
    }
}
