@extends('Layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ url('assets/css/dataTables.bootstrap5.min.css')}}">
@endsection
@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">User</h4>
                <h6>Manage your categories</h6>
            </div>
        </div>       
        <div class="page-btn">
            <a href="#" class="btn btn-primary" >
                <i class="ti ti-circle-plus me-1"></i>Add User
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3 bg-primary">
            <div>
                <h4 class="text-light">User List</h4>
            </div>           
        </div>
        <div class="card-body p-3">
            <div class="table-responsive">
                <table class="table " id="user_table">
                    <thead class="thead-light">
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Role</th>
                            {{-- <th>Status</th> --}}
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

        var user = $('#user_table').DataTable({
            orderCellsTop: true,
            fixedHeader: true,
            info : false,
            ajax : "{{route('user.get_user')}}",
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
                { data: 'role', name: 'role',orderable: false,searchable: true},
                // { data: 'status',name: 'status', orderable: false, searchable: false },
                { data: 'action',  name: 'action', orderable: false, searchable: false, className: "text-end" },
            ],
            drawCallback: function() {
              feather.replace(); 
            }
        });

        // $(document).on('click', '.remove-item-btn', function() {
        //     var id = $(this).data('id');
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You won’t be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonText: "Yes, delete it!",
        //         cancelButtonText: "Cancel", 
        //         customClass: {
        //             confirmButton: "btn btn-primary", 
        //             cancelButton: "btn btn-danger ml-1"
        //         },
        //         buttonsStyling: false 
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             var form = $('<form>', {
        //                 method: 'POST',
        //                 action: 'user/' + id
        //             });

        //             form.append($('<input>', {
        //                 type: 'hidden',
        //                 name: '_token',
        //                 value: '{{ csrf_token() }}'
        //             }));
        //             form.append($('<input>', {
        //                 type: 'hidden',
        //                 name: '_method',
        //                 value: 'DELETE'
        //             }));
        //             form.appendTo('body').submit();
        //         }
        //     });
        // });

        // $(document).on('click', '.status-toggle-btn', function() {
        //     var button = $(this);
        //     var subcategoryId = button.data('id');
        //     var currentStatus = button.data('current-status');
        //     var nextStatus = button.data('next-status');
        //     var token = $('meta[name="csrf-token"]').attr('content'); 

        //     $.ajax({
        //         url: 'user/update-status/' + subcategoryId, 
        //         type: 'POST',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             status: nextStatus 
        //         },
        //         beforeSend: function() {
        //             button.text('Updating...').prop('disabled', true);
        //         },
        //         success: function(response) {
        //             if (response.success) {
        //                 $('#user_table').DataTable().ajax.reload(null, false); 
        //             } else {                     
        //                 button.prop('disabled', false).text(currentStatus == 1 ? 'Active' : 'Inactive');
        //             }
        //         },
        //         error: function(xhr) {
        //             Swal.fire('Error', 'An unexpected error occurred.', 'error');
        //             button.prop('disabled', false).text(currentStatus == 1 ? 'Active' : 'Inactive');
        //         }
        //     });
        // });
    </script>
@endsection
