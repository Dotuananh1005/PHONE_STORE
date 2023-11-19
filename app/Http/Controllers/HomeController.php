<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class HomeController extends Controller
{
    /**
     * @return Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::logout();

        // Chuyển hướng người dùng về trang chủ hoặc trang đăng nhập (tùy chọn)
        return redirect('/');
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $product = Product::where('product.status', 'valid')
            ->leftJoin('category', 'category.id', '=', 'category_id')
            ->select('product.*', 'category.name as name_category')
            ->get();
        $category = DB::table('category')->get();

        return view('index', compact('product', 'category'));
    }

    /**
     * @param $slug
     * @return Application|Factory|View
     */
    public function view($slug)
    {
        $model = Category::where('slug', $slug)->first();
        $product = Product::where('slug', $slug)->first();
        $category = Category::orderBy('name', 'ASC')->get();
        if ($model) {
            $category_name = $model->name;
            return view('categoryProduct', ['model' => $model, 'category' => $category, 'category_name' =>$category_name]);
        } else if ($product) {
            return view('product-detail', ['model' => $product, 'category' => $category]);
        } else {
            return view('404');
        }
    }
}
