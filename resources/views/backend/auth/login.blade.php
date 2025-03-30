<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {{-- <title>LARAVEL CMS 01</title> --}}

        <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

        <link href="{{ asset('backend/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/css/customize.css') }}" rel="stylesheet">

    </head>

    <body class="gray-bg">

        <div class="loginColumns animated fadeInDown">
            <div class="row">

                <div class="col-md-6">
                    <h2 class="font-bold">Chào mừng đến với hệ thống quản lý VpHome!</h2>
                
                    <p>
                        Đây là nơi bạn có thể dễ dàng theo dõi và quản lý các sản phẩm, đơn hàng, cũng như thông tin khách hàng một cách nhanh chóng.
                    </p>
                
                    <p>
                        Giao diện thân thiện, trực quan giúp bạn làm việc hiệu quả mà không mất nhiều thời gian làm quen.
                    </p>
                
                    <p>
                        Mọi thao tác từ cập nhật sản phẩm, kiểm soát kho hàng đến xử lý đơn hàng đều được thực hiện chỉ với vài cú nhấp chuột.
                    </p>
                
                    <p>
                        <small>Hãy cùng VpHome đơn giản hóa quy trình quản lý và nâng cao hiệu suất làm việc!</small>
                    </p>
                </div>
                
                <div class="col-md-6">
                    <div class="ibox-content">
                      
                        <form method="post" class="m-t" role="form" action="{{ route('auth.login') }}">
                            @csrf
                            <div class="form-group">
                                <input 
                                    type="text" 
                                    name="email"
                                    class="form-control" 
                                    placeholder="Email" 
                                    value="{{ old('email') }}"
                                >
                                @if ($errors->has('email'))
                                    <span class="error-message">* {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input 
                                    type="password" 
                                    name="password"
                                    class="form-control" 
                                    placeholder="Password" 
                                >
                                @if ($errors->has('password'))
                                    <span class="error-message">* {{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success block full-width m-b">Đăng nhập</button>

                            {{-- <a href="#">
                                <small>Forgot password?</small>
                            </a> --}}
                        </form>
                        {{-- <p class="m-t">
                            <small>Newbie Code we app framework base on Bootstrap 3 &copy; 2014</small>
                        </p> --}}
                    </div>
                </div>
            </div>
            <hr/>
            {{-- <div class="row">
                <div class="col-md-6">
                    Copyright Example Company
                </div>
                <div class="col-md-6 text-right">
                <small>© 2025</small>
                </div>
            </div> --}}
        </div>

    </body>

</html>
