@extends('layout')
@section('silder')
    @if (count($slider) > 0)
        <section id="slider">
            <!--slider-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div id="slider-carousel" style="padding: 0 30px" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($slider as $key => $slide)
                                    <li data-target="#slider-carousel" data-slide-to={{ $key }}
                                        class={{ $key == 0 ? 'active' : '' }}>
                                    </li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($slider as $key => $slide)
                                    @php
                                        $i++;
                                    @endphp
                                    <div class="item {{ $i == 1 ? 'active' : '' }}">
                                        <img alt="{{ $slide->slider_desc }}"
                                            src="{{ asset('/uploads/slider/' . $slide->slider_image) }}" height="200"
                                            width="100%" class="img img-responsive img-slider">
                                    </div>
                                @endforeach
                            </div>
                            <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!--/slider-->
@endsection

@section('filter')
    @include('partial.filter', ['searchList'])
@endsection
@section('content')
    <div class="features_items">
        <!--features_items-->

        <h2 class="title text-center">Sản phẩm mới nhất</h2>

        @foreach ($all_product as $key => $product)
            <div class="col-sm-4">
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
                                <input type="hidden" value="1" class="cart_product_qty_{{ $product->product_id }}">


                                <img src="{{ URL::to('/uploads/product/' . $product->product_image) }}" alt="" />
                                <h2>{{ number_format($product->product_price, 0, ',', '.') . ' ' . 'VNĐ' }}</h2>
                                <p>{{ $product->product_name }}</p>
                                <div class="product-overlay">
                                    <div class="overlay-content">
                                        <h2>{{ number_format($product->product_price, 0, ',', '.') . ' ' . 'VNĐ' }}</h2>
                                        <div class="product-detail">
                                            <a class=""
                                                href="{{ URL::to('/chi-tiet/' . $product->product_id) }}">{{ $product->product_name }}</a>
                                        </div>
                                        <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart"
                                            data-id_product="{{ $product->product_id }}" name="add-to-cart">
                                    </div>
                                </div>
                                <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart"
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
    <!--features_items-->
    <ul class="pagination pagination-sm m-t-none m-b-none">
        {!! $all_product->appends(request()->except('page'))->links() !!}
    </ul>
    <!--/recommended_items-->
@endsection
