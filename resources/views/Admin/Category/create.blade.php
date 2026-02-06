@extends('Layouts.app')
@section('style')
    <style>
        .accordion-button:after {
            content: none;
        }
    </style>
@endsection
@section('content')
    <div class="page-header">
        <div class="add-item d-flex">
            <div class="page-title">
                <h4 class="fw-bold">Add Category</h4>
            </div>
        </div>
        <div class="page-btn mt-0">
            <a href="{{ route('category') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to
                Category</a>
        </div>
    </div>
    <form action="{{ route('category.store') }}" method="POST" class="add-product-form" enctype="multipart/form-data">
        @csrf
        <div class="add-product">
            <div class="accordions-items-seperate" id="accordionSpacingExample">
                <div class="accordion-item border mb-4">
                    <h2 class="accordion-header">
                        <div class="accordion-button collapsed bg-primary">
                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                <h5 class="d-flex align-items-center text-light"><span>Add Category </span></h5>
                            </div>
                        </div>
                    </h2>
                    <div id="SpacingOne" class="accordion-collapse collapse show">
                        <div class="accordion-body border-top">

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Title<span class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="text-editor add-list add">
                                    <div class="col-lg-12">
                                        <div class="add-choosen">
                                            <div class="mb-3">
                                                <div class="image-upload image-upload-two">
                                                    <input type="file" name="image" id="image">
                                                    <div class="image-uploads">
                                                        <i data-feather="plus-circle" class="plus-down-add me-0"></i>
                                                        <h4>Add Images</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-12">
                                    <div class="mb-4 mt-4">
                                        <label class="form-label">Status</label>
                                        <div class="form-check form-check-lg form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="switch-lg"
                                                checked name="status">
                                            <label class="form-check-label" for="switch-lg">Active/Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="d-flex align-items-center justify-content-end mb-4">
                    {{-- <button type="button" class="btn btn-secondary me-2">Cancel</button> --}}
                    <button type="submit" class="btn btn-primary">save</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script')
@endsection
