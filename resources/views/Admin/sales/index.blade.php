@extends('Layouts.app')
@section('style')
<link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap5.min.css')}}">
@endsection
@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">sales</h4>
            <h6>Manage your sales</h6>
        </div>
    </div>
   
</div>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3 bg-primary">
        <div>
            <h4 class="text-light">sales List</h4>
        </div>
    </div>


     <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table " id="sale_table">
                    <thead class="thead-light">
                        <tr>
                        <th>Id </th>
                        <th>Product </th>
                        <th>Qty </th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Date </th>
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

        var saleTable = $('#sale_table').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            info : false,
            ajax : "{{route('sale.get_sale')}}",
            order : [[ 0, "desc" ]],
            fixedHeader: true,
            processing : true,
            responsive : true,
            serverSide : true,
            pageLength : 10,
            lengthChange : true,
            serverMethod:'post',
            columns: [
                { data: 'id', name: 'id',orderable: false,searchable: true},          
                { data: 'name', name: 'name',orderable: false,searchable: true},
                { data: 'qty', name: 'qty',orderable: false,searchable: true},
                { data: 'price', name: 'price',orderable: false,searchable: true},
                { data: 'total', name: 'total',orderable: false,searchable: true},
                { data: 'date', name: 'date',orderable: false,searchable: true},
              
            ],
            drawCallback: function() {
              feather.replace(); 
            }
        });
    </script>
@endsection
