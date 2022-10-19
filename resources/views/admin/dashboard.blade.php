@extends('admin_layout')
@section('admin_content')
    <div class="sales__statistics">
        <h2 style="margin: 30px 0">Thống kê đơn hàng</h2>
        <form action="">
            @csrf
            <div class="row">
                <div class="col-xs-4">
                    <div class="card card-calendar">
                        <h4>Từ</h4>
                        <input type="month" name="start_month" id="startMonth" value="{{ Carbon\Carbon::now()->format('Y-01') }}">
                    </div>
                </div>

                <div class="col-xs-4">
                    <div class="card card-calendar">
                        <h4>Đến</h4>
                        <input type="month" name="end_month" id="endMonth" value="{{ Carbon\Carbon::now()->format('Y-12') }}">
                    </div>
                </div>
            </div>

            <input type="button" id="filterSatistic" class="btn btn-danger btn-lg" style="margin: 20px 0"
                value="Lọc Kết Quả">
        </form>
        <div class="card" style="height: 500px">
            <canvas id="myChart" style="max-height: 100%"></canvas>
        </div>
    </div>

    <div class="sales__statistics">
        <h2 style="margin: 30px 0">Thống kê sản phẩm</h2>
        <h3>Top sản phẩm bán chạy</h3>
        <ul>
            @foreach ($topProducts as $item)
                <li>{{ $item->product_name }} <span style="color: #dfb235; font-size: 14px"> (Đã bán {{ App\number_format_short($item->total) }}) </span></li>
            @endforeach
        </ul>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js">
    </script>
    <script src="{{ asset('/backend/js/chart.js') }}"></script>
@endsection
