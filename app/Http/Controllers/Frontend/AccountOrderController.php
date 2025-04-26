<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class AccountOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('customer_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        $system = config('system'); // 👈 Lấy $system (giả sử trong config)

        $seo = [
            'meta_title' => 'Đơn hàng của tôi',
            'meta_description' => 'Thông tin các đơn hàng đã đặt.',
            'meta_keyword' => 'Đơn hàng, mua hàng',
            'canonical' => url()->current(),
            'meta_image' => asset('path/to/default-image.jpg'),
        ];

        return view('frontend.account.orders.index', compact('orders', 'system', 'seo'));
    }

    public function show($code)
    {
        $order = Order::where('customer_id', Auth::id())
                    ->where('code', $code)
                    ->firstOrFail();

        $system = config('system');

        $seo = [
            'meta_title' => 'Chi tiết đơn hàng',
            'meta_description' => 'Xem chi tiết đơn hàng của bạn.',
            'meta_keyword' => 'Chi tiết đơn hàng, đơn hàng',
            'canonical' => url()->current(),
            'meta_image' => asset('path/to/default-image.jpg'),
        ];

        return view('frontend.account.orders.show', compact('order', 'system', 'seo'));
    }
}
