@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển hàng
            </div>


            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>

                            <th>Tên người nhận</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Ghi chú</th>
                            <th>Hình thức thanh toán</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>

                            <td>{{ $shipping->shipping_name }}</td>
                            <td>{{ $shipping->shipping_address }}</td>
                            <td>{{ $shipping->shipping_phone }}</td>
                            <td>{{ $shipping->shipping_email }}</td>
                            <td>{{ $shipping->shipping_notes }}</td>
                            <td>
                                @if ($shipping->shipping_method == 0)
                                    Chuyển khoản
                                @elseif($shipping->shipping_method == 1)
                                    Tiền mặt
                                @else
                                    Paypal
                                @endif
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

        </div>
    </div>
    <br><br>

    <div class="table-agile-info">

        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>

            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>

                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Tên sản phẩm</th>
                            <th>Mã giảm giá</th>
                            <th>Số lượng</th>
                            <th>Giá sản phẩm</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($order_details as $key => $details)
                            @php
                                $i++;
                                $subtotal = $details->product_price * $details->product_sales_quantity;
                                $total += $subtotal;
                            @endphp
                            <tr class="color_qty_{{ $details->product_id }}">

                                <td><i>{{ $i }}</i></td>
                                <td>{{ $details->product_name }}</td>

                                <td>
                                    @if ($details->product_coupon != 'no')
                                        {{ $details->product_coupon }}
                                    @else
                                        Không mã
                                    @endif
                                </td>
                                <td>{{ $details->product_sales_quantity }}</td>
                                <td>{{ number_format($details->product_price, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="6">
                                @php
                                    $total_coupon = 0;
                                @endphp
                                @if ($coupon_condition == 1)
                                    @php
                                        $total_after_coupon = ($total * $coupon_number) / 100;
                                        echo 'Tổng giảm :' . number_format($total_after_coupon, 0, ',', '.') . '</br>';
                                        $total_coupon = $total + $details->product_feeship - $total_after_coupon;
                                    @endphp
                                @else
                                    @php
                                        echo 'Tổng giảm :' . number_format($coupon_number, 0, ',', '.') . '00Đ' . '</br>';
                                        $total_coupon = $total + $details->product_feeship - $coupon_number;
                                        
                                    @endphp
                                @endif

                                Phí ship : {{ number_format($details->product_feeship, 0, ',', '.') }}đ</br>
                                Thanh toán: {{ number_format($total_coupon, 0, ',', '.') }}đ
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                @foreach ($order as $key => $or)
                                    <form>
                                        @csrf
                                        <select class="form-control order_details">
                                            <option value="">----Chọn hình thức đơn hàng-----</option>
                                            <option id="{{ $or->order_id }}"
                                                {{ $or->order_status == 1 ? 'selected' : '' }} value="1">Chưa xử lý
                                            </option>
                                            <option id="{{ $or->order_id }}"
                                                {{ $or->order_status == 2 ? 'selected' : '' }} value="2">Đã xử lý-Đã
                                                giao hàng
                                            </option>
                                            <option id="{{ $or->order_id }}"
                                                {{ $or->order_status == 3 ? 'selected' : '' }} value="3">Hủy đơn
                                                hàng-tạm giữ
                                            </option>
                                        </select>
                                    </form>
                                @endforeach

                            </td>
                        </tr>
                    </tbody>
                </table>
                <a target="_blank" href="{{ url('/print-order/' . $details->order_code) }}">In đơn hàng</a>
            </div>

        </div>
    </div>
@endsection
