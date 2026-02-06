@extends('Layouts.app')
@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap5.min.css') }}">
@endsection
@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Testimonial</h4>
            <h6>Manage your Testimonial</h6>
        </div>
    </div>
    <div class="page-btn">
        <a href="{{route('testimonial.create')}}" class="btn btn-primary">
            <i class="ti ti-circle-plus me-1"></i>Add Testimonial
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3 bg-primary">
        <div>
            <h4 class="text-light">Testimonial List</h4>
        </div>
    </div>
    <div class="card-body p-3">
        <div class="table-responsive">
            <table class="table " id="testimonial_table">
                <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <!-- <th>Category</th> -->
                        <!-- <th>Status</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($testimonials as $key=>$item)
                    <tr>
                        <td>{{ $item->id }}</td>

                        <td>
                            <img
                                src="{{ url('public/' . $item->image) }}"
                                width="50"
                                height="50"
                                class="rounded"
                                onerror="this.onerror=null;this.src='{{ asset('public/uploads/products/noimage.png') }}';"
                                alt="item Image">
                        </td>


                        <td>{{ $item->name }}</td>

                        <!-- <td>
                            @if($item->status == 1)
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td> -->

                        <td class="text-end">
                            <a href="{{ route('testimonial.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <button class="btn btn-sm btn-danger delete-btn"
                                data-id="{{ $item->id }}" data-url="{{ route('testimonial.destroy', $item->id) }}">
                                Delete
                            </button>
                        </td>


                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ url('assets/plugins/sweetalert/sweetalert2.all.min.js')}}"></script>
<script src="{{ url('assets/plugins/sweetalert/sweetalerts.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $(function() {
       
        $('#testimonial_table').DataTable()
            .row(row)
            .remove()
            .draw(false);
    });
</script>
<script>
    $(document).on('click', '.delete-btn', function() {
        let productId = $(this).data('id');
        let row = $(this).closest('tr');
        let url = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: "This product will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire('Deleted!', response.message, 'success');
                        row.fadeOut(500, function() {
                            $(this).remove();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Delete failed!', 'error');
                    }
                });
            }
        });
    });
</script>


@endsection