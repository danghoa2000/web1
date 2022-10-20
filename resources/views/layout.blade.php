<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!---------Seo--------->
    <meta name="description" content="{{ $meta_desc }}">
    <meta name="keywords" content="{{ $meta_keywords }}" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <link rel="canonical" href="{{ $url_canonical }}" />
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="" />

    <!--//-------Seo--------->
    <title>{{ $meta_title }}</title>
    <link href="{{ asset('/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('/frontend/css/sweetalert.css') }}" rel="stylesheet">

    <link rel="shortcut icon" href="{{ '/frontend/images/favicon.ico' }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<!--/head-->

<body>
    <header id="header">
        <div class="header_top">
            <!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> 0932023992</a></li>
                                <li><a href="#"><i class="fa fa-envelope"></i> web.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header_top-->

        <div class="header-middle">
            <!--header-middle-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="logo pull-left">
                            <a href="{{ '/' }}"><img src="{{ '/frontend/images/logo.png' }}"
                                    alt="" /></a>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="shop-menu pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="{{ URL::to('/checkout') }}"><i class="fa fa-crosshairs"></i> Thanh
                                        toán</a></li>
                                <li><a href="{{ URL::to('/gio-hang') }}"><i class="fa fa-shopping-cart"></i> Giỏ
                                        hàng</a></li>
                                <?php
                                   $customer_id = Session::get('customer_id');
                                   if($customer_id!=NULL){ 
                                 ?>
                                <li><a href="{{ URL::to('/logout-checkout') }}"><i class="fa fa-lock"></i> Đăng
                                        xuất</a></li>

                                <?php
                            }else{
                                 ?>
                                <li><a href="{{ URL::to('/dang-nhap') }}"><i class="fa fa-lock"></i> Đăng nhập</a>
                                </li>
                                <?php 
                             }
                                 ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-middle-->

        <div class="header-bottom">
            <!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{ URL::to('/trang-chu') }}" class="active">Trang chủ</a></li>
                                <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                                </li>
                                <li><a href="{{ URL::to('/gio-hang') }}">Giỏ hàng</a></li>
                                <li><a href="{{ URL::to('/lien-he') }}">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <form action="{{ request()->fullUrl() }}" method="get">
                            <div class="search_box pull-right">
                                <input type="text" name="keys" placeholder="Tìm kiếm sản phẩm" />
                                @foreach ($_GET as $name => $value)
                                    @if ($name != 'keys')
                                        <input type="hidden" name="{{ $name }}"
                                            value="{{ $value }}">
                                    @endif
                                @endforeach
                                <button type="submit" style="margin-top:0;color:#666" class="btn btn-primary"
                                    value="Tìm kiếm">Tìm kiếm</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-bottom-->
    </header>
    <!--/header-->
    @yield('silder')

    <section id="main">
        <div class="container">
            <div class="row">

                @if (request()->is('trang-chu') || request()->is('/'))
                    <div class="col-sm-3">
                        @yield('filter')
                    </div>
                    <div class="col-sm-9 padding-right maintain">
                        @yield('content')
                    </div>
                @else
                    <div class="col-sm-12">
                        @yield('content')
                    </div>
                @endif
            </div>
        </div>
    </section>

    <footer id="footer">
        <!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2><span>e</span>-shopper</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit,sed do eiusmod tempor</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{ '/frontend/images/iframe1.png' }}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{ '/frontend/images/iframe2.png' }}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{ '/frontend/images/iframe3.png' }}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="iframe-img">
                                        <img src="{{ '/frontend/images/iframe4.png' }}" alt="" />
                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                                <p>Circle of Hands</p>
                                <h2>24 DEC 2014</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="images/home/map.png" alt="" />
                            <p>505 S Atlantic Ave Virginia Beach, VA(Virginia)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Service</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Online Help</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Order Status</a></li>
                                <li><a href="#">Change Location</a></li>
                                <li><a href="#">FAQ’s</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Quock Shop</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">T-Shirt</a></li>
                                <li><a href="#">Mens</a></li>
                                <li><a href="#">Womens</a></li>
                                <li><a href="#">Gift Cards</a></li>
                                <li><a href="#">Shoes</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>Policies</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Terms of Use</a></li>
                                <li><a href="#">Privecy Policy</a></li>
                                <li><a href="#">Refund Policy</a></li>
                                <li><a href="#">Billing System</a></li>
                                <li><a href="#">Ticket System</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Company Information</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Store Location</a></li>
                                <li><a href="#">Affillate Program</a></li>
                                <li><a href="#">Copyright</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2>About Shopper</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Your email address" />
                                <button type="submit" class="btn btn-default"><i
                                        class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Get the most recent updates from <br />our site and be updated your self...</p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
                    <p class="pull-right">Designed by <span><a target="_blank"
                                href="http://www.themeum.com">Themeum</a></span></p>
                </div>
            </div>
        </div>

    </footer>
    <!--/Footer-->

    <script src="{{ asset('/frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js" type="text/javascript"></script>
    <script src="{{ asset('/frontend/js/main.js') }}"></script>
    <script src="{{ asset('/frontend/js/sweetalert.min.js') }}"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
    <script>
        paypal.Buttons().render('body');
    </script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v6.0&appId=2339123679735877&autoLogAppEvents=1">
    </script>
    @stack('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $('.add-to-cart').click(function() {

                var id = $(this).data('id_product');
                // alert(id);
                var cart_product_id = $('.cart_product_id_' + id).val();
                var cart_product_name = $('.cart_product_name_' + id).val();
                var cart_product_image = $('.cart_product_image_' + id).val();
                var cart_product_quantity = $('.cart_product_quantity_' + id).val();
                var cart_product_price = $('.cart_product_price_' + id).val();
                var cart_product_qty = $('.cart_product_qty_' + id).val();
                var _token = $('input[name="_token"]').val();
                if (parseInt(cart_product_qty) > parseInt(cart_product_quantity)) {
                    alert('Vui lòng đặt nhỏ hơn ' + cart_product_quantity);
                } else {

                    $.ajax({
                        url: '{{ url('/add-cart-ajax') }}',
                        method: 'POST',
                        data: {
                            cart_product_id: cart_product_id,
                            cart_product_name: cart_product_name,
                            cart_product_image: cart_product_image,
                            cart_product_price: cart_product_price,
                            cart_product_qty: cart_product_qty,
                            _token: _token,
                            cart_product_quantity: cart_product_quantity
                        },
                        success: function() {

                            swal({
                                    title: "Đã thêm sản phẩm vào giỏ hàng",
                                    text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                    showCancelButton: true,
                                    cancelButtonText: "Xem tiếp",
                                    confirmButtonClass: "btn-success",
                                    confirmButtonText: "Đi đến giỏ hàng",
                                    closeOnConfirm: false
                                },
                                function() {
                                    window.location.href = "{{ url('/gio-hang') }}";
                                });

                        }

                    });
                }


            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.choose').on('change', function() {
                var action = $(this).attr('id');
                var ma_id = $(this).val();
                var _token = $('input[name="_token"]').val();
                var result = '';

                if (action == 'city') {
                    result = 'province';
                } else {
                    result = 'wards';
                }
                $.ajax({
                    url: '{{ url('/select-delivery-home') }}',
                    method: 'POST',
                    data: {
                        action: action,
                        ma_id: ma_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#' + result).html(data);
                    }
                });
            });
        });
    </script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=ATKLqw46wO2_Uy6cCsKETH5WuEeYuOPDV9d1buvC6j8A1PZ2xF_3h-Q7aFthODF45fHddULJM-Uhrn3l&currency=USD">
    </script>
    <script>
        var usd = document.getElementById("vnd").value
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'vertical',
                label: 'paypal',

            },
            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: `${usd}` // Can also reference a variable or function
                        }
                    }]
                });
            },

            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    if (transaction.status == 'COMPLETED') {
                        var shipping_email = $(".shipping_email").val();
                        var shipping_name = $(".shipping_name").val();
                        var shipping_address = $(".shipping_address").val();
                        var shipping_phone = $(".shipping_phone").val();
                        var shipping_notes = $(".shipping_notes").val();
                        var shipping_method = $(".payment_select").val();
                        var order_fee = $(".order_fee").val();
                        var order_coupon = $(".order_coupon").val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "/confirm-order",
                            method: "POST",
                            data: {
                                shipping_email: shipping_email,
                                shipping_name: shipping_name,
                                shipping_address: shipping_address,
                                shipping_phone: shipping_phone,
                                shipping_notes: shipping_notes,
                                _token: _token,
                                order_fee: order_fee,
                                order_coupon: order_coupon,
                                shipping_method: shipping_method
                            },
                            success: function() {
                                swal(
                                    "Đơn hàng",
                                    "Đơn hàng của bạn đã được gửi thành công",
                                    "success"
                                );
                                window.setTimeout(function() {
                                    location.reload();
                                }, 1500);
                            },
                            error: function($err) {
                                swal(
                                    "Đơn hàng",
                                    "Đặt hàng không thành công!",
                                    "error"
                                );
                            }
                        });
                    } else {
                        swal({
                            title: "Oops...",
                            text: "Đặt hàng không thành công, hãy kiểm tra lại!",
                        }, )
                    }
                });
            }
        }).render('#paypal-button-container');
    </script>
    <script>
        $(document).ready(function() {
            $('#payment').on('change', function() {
                if ($(this).val() == 2) {
                    $('#ttpaypal').css('display', 'block')
                } else {
                    $('#ttpaypal').css('display', 'none')
                }
            })
        })
    </script>
</body>

</html>
