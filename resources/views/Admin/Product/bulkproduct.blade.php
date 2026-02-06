@extends('Layouts.app')
@section('style')
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Product Csv Upload</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Product Csv Upload</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Product Csv Upload</h4>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <form action="{{ route('product.bulkUpload') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">
                                        <div class="hstack flex-wrap gap-2">
                                            <div class="col-xxl-12 col-md-6">
                                                <div>
                                                    <label for="csv_file" class="form-label">Product CSV File</label>
                                            
                                                    <input type="file" name="csv_file" id="csv_file" class="form-control @error('csv_file') is-invalid @enderror" accept=".csv" required>

                                                    @error('csv_file')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-md-6 justyfy-content-end d-flex">
                                            <button type="submit"
                                                class="btn btn-primary btn-animation waves-effect waves-light"
                                                data-text="Save">
                                                <span>Upload file</span>
                                            </button>
                                        </div>
                                    </div>

                                </form>


                            </div>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
