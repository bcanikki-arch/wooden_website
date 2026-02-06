@extends('Layouts.app')
@section('style')
    <style>
        .card {
            background-color: #e79696;
        }
    </style>
     <link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap5.min.css')}}">
@endsection
@section('content')
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-2">
        <div class="mb-3">
            <h1 class="mb-1">Welcome, {{ ucwords(Auth::user()->name ?? Admin) }}</h1>
            <p class="fw-medium">You have <span class="text-primary fw-bold">200+</span>
                Orders, Today</p>
        </div>
        <div class="input-icon-start position-relative mb-3">
            <span class="input-icon-addon fs-16 text-gray-9">
                <i class="ti ti-calendar"></i>
            </span>
            <input type="text" class="form-control date-range bookingrange" placeholder="Search Product">
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-primary sale-widget flex-fill">
                <div class="card-body d-flex align-items-center">
                    <span class="sale-icon bg-white text-primary">
                        <i class="ti ti-file-text fs-24"></i>
                    </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Total Sales</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white"> {{ number_format($sales->total_sales_amount, 2) }}</h4>
                            <span class="badge badge-soft-primary"><i class="ti ti-arrow-up me-1"></i>+22%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-secondary sale-widget flex-fill">
                <a href="{{route('product')}}">
                <div class="card-body d-flex align-items-center">
                    <span class="sale-icon bg-white text-secondary">
                        <i class="ti ti-repeat fs-24"></i>
                    </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Total Stock</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white">{{$totalStock}}</h4>
                            {{-- <span class="badge badge-soft-danger"><i class="ti ti-arrow-down me-1"></i>-22%</span> --}}
                        </div>
                    </div>
                </div>
            </a>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-teal sale-widget flex-fill">
                <div class="card-body d-flex align-items-center">
                    <span class="sale-icon bg-white text-teal">
                        <i class="ti ti-gift fs-24"></i>
                    </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Total Purchase</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white">$24,145,789</h4>
                            <span class="badge badge-soft-success"><i class="ti ti-arrow-up me-1"></i>+22%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12 d-flex">
            <div class="card bg-info sale-widget flex-fill">
                <div class="card-body d-flex align-items-center">
                    <span class="sale-icon bg-white text-info">
                        <i class="ti ti-brand-pocket fs-24"></i>
                    </span>
                    <div class="ms-2">
                        <p class="text-white mb-1">Total Purchase Return</p>
                        <div class="d-inline-flex align-items-center flex-wrap gap-2">
                            <h4 class="text-white">$18,458,747</h4>
                            <span class="badge badge-soft-success"><i class="ti ti-arrow-up me-1"></i>+22%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card bg-white">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3 bg-primary">
            <div>
                <h4 class="text-light">Product Stock List</h4>
            </div>           
        </div>
        <div class="mb-3 d-flex gap-2 p-4">
            <select id="stock_filter" name="stock_filter" class="form-select w-auto">
                <option value="">All Stock</option>
                <option value="out">Out of Stock</option>
                <option value="low">Low Stock</option>
                <option value="medium">Medium Stock</option>
                <option value="high">High Stock</option>
            </select>

            <select id="status_filter" name="status_filter"  class="form-select w-auto">
                <option value="">All Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table " id="stock_table">
                    <thead class="thead-light">
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Stock</th>
                            {{-- <th>Status</th> --}}
                            <th>Stock Status</th>
                            <th>Action</th>
                         </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
  <script src="{{ url('assets/plugins/sweetalert/sweetalert2.all.min.js')}}" ></script>
    <script src="{{ url('assets/plugins/sweetalert/sweetalerts.min.js')}}" ></script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    </script>
    <script>   

        var stockTable = $('#stock_table').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            info : false,
            ajax : "{{route('stockget')}}",
            order : [[ 0, "desc" ]],
            fixedHeader: true,
            processing : true,
            responsive : true,
            serverSide : true,
            pageLength : 10,
            lengthChange : true,
            serverMethod:'post',
            columns: [
                { data: 'id', name: 'id',orderable: true,searchable: true },          
                { data: 'image', name: 'image',orderable: false,searchable: true},
                { data: 'name', name: 'name',orderable: false,searchable: true},
                { data: 'stock', name: 'stock',orderable: false,searchable: true},
                { data: 'status',name: 'status', orderable: false, searchable: false },
                { data: 'stock_status',name: 'stock_status', orderable: true, searchable: true },
                { data: 'action',  name: 'action', orderable: false, searchable: false, className: "text-end" },
            ],
            
            drawCallback: function() {
              feather.replace(); 
            }
        });
        var stockTable = $('#stock_table').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            info : false,
            order : [[ 0, "desc" ]],
            processing : true,
            responsive : true,
            serverSide : true,
            pageLength : 10,
            lengthChange : true,
            serverMethod:'post',
            ajax : {
                url: "{{route('getstock')}}",
                data: function(d) {
                    d.stock_filter = $('#stock_filter').val(); 
                    d.status_filter = $('#status_filter').val(); 
                }
            },
            order : [[ 0, "desc" ]],
            columns: [
                { data: 'id', name: 'id', orderable: true, searchable: true },          
                { data: 'image', name: 'image', orderable: false, searchable: true },
                { data: 'name', name: 'name', orderable: false, searchable: true },
                { data: 'stock', name: 'stock', orderable: false, searchable: true },
                // { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'stock_status', name: 'stock_status', orderable: true, searchable: true },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: "text-end" },
            ],
            drawCallback: function() {
                feather.replace(); 
            }
        });
        $('#stock_filter').change(function() {
            stockTable.ajax.reload();
        });
          $('#status_filter').change(function() {
            stockTable.ajax.reload();
        });
    </script>
@endsection
