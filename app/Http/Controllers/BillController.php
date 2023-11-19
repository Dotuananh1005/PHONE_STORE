<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Bill;
use App\Models\ProductSize;

/**
 *
 */
class BillController extends Controller
{
    //
    /**
     * @return Application|Factory|View
     */
    public function showBill()
    {

        $cart = Cart::with('cartProducts.productSize')->where('user_id', auth()->user()->id)->first();
        $cartItems = $cart->cartProducts;
        $totalPrice = $cartItems->sum('total_price');

        $product_size = ProductSize::all();
        $category = Category::all();
        return view('bill', compact('cartItems', 'totalPrice', 'category', 'product_size'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function applyCoupon(Request $request)
    {
        $cp = Coupon::where('content', $request->get('content'))->where('status', 'new')->where('count', '>', 0)->first();
        if ($request->get('content') && !$cp) {
            return response()->json([
                'status' => 500,
                'message' => "Coupon ko đúng hoặc đã hết hạn"
            ]);
        }
        return response()->json([
            'status' => 200,
            'data' => $cp->value,
            'message' => "Áp dụng thành công"
        ]);
    }

    /**
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function checkout(Request $request)
    {
        $cp = Coupon::where('content', $request->get('coupon'))->where('status', 'new')->where('count', '>', 0)->first();

        if ($request->coupon && !$cp) {
            return redirect()->back()->with('error', 'Không có coupon.');
        }

        // Lấy thông tin từ người dùng
        $customerName = $request->input('customer_name');
        $customerEmail = $request->input('customer_email');
        $customerAddress = $request->input('customer_address');
        $customerPhone = $request->input('customer_phone');
        $paymentMethod = $request->input('payment_method');

        // Lấy sản phẩm trong giỏ hàng của người dùng
        $cart = Cart::with(['cartProducts.productSize', 'cartProducts.product'])->where('user_id', auth()->user()->id)->first();
        $cartItems = $cart->cartProducts;

        // Tính tổng giá trị hóa đơn
        $totalPrice = 0;
        foreach ($cartItems as $cartItem) {
            $totalPrice += $cartItem->total_price;
        }
        if ($cp) {
            $totalPrice -= $totalPrice * $cp->value;
            $cp->count -= 1;
            $cp->save();
        }

        // thong tin san pham
        $products = [];
        foreach ($cartItems as $cartItem) {
            $products[] = $cartItem->toArray();
        }
        // Tạo hóa đơn mới
        $bill = new Bill([
            'user_id' => auth()->user()->id,
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_address' => $customerAddress,
            'total_price' => $totalPrice,
            'status' => 'Xác Nhận', // Có thể thay đổi trạng thái mặc định
            'customer_phone' => $customerPhone,
            'payment_method' => $paymentMethod,
            'date' => now(),
            'product' => json_encode($products),
            'discount' => $cp ? $totalPrice * $cp->value : 0,
        ]);
        $bill->save();

        // Xóa giỏ hàng của người dùng (Bạn cần triển khai phương thức này)
        $this->clearCart();

        // Redirect về trang cảm ơn hoặc trang tóm tắt hóa đơn
        return redirect('/')->with('success', 'Đặt hàng thành công. Cảm ơn bạn!');
    }

    // Các phương thức bổ sung...

    /**
     * @return void
     */
    private function clearCart()
    {
        // Triển khai logic của bạn ở đây để xóa giỏ hàng của người dùng
        // Ví dụ: bạn có thể xóa tất cả các sản phẩm trong giỏ hàng liên kết với người dùng
        CartProduct::with('cart')->whereHas('cart', function ($q) {
            return $q->where('user_id', auth()->user()->id);
        })->delete();
    }
    public function show($id)
    {
        // Lấy thông tin đơn hàng từ database
        $orders = Bill::findOrFail($id);

        return view('admin.billdetail', compact('orders'));
    }
    public function index()
    {
        // Lấy tất cả đơn hàng từ database
        $orders = Bill::all();

        return view('admin.bill', compact('orders'));
    }
    public function updateStatus(Request $request, $id)
    {
        $order = Bill::findOrFail($id);

        $newStatus = $request->input('status');

        // Kiểm tra xem trạng thái mới hợp lệ hay không
        if (!in_array($newStatus, ['Xác nhận', 'Đang vận chuyển', 'Đã thanh toán', 'Hủy'])) {
            return redirect()->back()->with('error', 'Invalid status.');
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
    public function showInvoice()
    {
        // Tìm kiếm hóa đơn của người dùng dựa trên ID
        $userId = auth()->id();
        $bills = Bill::where('user_id', $userId)->get()->toArray();
        $category = Category::all();

        return view('authBill', ['bills' => $bills,  'category' => $category]);
    }
}
