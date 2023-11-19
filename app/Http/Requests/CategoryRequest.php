<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                    case 'addCategory':
                        // xây dựng rules vadilate trong này
                        $rules = [
                            'name' => 'required',
                            'slug' => 'required',
                            //|image|mimes:jpeg,jpg,png|max:5210'//5210 kb = 5mb
                        ];
                        case 'editCategory':
                            // xây dựng rules vadilate trong này
                            $rules = [
                                'name' => 'required',
                                'slug' => 'required',
                                //|image|mimes:jpeg,jpg,png|max:5210'//5210 kb = 5mb
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
            'Slug.required' => 'Slug không được để trống',
        ];
    }
}
