<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface  as ProvinceRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface  as PromotionRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface  as OrderRepository;
use App\Http\Requests\StoreCartRequest;
use Cart;
use App\Classes\Vnpay;
use App\Classes\Momo;
use App\Classes\Paypal;
use App\Classes\Zalo;

class CartController extends FrontendController
{
  
    protected $provinceRepository;
    protected $promotionRepository;
    protected $orderRepository;
    protected $cartService;
    protected $vnpay;
    protected $momo;
    protected $paypal;
    protected $zalo;

    public function __construct(
        ProvinceRepository $provinceRepository,
        PromotionRepository $promotionRepository,
        OrderRepository $orderRepository,
        CartService $cartService,
        Vnpay $vnpay,
        Momo $momo,
        Paypal $paypal,
        Zalo $zalo,
    ){
       
        $this->provinceRepository = $provinceRepository;
        $this->promotionRepository = $promotionRepository;
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
        $this->vnpay = $vnpay;
        $this->momo = $momo;
        $this->paypal = $paypal;
        $this->zalo = $zalo;
        parent::__construct();
    }


    public function checkout(){
        $provinces = $this->provinceRepository->all();
        $carts = Cart::instance('shopping')->content();
        $carts = $this->cartService->remakeCart($carts);
        $cartCaculate = $this->cartService->reCaculateCart();
        $cartPromotion = $this->cartService->cartPromotion($cartCaculate['cartTotal']);

        $seo = [
            'meta_title' => 'Trang thanh toán đơn hàng',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => write_url('thanh-toan', TRUE, TRUE),
        ];
        $system = $this->system;
        $config = $this->config();
        return view('frontend.cart.index', compact(
            'config',
            'seo',
            'system',
            'provinces',
            'carts',
            'cartPromotion',
            'cartCaculate',
        ));
        
    }

    // public function store(StoreCartRequest $request){
    //     $system = $this->system;
    //     $order = $this->cartService->order($request, $system);
    //     if($order['flag']){
    //         if($order['order']->method !== 'cod'){
    //             $response = $this->paymentMethod($order);
    //             if($response['errorCode'] == 0){
    //                 return redirect()->away($response['url']);
    //             }
    //         }
    //         return redirect()->route('cart.success', ['code' => $order['order']->code])->with('success','Đặt hàng thành công');
    //     }
    //     return redirect()->route('cart.checkout')->with('error','Đặt hàng không thành công. Hãy thử lại');
    // }

    // public function store(StoreCartRequest $request){
    //     $system = $this->system;
    //     $order = $this->cartService->order($request, $system);
    
    //     if ($order['flag']) {
    //         if ($order['order']->method !== 'cod') {
    //             $response = $this->paymentMethod($order);
    //             if ($response['errorCode'] == 0) {
    //                 return redirect()->away($response['url']);
    //             } else {
    //                 return redirect()->route('cart.checkout')->with('error', 'Thanh toán thất bại.');
    //             }
    //         }
    //         return redirect()->route('cart.success', ['code' => $order['order']->code])->with('success', 'Đặt hàng thành công');
    //     }
    
    //     return redirect()->route('cart.checkout')->with('error', 'Đặt hàng không thành công. Hãy thử lại');
    // }
    public function store(StoreCartRequest $request){
    $system = $this->system;
    $order = $this->cartService->order($request, $system);

    if ($order['flag']) {
        if ($order['order']->method !== 'cod') {
            $response = $this->paymentMethod($order);
            if ($response['errorCode'] == 0) {
                return redirect()->away($response['url']);
            } else {
                return redirect()->route('cart.checkout')->with('error', 'Thanh toán thất bại.');
            }
        }

        // Nếu COD thì clear luôn giỏ hàng ở đây
        Cart::instance('shopping')->destroy();

        return redirect()->route('cart.success', ['code' => $order['order']->code])->with('success', 'Đặt hàng thành công');
    }

    return redirect()->route('cart.checkout')->with('error', 'Đặt hàng không thành công. Hãy thử lại');
}

    // public function success($code){
    //     $order = $this->orderRepository->findByCondition([
    //         ['code', '=', $code],
    //     ], false, ['products']);
        
    //     if (!$order) {
    //         return redirect()->route('cart.checkout')->with('error', 'Không tìm thấy đơn hàng.');
    //     }
    
    //     if ($order->payment !== 'paid') {
    //         return redirect()->route('cart.checkout')->with('error', 'Thanh toán chưa thành công hoặc bị hủy.');
    //     }
    //     $seo = [
    //         'meta_title' => 'Thanh toán đơn hàng thành công',
    //         'meta_keyword' => '',
    //         'meta_description' => '',
    //         'meta_image' => '',
    //         'canonical' => write_url('cart/success', TRUE, TRUE),
    //     ];
    //     $system = $this->system;
    //     $config = $this->config();
    //     return view('frontend.cart.success', compact(
    //         'config',
    //         'seo',
    //         'system',
    //         'order'
    //     ));
    // }

    public function success($code){
        $order = $this->orderRepository->findByCondition([
            ['code', '=', $code],
        ], false, ['products']);
        
        if (!$order) {
            return redirect()->route('cart.checkout')->with('error', 'Không tìm thấy đơn hàng.');
        }
    
        // Nếu không phải COD mà chưa thanh toán thì mới báo lỗi
        if ($order->method !== 'cod' && $order->payment !== 'paid') {
            return redirect()->route('cart.checkout')->with('error', 'Thanh toán chưa thành công hoặc bị hủy.');
        }
    
        $seo = [
            'meta_title' => 'Thanh toán đơn hàng thành công',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => write_url('cart/success', TRUE, TRUE),
        ];
        $system = $this->system;
        $config = $this->config();
        return view('frontend.cart.success', compact(
            'config',
            'seo',
            'system',
            'order'
        ));
    }
    
    public function paymentMethod($order = null){
        $class = $order['order']->method;
        $response = $this->{$class}->payment($order['order']);
        return $response;
    }

    
    private function config(){
        return [
            'language' => $this->language,
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/location.js',
                'frontend/core/library/cart.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
    }
    public function momoCallback(Request $request)
    {
        // Lấy thông tin từ MoMo trả về
        $errorCode = $request->input('errorCode');
        $orderId = $request->input('orderId');
        $amount = $request->input('amount');
        $order = $this->orderRepository->findByCondition([
            ['code', '=', $orderId],
        ]);
    
        if (!$order) {
            return redirect()->route('cart.checkout')->with('error', 'Không tìm thấy đơn hàng.');
        }
    
        if ($errorCode == '0') {
            // Thành công: Xóa giỏ hàng
            Session::forget('cart');
            return redirect()->route('cart.success', ['code' => $order->code])
                ->with('success', 'Thanh toán thành công.');
        } else {
            // Thanh toán thất bại hoặc bị hủy
            return redirect()->route('cart.checkout')
                ->with('error', 'Giao dịch bị hủy hoặc thất bại.');
        }
    }
    

}
