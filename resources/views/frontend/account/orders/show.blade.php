@extends('frontend.homepage.layout')
@section('content')
<div class="uk-container uk-container-center mt20">
    <h2>Chi tiết đơn {{ $order->code }}</h2>

    <ul class="uk-list">
        <li><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</li>
        <li><strong>Thanh toán:</strong> {{ $order->payment == 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}</li>
        <li><strong>Giao hàng:</strong> 
            @switch($order->delivery)
                @case('delivered') Đã giao @break
                @case('shipping') Đang giao @break
                @default Chờ xử lý
            @endswitch
        </li>
    </ul>

    <h3>Sản phẩm</h3>
    <table class="uk-table uk-table-divider">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->products as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->pivot->qty }}</td>
                <td>{{ number_format($item->pivot->price,0,',','.') }}₫</td>
                <td>{{ number_format($item->pivot->price * $item->pivot->qty,0,',','.') }}₫</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <p><strong>Tổng cộng:</strong> {{ number_format($order->total,0,',','.') }}₫</p>
</div>
@endsection
