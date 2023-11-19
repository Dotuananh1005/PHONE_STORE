<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
class ProductController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $title = "hello laravel";
        $name = "tuntuncute";
        $product = Product::whereNull('deleted_at') // lấy theo số trường mình mong muốn
        ->leftJoin('category', 'category.id', '=', 'category_id')
        ->select('product.*', 'category.name as name_category')
        ->get();
        // $product = Product::all()// Tự động lấy ra detele_at là null
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
        return view('admin.product', compact('title', 'name', 'product'));
    }

    /**
     * @param ProductRequest $request
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function addProduct(ProductRequest $request)
    {
        if ($request->isMethod('POST')) { // tồn tại phương thức post
            //     DB::table('product')->insert([
            //         'email' => '',
            //         'votes' => 0
            //     ]);
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $params['image'] = uploadFile('hinh', $request->file('image'));
            }

            $product = Product::create($params);

            if ($product->id) {
                Session::flash('success', 'Thêm mới thành công');
                return redirect('/adminProduct');
            }
        }
        $category = Category::all();
        return view('admin.add', compact('category'));
    }

    /**
     * @param ProductRequest $request
     * @param $id
     * @return Application|Factory|View|RedirectResponse|Redirector
     */
    public function editProduct(ProductRequest $request, $id)
    {
        // cách 1
        // $product = DB::table('product')
        // -> where('id',$id)->first();
        //cách 2
        $product = Product::find($id);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // có file mới upload lên sẽ link vào ảnh cũ để xóa đi " giảm tải dữ liệu serve"
                $resultDL = Storage::delete('/public/' . $product->image);
                if ($resultDL) {
                    $params['image'] = uploadFile('hinh', $request->file('image'));
                } else {
                    $params['image'] = $product->image;
                }
            }
            $params['status'] = $params['quantity'] > 0 ? 'valid' : 'invalid';
            $result = Product::where('id', $id)
                ->update($params);
            if ($result) {
                Session::flash('success', 'Sửa thành công');
                return redirect('/adminProduct');
            }
        }
        $category = Category::all();
        return view('admin.edit', compact('product', 'category'));
    }

    /**
     * @param $id
     * @return Application|RedirectResponse|Redirector
     */
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        Session::flash('success', 'xóa thành công');
        return redirect('/adminProduct');
    }
}
