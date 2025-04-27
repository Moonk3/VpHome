<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    // Constructor để áp dụng middleware
    public function __construct()
    {
        // Áp dụng middleware auth:customer cho tất cả các phương thức trong controller
        $this->middleware('auth:customer');
    }

    public function index()
    {
        // Chắc chắn người dùng đã đăng nhập và có thể truy cập vào đơn hàng
        if (Auth::guard('customer')->check()) {
            $orders = Order::where('customer_id', Auth::guard('customer')->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('frontend.orders.index', compact('orders'));
        } else {
            return redirect()->route('customer.login');
        }
    }

    public function show($id)
    {
        // Lấy chi tiết đơn hàng của khách hàng đã đăng nhập
        $order = Order::with('products')
            ->where('customer_id', Auth::guard('customer')->id())
            ->where('id', $id)
            ->firstOrFail();

        return view('frontend.orders.show', compact('order'));
    }
}
