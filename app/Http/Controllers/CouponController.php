<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class CouponController extends Controller
{
    //
    public function index()
    {
        $title = "hello laravel";
        $name = "tuntuncute";
        $coupon = DB::table('coupon')
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

        return view('admin.coupon.coupon', compact('title', 'name', 'coupon'));
    }
    public function addCoupon(Request $request)
    {
        if ($request->isMethod('POST')) { // tồn tại phương thức post
            //     DB::table('coupon')->insert([
            //         'email' => '',
            //         'votes' => 0
            //     ]);
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $params['image'] = uploadFile('hinh', $request->file('image'));
            }

            $coupon = coupon::create($params);

            if ($coupon->id) {
                Session::flash('success', 'Thêm mới thành công');
                return redirect('/adminCoupon');
            }
        }
        return view('admin.coupon.add');
    }
    public function editCoupon(Request $request, $id)
    {
        // cách 1
        // $coupon = DB::table('coupon')
        // -> where('id',$id)->first();
        //cách 2
        $coupon = coupon::find($id);
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                // có file mới upload lên sẽ link vào ảnh cũ để xóa đi " giảm tải dữ liệu serve"
                $resultDL = Storage::delete('/public/' . $coupon->image);
                if ($resultDL) {
                    $params['image'] = uploadFile('hinh', $request->file('image'));
                } else {
                    $params['image'] = $coupon->image;
                }
            }
            $result = coupon::where('id', $id)
                ->update($params);
            if ($result) {
                Session::flash('success', 'Sửa thành công');
                return redirect('/adminCoupon');
            }
        }
        return view('admin.coupon.edit',compact('coupon'));
    }
    public function delete($id)
    {
        coupon::where('id', $id)->delete();
        Session::flash('success', 'xóa thành công');
        return redirect('/adminCoupon');
    }
}
