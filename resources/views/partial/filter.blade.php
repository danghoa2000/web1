<div class="left-sidebar">
    <?php
        unset($_GET['page']);
    ?>
    @if (count($_GET) > 0)
        <h2>BỘ LỌC TÌM KIẾM</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->
            <div class="search-list">
                <ul class="nav nav-pills nav-stacked">
                    @foreach ($searchList as $value)
                        <li> {{ $value['name'] }}
                            <a href="{{ request()->fullUrlWithQuery([$value['type'] => null]) }}">x</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <h2>Danh mục sản phẩm</h2>
    <div class="panel-group category-products" id="accordian">
        <!--category-productsr-->
        @foreach ($category as $key => $cate)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a
                            href="{{ request()->fullUrlWithQuery(['danh_muc' => $cate->category_id]) }}">{{ $cate->category_name }}</a>
                    </h4>
                </div>
            </div>
        @endforeach
    </div>
    <!--/category-products-->

    <div class="brands_products">
        <!--brands_products-->
        <h2>Thương hiệu sản phẩm</h2>
        <div class="panel-group category-products" id="accordian">
            <!--category-productsr-->
            @foreach ($brand as $key => $brand)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a
                                href="{{ request()->fullUrlWithQuery(['thuong_hieu' => $brand->brand_id]) }}">{{ $brand->brand_name }}</a>
                        </h4>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <!--/brands_products-->
</div>
