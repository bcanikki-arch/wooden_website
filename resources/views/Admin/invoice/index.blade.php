@extends('Layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap5.min.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Invoice</h4>
                <h6>Manage your invoices</h6>
            </div>
        </div> 		 
        <div class="page-btn">
            <a href="{{route('invoice.create')}}" class="btn btn-primary" >
                <i class="ti ti-circle-plus me-1"></i>Add Invoice
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3 bg-primary">
            <div>
                <h4 class="text-light">Invoice List</h4>
            </div> 		 
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table " id="invoice_table">
                    <thead class="thead-light">
                        <tr>
                            {{-- Changed 'Invoice ID' rendering to handle formatting via DataTables JS --}}
                            <th>Invoice ID </th> 
                            <th>Customer Name </th> {{-- Renamed for clarity, assuming 'name' is customer/invoice name --}}
                            <th>Date </th>
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

        var invoiceTable = $('#invoice_table').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            info : false,
            ajax : "{{route('invoice.get_invoice')}}",
            fixedHeader: true,
            processing : true,
            responsive : true,
            serverSide : true,
            pageLength : 10,
            lengthChange : true,
            serverMethod:'post',
            columns: [
                { 
                    data: 'id', 
                    name: 'id',
                    orderable: true,
                    searchable: true,
                    // Render function to display ID as 1000 + ID
                    render: function (data, type, row) {
                        return 1000 + data;
                    }
                }, 		 
                { data: 'name', name: 'name', orderable: false, searchable: true},
                { data: 'created_at', name: 'created_at', orderable: true, searchable: true}, // Changed to 'created_at'
                { data: 'action', 	name: 'action', orderable: false, searchable: false, className: "text-end" },
            ],
            drawCallback: function() {
                // Ensure feather icons are replaced if used
                if (typeof feather !== 'undefined') {
                    feather.replace(); 
                }
            }
        });

        // Delete confirmation logic
        $(document).on('click', '.remove-item-btn', function(e) {
            e.preventDefault(); // Prevent default action immediately
            var id = $(this).data('id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won’t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel", 
                customClass: {
                    confirmButton: "btn btn-primary", 
                    cancelButton: "btn btn-danger ml-1"
                },
                buttonsStyling: false 
            }).then((result) => {
                if (result.isConfirmed) {
                    // Use AJAX for deletion
                    $.ajax({
                        url: 'invoice/' + id,
                        type: 'POST', // Use POST for Laravel DELETE
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire('Deleted!', 'The invoice has been deleted.', 'success');
                            invoiceTable.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Could not delete the invoice.', 'error');
                        }
                    });
                }
            });
        });

        // The status toggle function is kept as is, but improved slightly for robustness.
        $(document).on('click', '.status-toggle-btn', function() {
            var button = $(this);
            var invoiceId = button.data('id');
            var currentStatus = button.data('current-status');
            var nextStatus = button.data('next-status');
            
            $.ajax({
                url: 'invoice/update-status/' + invoiceId, 
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: nextStatus 
                },
                beforeSend: function() {
                    button.text('Updating...').prop('disabled', true);
                },
                success: function(response) {
                    if (response.success) {
                        $('#invoice_table').DataTable().ajax.reload(null, false); 
                    } else { 
                        Swal.fire('Update Failed', 'Status update failed.', 'error');
                        button.prop('disabled', false).text(currentStatus == 1 ? 'Active' : 'Inactive');
                    }
                },
                error: function(xhr) {
                    Swal.fire('Error', 'An unexpected error occurred during status update.', 'error');
                    button.prop('disabled', false).text(currentStatus == 1 ? 'Active' : 'Inactive');
                }
            });
        });
    </script>
@endsection