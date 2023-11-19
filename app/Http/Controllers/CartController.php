<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCartRequest;
use App\Models\CartProduct;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;

/**
 *
 */
class CartController extends Controller
{
    //
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $category = DB::table('category')->get();

        return view('cart', compact('category'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function addToCart(Request $request, Product $product)
    {
        auth()->user()->load('cart');
        $cart = auth()->user()->cart ? auth()->user()->cart : Cart::create(['user_id' => auth()->user()->id]);
        $cartProduct = CartProduct::firstOrCreate(
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
            ],
            [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => 0,
                'product_size_id' => @ProductSize::first()->id,
                'price' => $product->price, // Giá sản phẩm
                'total_price' => 0, // Tổng tiền ban đầu bằng giá sản phẩm
            ]
        );

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng của người dùng chưa
        if ($cartProduct) {
            // Nếu sản phẩm đã tồn tại, tăng số lượng sản phẩm trong giỏ hàng
            $cartProduct->quantity += 1;
            $cartProduct->total_price = $cartProduct->quantity * $cartProduct->price;
            $cartProduct->save();
        }

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function removeFromCart($id)
    {
        $cartItem = CartProduct::findOrFail($id);
        $cartItem->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }


    /**
     * @return Application|Factory|View
     */
    public function showCart()
    {
        $cart = Cart::with('cartProducts')->where('user_id', auth()->id())->first();
        $cartItems = $cart->cartProducts;
        $totalPrice = $cartItems->sum('total_price');
        $productSize = ProductSize::all();

        $category = Category::all();
        return view('cart', compact('cartItems', 'totalPrice', 'category', 'productSize'));
    }

    /**
     * @param UpdateCartRequest $request
     * @return JsonResponse
     */
    public function updateCart(UpdateCartRequest $request)
    {
        $cartProduct = CartProduct::with('cart')->whereHas('cart', function($q) use ($request) {
            return $q->where('user_id', auth()->user()->id);
        })->where('id', $request->cart_product_id)->first();
        if (!$cartProduct) {
            return response()->json([
                'status' => 500,
                'message' => 'Không tồn tại đơn hàng!'
            ]);
        }
        $cartProduct->update([
            'product_size_id' => $request->product_size_id,
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $cartProduct->price
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Thành công!'
        ]);
    }
}
