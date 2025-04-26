@extends('frontend.homepage.layout')
@section('content')
<div class="uk-container uk-container-center mt20">
    <h2>Đơn hàng của tôi</h2>
    @if($orders->count())
    <table class="uk-table uk-table-divider">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Thanh toán</th>
                <th>Giao hàng</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $o)
            <tr>
                <td>{{ $o->code }}</td>
                <td>{{ $o->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ number_format($o->total,0,',','.') }}₫</td>
                <td>
                    @if($o->payment == 'paid') <span class="uk-text-success">Đã thanh toán</span>
                    @else <span class="uk-text-warning">Chưa thanh toán</span>@endif
                </td>
                <td>
                    @if($o->delivery == 'delivered') <span class="uk-text-success">Đã giao</span>
                    @elseif($o->delivery == 'shipping') <span class="uk-text-primary">Đang giao</span>
                    @else <span class="uk-text-warning">Chờ xử lý</span>@endif
                </td>
                <td><a href="{{ route('customer.orders.show', $o->code) }}">Xem</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
    @else
        <p>Bạn chưa có đơn hàng nào.</p>
    @endif
</div>
@endsection
