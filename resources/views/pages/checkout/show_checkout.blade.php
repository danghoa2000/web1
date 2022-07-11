@extends('layout')
@section('content')

    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div>
            <div class="shopper-informations">
                <div class="row">

                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p>Tính phí vận chuyển</p>
                            <div class="form-one">
                                <form style="border: 1px solid; padding:5px; margin-right:50px; width:330px">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn thành phố</label>
                                        <select name="city" id="city"
                                            class="form-control input-sm m-bot15 choose city">

                                            <option value="">--Chọn tỉnh thành phố--</option>
                                            @foreach ($city as $key => $ci)
                                                <option value="{{ $ci->matp }}">{{ $ci->name_city }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn quận huyện</label>
                                        <select name="province" id="province"
                                            class="form-control input-sm m-bot15 province choose">
                                            <option value="">--Chọn quận huyện--</option>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Chọn xã phường</label>
                                        <select name="wards" id="wards" class="form-control input-sm m-bot15 wards">
                                            <option value="">--Chọn xã phường--</option>
                                        </select>
                                    </div>
                                    <input type="button" value="Tính phí vận chuyển" name="calculate_order"
                                        class="btn btn-primary btn-sm calculate_delivery">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9 clearfix">
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {!! session()->get('message') !!}
                            </div>
                        @elseif(session()->has('error'))
                            <div class="alert alert-danger">
                                {!! session()->get('error') !!}
                            </div>
                        @endif
                        <div class="table-responsive cart_info">

                            <form action="{{ url('/update-cart') }}" method="POST">
                                @csrf
                                <table class="table table-condensed">
                                    <thead>
                                        <tr class="cart_menu">
                                            <td class="image" style="width:100px">Hình ảnh</td>
                                            <td class="description" style="width:200px">Tên sản phẩm</td>
                                            <td class="price" style="width:120px">Giá sản phẩm</td>
                                            <td class="quantity" style="width:75px">Số lượng</td>
                                            <td class="total">Thành tiền</td>
                                            <td></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (Session::get('cart') == true)
                                            @php
                                                $total = 0;
                                            @endphp
                                            @foreach (Session::get('cart') as $key => $cart)
                                                @php
                                                    $subtotal = $cart['product_price'] * $cart['product_qty'];
                                                    $total += $subtotal;
                                                @endphp

                                                <tr>
                                                    <td class="cart_product">
                                                        <img src="{{ asset('/uploads/product/' . $cart['product_image']) }}"
                                                            width="90" alt="{{ $cart['product_name'] }}" />
                                                    </td>
                                                    <td class="cart_description">
                                                        <h4><a href=""></a></h4>
                                                        <p>{{ $cart['product_name'] }}</p>
                                                    </td>
                                                    <td class="cart_price">
                                                        <p>{{ number_format($cart['product_price'], 0, ',', '.') }}đ</p>
                                                    </td>
                                                    <td class="cart_quantity">
                                                        <div class="cart_quantity_button">


                                                            <input style="width:50px" class="cart_quantity" type="number"
                                                                min="1" name="cart_qty[{{ $cart['session_id'] }}]"
                                                                value="{{ $cart['product_qty'] }}">


                                                        </div>
                                                    </td>
                                                    <td class="cart_total">
                                                        <p class="cart_total_price">
                                                            {{ number_format($subtotal, 0, ',', '.') }}đ

                                                        </p>
                                                    </td>
                                                    <td class="cart_delete">
                                                        <a class="cart_quantity_delete"
                                                            href="{{ url('/del-product/' . $cart['session_id']) }}"><i
                                                                class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty"
                                                        class="check_out btn btn-default btn-sm"></td>
                                                <td><a class="btn btn-default check_out"
                                                        href="{{ url('/del-all-product') }}">Xóa tất cả</a></td>
                                                <td>
                                                    @if (Session::get('coupon'))
                                                        <a class="btn btn-default check_out"
                                                            href="{{ url('/unset-coupon') }}">Xóa mã khuyến mãi</a>
                                                    @endif
                                                </td>


                                                <td colspan="2">
                                                    <li>Tổng tiền :<span>{{ number_format($total, 0, ',', '.') }}đ</span>
                                                    </li>
                                                    @if (Session::get('coupon'))
                                                        <li>

                                                            @foreach (Session::get('coupon') as $key => $cou)
                                                                @if ($cou['coupon_condition'] == 1)
                                                                    Mã giảm : {{ $cou['coupon_number'] }} %
                                                                    <p>
                                                                        @php
                                                                            $total_coupon = ($total * $cou['coupon_number']) / 100;
                                                                            
                                                                        @endphp
                                                                    </p>
                                                                    <p>
                                                                        @php
                                                                            $total_after_coupon = $total - $total_coupon;
                                                                        @endphp
                                                                    </p>
                                                                @elseif($cou['coupon_condition'] == 2)
                                                                    Mã giảm :
                                                                    {{ number_format($cou['coupon_number'], 0, ',', '.') }}
                                                                    k
                                                                    <p>
                                                                        @php
                                                                            $total_coupon = $total - $cou['coupon_number'];
                                                                            
                                                                        @endphp
                                                                    </p>
                                                                    @php
                                                                        $total_after_coupon = $total_coupon;
                                                                    @endphp
                                                                @endif
                                                            @endforeach



                                                        </li>
                                                    @endif

                                                    @if (Session::get('fee'))
                                                        <li>
                                                            <a class="cart_quantity_delete"
                                                                href="{{ url('/del-fee') }}"><i
                                                                    class="fa fa-times"></i></a>

                                                            Phí vận chuyển
                                                            <span>{{ number_format(Session::get('fee'), 0, ',', '.') }}đ</span>
                                                        </li>
                                                        <?php $total_after_fee = $total + Session::get('fee'); ?>
                                                    @endif
                                                    <li>Tổng thanh toán:
                                                        @php
                                                            if (Session::get('fee') && !Session::get('coupon')) {
                                                                $total_after = $total_after_fee;
                                                                echo number_format($total_after, 0, ',', '.') . 'đ';
                                                            } elseif (!Session::get('fee') && Session::get('coupon')) {
                                                                $total_after = $total_after_coupon;
                                                                echo number_format($total_after, 0, ',', '.') . 'đ';
                                                            } elseif (Session::get('fee') && Session::get('coupon')) {
                                                                $total_after = $total_after_coupon;
                                                                $total_after = $total_after + Session::get('fee');
                                                                echo number_format($total_after, 0, ',', '.') . 'đ';
                                                            } elseif (!Session::get('fee') && !Session::get('coupon')) {
                                                                $total_after = $total;
                                                                echo number_format($total_after, 0, ',', '.') . 'đ';
                                                            }
                                                            
                                                        @endphp
                                                    </li>

                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5">
                                                    <center>
                                                        @php
                                                            echo 'Chưa có sản phẩm trong giỏ hàng<br> vui lòng thêm sản phẩm';
                                                        @endphp
                                                    </center>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                            </form>
                            @if (Session::get('cart'))
                                <tr>
                                    <td>

                                        <form method="POST" action="{{ url('/check-coupon') }}">
                                            @csrf
                                            <input type="text" class="form-control" name="coupon"
                                                placeholder="Nhập mã giảm giá"><br>
                                            <input type="submit" class="btn btn-default check_coupon" name="check_coupon"
                                                value="Tính mã giảm giá">

                                        </form>
                                    </td>
                                </tr>
                            @endif

                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <div class="bill-to">
                <p>Thông tin gửi hàng</p>
                <div class="form-one">
                    <form method="POST">
                        @csrf
                        <input type="text" name="shipping_email" class="shipping_email" placeholder="Điền email">
                        <input type="text" name="shipping_name" class="shipping_name"
                            placeholder="Họ và tên người gửi">
                        <input type="text" name="shipping_address" class="shipping_address"
                            placeholder="Địa chỉ gửi hàng">
                        <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại">
                        <textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>

                        @if (Session::get('fee'))
                            <input type="hidden" name="order_fee" class="order_fee"
                                value="{{ Session::get('fee') }}">
                        @else
                            <input type="hidden" name="order_fee" class="order_fee" value="10000">
                        @endif

                        @if (Session::get('coupon'))
                            @foreach (Session::get('coupon') as $key => $cou)
                                <input type="hidden" name="order_coupon" class="order_coupon"
                                    value="{{ $cou['coupon_code'] }}">
                            @endforeach
                        @else
                            <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                        @endif
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                                <select id="payment" name="payment_select" class="form-control input-sm m-bot15 payment_select">
                                    {{-- <option value="">Chọn phương thức thanh toán</option> --}}
									<option  value="0">Chuyển khoản</option>
                                    <option selected value="1">Tiền mặt</option>
                                    <option value="2">Paypal</option>
                                </select>
                            </div>
							<div style="display:none" id="ttpaypal" class="col-md-12">
								@php
									$vnd = $total_after / 23365;
								@endphp
								<div id="paypal-button-container"></div>
								<input type="hidden" id="vnd" value="{{ round($vnd, 2) }}">
							</div>
							
                        </div>
                        
                        <input type="button" value="Xác nhận đơn hàng" name="send_order"
                            class="btn btn-primary btn-sm send_order">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!--/#cart_items-->

@endsection


