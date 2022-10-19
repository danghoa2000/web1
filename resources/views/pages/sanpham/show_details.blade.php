@extends('layout')
@section('content')
    <div class="product-details">
        <!--product-details-->
        <div class="col-sm-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel">
                <div class="product-slide-thumnail">
                    {{-- <ol class="carousel-indicators carousel-indicators-product">
                        @foreach ($slider as $key => $slide)
                            <li data-target="#product-carousel" data-slide-to={{ $key }}
                                class={{ $key == 0 ? 'active' : '' }}>
                                <img alt=""
                                    src="{{ asset('/uploads/product/' . $product_details->product_image) }}"
                                    class="img img-responsive img-slider">
                            </li>
                        @endforeach
                    </ol> --}}
                </div>

                <div class="carousel-inner">
                    @php
                        $i = 0;
                    @endphp
                    @foreach ($slider as $key => $slide)
                        <div class="item {{ $i == 0 ? 'active' : '' }}">
                            <div class="col-sm-12">
                                <img alt=""
                                    src="{{ asset('/uploads/product/' . $product_details->product_image) }}"
                                    class="img img-responsive img-slider">
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                </div>

                <a href="#product-carousel" class="left control-carousel control-carousel-product hidden-xs"
                    data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a href="#product-carousel" class="right control-carousel control-carousel-product hidden-xs"
                    data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="product-information">
                <!--/product-information-->
                <img src="/images/product-details/new.jpg" class="newarrival" alt="" />
                <h2>{{ $product_details->product_name }}</h2>
                <p>Mã ID: {{ $product_details->product_id }}</p>
                <img src="/images/product-details/rating.png" alt="" />

                <form action="{{ URL::to('/save-cart') }}" method="POST">
                    @csrf
                    <input type="hidden" value="{{ $product_details->product_id }}"
                        class="cart_product_id_{{ $product_details->product_id }}">

                    <input type="hidden" value="{{ $product_details->product_name }}"
                        class="cart_product_name_{{ $product_details->product_id }}">

                    <input type="hidden" value="{{ $product_details->product_image }}"
                        class="cart_product_image_{{ $product_details->product_id }}">

                    <input type="hidden" value="{{ $product_details->product_quantity }}"
                        class="cart_product_quantity_{{ $product_details->product_id }}">

                    <input type="hidden" value="{{ $product_details->product_price }}"
                        class="cart_product_price_{{ $product_details->product_id }}">

                    <span>
                        <span>{{ number_format($product_details->product_price, 0, ',', '.') . 'VNĐ' }}</span>

                        <label>Số lượng:</label>
                        <input name="qty" type="number" min="1"
                            class="cart_product_qty_{{ $product_details->product_id }}" value="1" />
                        <input name="productid_hidden" type="hidden" value="{{ $product_details->product_id }}" />
                    </span>
                    <input type="button" value="Thêm giỏ hàng" class="btn btn-primary btn-sm add-to-cart"
                        data-id_product="{{ $product_details->product_id }}" name="add-to-cart">
                </form>

                <p><b>Tình trạng:</b> Còn hàng</p>
                <p><b>Điều kiện:</b> Mơi 100%</p>
                <p><b>Số lượng kho còn:</b> {{ $product_details->product_quantity }}</p>
                <p><b>Thương hiệu:</b> {{ $product_details->brand_name }}</p>
                <p><b>Danh mục:</b> {{ $product_details->category_name }}</p>
                <a href="">
                    <img src="/images/product-details/share.png" class="share img-responsive" alt="" />
                </a>
            </div>
            <!--/product-information-->
        </div>
    </div>
    <!--/product-details-->

    <div class="category-tab shop-details-tab">
        <!--category-tab-->
        <div class="col-sm-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Mô tả</a></li>
                <li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
                <li><a href="#reviews" data-toggle="tab">Đánh giá</a></li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active in" id="details">
                <p>{!! $product_details->product_desc !!}</p>
            </div>
            <div class="tab-pane fade" id="companyprofile">
                <p>{!! $product_details->product_content !!}</p>
            </div>
            <div class="tab-pane fade" id="reviews">
                <div class="col-sm-12">
                    <ul>
                        <li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
                        <li><a href=""><i class="fa fa-clock-o"></i>12:41 PM</a></li>
                        <li><a href=""><i class="fa fa-calendar-o"></i>31 DEC 2014</a></li>
                    </ul>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
                        nisi ut aliquip ex ea commodo consequat.Duis aute irure dolor in reprehenderit in voluptate
                        velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    <p><b>Write Your Review</b></p>

                    <form action="#">
                        <span>
                            <input type="text" placeholder="Your Name" />
                            <input type="email" placeholder="Email Address" />
                        </span>
                        <textarea name=""></textarea>
                        <b>Rating: </b> <img src="/images/product-details/rating.png" alt="" />
                        <button type="button" class="btn btn-default pull-right">
                            Submit
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!--/category-tab-->
    <div class="recommended_items">
        <!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan</h2>
        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="item active">
                    @foreach ($relate as $key => $product)
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <form>
                                            @csrf
                                            <input type="hidden" value="{{ $product->product_id }}"
                                                class="cart_product_id_{{ $product->product_id }}">
                                            <input type="hidden" value="{{ $product->product_name }}"
                                                class="cart_product_name_{{ $product->product_id }}">

                                            <input type="hidden" value="{{ $product->product_quantity }}"
                                                class="cart_product_quantity_{{ $product->product_id }}">

                                            <input type="hidden" value="{{ $product->product_image }}"
                                                class="cart_product_image_{{ $product->product_id }}">
                                            <input type="hidden" value="{{ $product->product_price }}"
                                                class="cart_product_price_{{ $product->product_id }}">
                                            <input type="hidden" value="1"
                                                class="cart_product_qty_{{ $product->product_id }}">


                                            <img src="{{ URL::to('/uploads/product/' . $product->product_image) }}"
                                                alt="" />
                                            <h2>{{ number_format($product->product_price, 0, ',', '.') . ' ' . 'VNĐ' }}
                                            </h2>
                                            <p>{{ $product->product_name }}</p>
                                            <div class="product-overlay">
                                                <div class="overlay-content">
                                                    <h2>{{ number_format($product->product_price, 0, ',', '.') . ' ' . 'VNĐ' }}
                                                    </h2>
                                                    <div class="product-detail">
                                                        <a class=""
                                                            href="{{ URL::to('/chi-tiet/' . $product->product_id) }}">{{ $product->product_name }}</a>
                                                    </div>
                                                    <input type="button" value="Thêm giỏ hàng"
                                                        class="btn btn-default add-to-cart"
                                                        data-id_product="{{ $product->product_id }}" name="add-to-cart">
                                                </div>
                                            </div>
                                            <input type="button" value="Thêm giỏ hàng"
                                                class="btn btn-default add-to-cart"
                                                data-id_product="{{ $product->product_id }}" name="add-to-cart">
                                        </form>

                                    </div>

                                </div>

                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
