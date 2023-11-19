<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function League\Flysystem\get;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $title = "hello laravel";
        $name = "tuntuncute";
        $category = DB::table('category')
                    ->get();
        // $product = product::all()// Tự động lấy ra detele_at là null
        //      // lấy theo điều kiện và trả về 1 dòng dữ liệu
        //      $product = DB::table('products')
        //      ->where('id','=',1)

        //      ->first();
        //  // thực hiện truy vấn theo nhiều điều kiện
        //  $productCondition = DB::table('products')
        //      ->where('id','>=',1)
        //      ->where('id','<',5)// tương đương với toán tử and
        //      ->orWhere('email','=','hassie96@example.net')
        //      // tương đương với toán tử or
        //      ->get();
        return view('category.category', compact('title', 'name', 'category'));
    }
    public function addCategory(CategoryRequest $request)
    {
        if ($request->isMethod('POST')) { // tồn tại phương thức post
            //     DB::table('category')->insert([
            //         'email' => '',
            //         'votes' => 0
            //     ]);
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $params['image'] = uploadFile('hinh', $request->file('image'));
            }

            $category = category::create($params);

            if ($category->id) {
                Session::flash('success', 'Thêm mới thành công');
                return redirect('/adminCategory');
            }
        }
        return view('category.add');
    }
    public function editCategory(CategoryRequest $request, $id)
    {
        // cách 1
        // $category = DB::table('category')
        // -> where('id',$id)->first();
        //cách 2
        $category = category::find($id);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // có file mới upload lên sẽ link vào ảnh cũ để xóa đi " giảm tải dữ liệu serve"
                $resultDL = Storage::delete('/public/' . $category->image);
                if ($resultDL) {
                    $params['image'] = uploadFile('hinh', $request->file('image'));
                } else {
                    $params['image'] = $category->image;
                }
            }
            $result = category::where('id', $id)
                ->update($params);
            if ($result) {
                Session::flash('success', 'Sửa thành công');
                return redirect('/adminCategory');
            }
        }
        return view('category.edit',compact('category'));
    }
    public function delete($id)
    {
        category::where('id', $id)->delete();
        Session::flash('success', 'xóa thành công');
        return redirect('/adminCategory');
    }
}
