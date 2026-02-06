@extends('Layouts.app')

@section('style')
<style>
    .sale-widget .card-body {
        padding: 20px;
        color: #fff;
    }

    .sale-widget {
        border-radius: 12px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .sale-widget:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .sale-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.9);
    }

    .bg-primary { background-color: #4A90E2 !important; }
    .bg-secondary { background-color: #50E3C2 !important; }
    .bg-teal { background-color: #F5A623 !important; }
    .bg-info { background-color: #c57ed3 !important; }

    .tile {
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        background-color: #ffffff;
        margin-bottom: 20px;
        height: 100%;
    }

    .tile-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    /* #monthlySalesChart,
    #topSalesChart,
    #sales_chartnew,
    #weekSalesChart {
        width: 100% !important;
        height: 350px !important;
    } */
</style>
<link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap5.min.css') }}">
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
    <div class="mb-3">
        <h1 class="mb-1 text-dark">Business Overview</h1>
    </div>
    <div class="input-icon-start position-relative mb-3">
        <span class="input-icon-addon fs-16 text-gray-9">
            <i class="ti ti-calendar"></i>
        </span>
        <input type="text" class="form-control date-range bookingrange" placeholder="Filter by Date Range">
    </div>
</div>
<!-- @if($outOfStockCount > 0)
@foreach($outOfStockProducts as $stock)
    <div class="alert alert-danger d-flex justify-content-between align-items-center">
        <span>
            <strong>{{ $stock->product->name }}</strong> products are out of stock!
        </span>

        <a href="{{route('stock.edit', $stock->id)}}" class="btn btn-primary  btn-sm">
            View or Edit Out of Stock Products
        </a>
    </div>
@endforeach
@endif -->



<!-- <div class="row g-3 mb-4">
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <a href="{{ route('product') }}" class="card bg-primary sale-widget flex-fill">
            <div class="card-body d-flex align-items-center">
                <span class="sale-icon text-primary">
                    <i class="ti ti-cube fs-24"></i>
                </span>
                <div class="ms-3">
                    <p class="text-uppercase mb-0" style="opacity: 0.8;">Total Products</p>
                    <h2 class="mb-0 text-white"><b>{{ $totalProducts }}</b></h2>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <a href="{{ route('stock') }}" class="card bg-secondary sale-widget flex-fill text-decoration-none">
            <div class="card-body d-flex align-items-center">
                <span class="sale-icon text-secondary">
                    <i class="ti ti-shopping-cart fs-24"></i>
                </span>
                <div class="ms-3">
                    <p class="text-uppercase mb-0" style="opacity: 0.8;">Total Sales</p>
                    <h2 class="mb-0 text-white"><b>{{ $totalSales }}</b></h2>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card bg-teal sale-widget flex-fill">
            <div class="card-body d-flex align-items-center">
                <span class="sale-icon text-teal">
                    <i class="ti ti-truck fs-24"></i>
                </span>
                <div class="ms-3">
                    <p class="text-uppercase mb-0" style="opacity: 0.8;">Total Suppliers</p>
                    <h2 class="mb-0 text-white"><b>{{ $totalSuppliers }}</b></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <a href="{{ route('invoice.index') }}" class="card bg-info sale-widget flex-fill">
            <div class="card-body d-flex align-items-center">
                <span class="sale-icon text-info">
                    <i class="ti ti-file fs-24"></i>
                </span>
                <div class="ms-3">
                    <p class="text-uppercase mb-0" style="opacity: 0.8;">Total Invoices</p>
                    <h2 class="mb-0 text-white"><b>{{ $totalInvoices }}</b></h2>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-6 col-12 d-flex">
        <div class="tile flex-fill">
            <h5 class="tile-title mb-0">Monthly Sales</h5>
            <div id="monthlySalesChart"></div>
        </div>
    </div>
    <div class="col-xl-6 col-12 d-flex">
        <div class="tile flex-fill">
            <h5 class="tile-title mb-0">Top 5 Sales Products</h5>
            <div id="topSalesChart"></div>
        </div>
    </div>
    <div class="col-xl-6 col-12 d-flex">
        <div class="tile flex-fill">
            <h5 class="tile-title mb-0">Today's vs Yesterday's Sales</h5>
            <div id="sales_chartnew"></div>
        </div>
    </div>
    <div class="col-xl-6 col-12 d-flex">
        <div class="tile flex-fill">
            <h5 class="tile-title mb-0">This Week vs Last Week</h5>
            <div id="weekSalesChart"></div>
        </div>
    </div>
</div> -->
@endsection

<!-- Load Google Charts Once -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<!-- <script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });

    google.charts.setOnLoadCallback(function () {
        drawMonthlySalesChart();
        drawTopSalesChart();
        drawTodayYesterdayChart();
        drawWeekComparisonChart();
    });

    // 1. Monthly Sales Line Chart
    function drawMonthlySalesChart() {
        const salesData = @json($monthlySales);

        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Total Sales');
        salesData.forEach(sale => {
            data.addRow([sale.month, parseFloat(sale.total_amount)]);
        });

        const options = {
            curveType: 'function',
            legend: { position: 'bottom' },
            backgroundColor: 'transparent',
            hAxis: { textStyle: { color: '#212529' } },
            vAxis: { 
                title: 'Sales ($)',
                gridlines: { color: '#e0e0e0' },
                textStyle: { color: '#212529' }
            },
            series: { 0: { color: '#28a745' } },
            chartArea: { width: '85%', height: '75%' }
        };

        const chart = new google.visualization.LineChart(document.getElementById('monthlySalesChart'));
        chart.draw(data, options);
    }

    // 2. Top 5 Products - Donut Chart
    function drawTopSalesChart() {
        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Product Name');
        data.addColumn('number', 'Total Sales');
        data.addRows([
            @foreach($formattedTopSales as $sale)
                ['{{ $sale['productName'] }}', {{ $sale['totalSales'] }}],
            @endforeach
        ]);

        const options = {
            pieHole: 0.45,
            colors: ['#4A90E2', '#50E3C2', '#F5A623', '#c57ed3', '#FF6B6B'],
            legend: { position: 'right', alignment: 'center' },
            chartArea: { width: '90%', height: '80%' }
        };

        const chart = new google.visualization.PieChart(document.getElementById('topSalesChart'));
        chart.draw(data, options);
    }

    // 3. Today vs Yesterday - Column Chart
  function drawTodayYesterdayChart() {
    const data = google.visualization.arrayToDataTable([
        ['Day', 'Sales Amount', { role: 'style' }],
        ['Yesterday', {{ $yesterdaySales ?? 0 }}, '#95a5a6'],
        ['Today',     {{ $todaySales ?? 0 }},     '#4A90E2']
    ]);

    const options = {
        title: 'Today vs Yesterday Sales',
        titleTextStyle: { fontSize: 16, bold: true, color: '#333' },
        legend: { position: 'none' },
        chartArea: { width: '75%', height: '75%' },
        vAxis: { title: 'Sales ($)', minValue: 0 },
        bar: { groupWidth: '60%' }
    };

    const chart = new google.visualization.ColumnChart(document.getElementById('sales_chartnew'));
    chart.draw(data, options);
}
    // 4. This Week vs Last Week - Horizontal Bar
    function drawWeekComparisonChart() {
        const data = google.visualization.arrayToDataTable([
            ['Week', 'Sales Amount', { role: 'style' }],
            ['Last Week', {{ $lastWeekSales ?? 0 }}, '#e74c3c'],
            ['This Week', {{ $thisWeekSales ?? 0 }}, '#27ae60']
        ]);

        const options = {
            chartArea: { width: '60%' },
            hAxis: { title: 'Sales Amount ($)', minValue: 0 },
            vAxis: { title: 'Week' },
            legend: { position: 'none' }
        };

        const chart = new google.visualization.BarChart(document.getElementById('weekSalesChart'));
        chart.draw(data, options);
    }

  let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        drawMonthlySalesChart();
        drawTopSalesChart();
        drawTodayYesterdayChart();
        drawWeekComparisonChart();
    }, 300);
});
</script> -->