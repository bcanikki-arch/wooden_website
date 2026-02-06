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
            <h4 class="fw-bold">Edit Product</h4>
        </div>
    </div>
    <ul class="table-top-head">
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
        </li>
        <li>
            <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                    class="ti ti-chevron-up"></i></a>
        </li>
    </ul>
    <div class="page-btn mt-0">
        <a href="{{ route('product') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back
            to
            Product</a>
    </div>
</div>
<form action="{{ route('product.update') }}" method="POST" class="add-product-form" enctype="multipart/form-data">
    @csrf
    <div class="add-product">
        <div class="accordions-items-seperate" id="accordionSpacingExample">
            <div class="accordion-item border mb-4">
                <h2 class="accordion-header">
                    <div class="accordion-button collapsed bg-primary">
                        <div class="d-flex align-items-center justify-content-between flex-fill">
                            <h5 class="d-flex align-items-center text-light"><span>Edit Product</span></h5>
                        </div>
                    </div>
                </h2>
                <div id="SpacingOne" class="accordion-collapse collapse show">
                    <div class="accordion-body border-top">
                        <input type="hidden" name="id" value="{{ $service->id }}">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">Name<span
                                            class="text-danger ms-1">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $service->name) }}">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                {{-- <div class="summer-description-box">
                                        <label class="form-label">Description</label>
                                        <div class="editor pages-editor">{!! old('description', $service->description) !!}
                                        </div>
                                    </div> --}}
                                <label for="description" class="form-label">Description</label>
                                <textarea id="my-editor" name="description" class="form-control ckeditor" rows="10"
                                    placeholder="Enter service description">{!! old('description', $service->description) !!}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                {{-- <div class="summer-description-box">
                                        <label class="form-label">Sub Description</label>
                                        <div class="editor pages-editor">{!! old('subdescription', $service->subdescription) !!}
                                        </div>
                                    </div> --}}
                                <label for="subdescription" class="form-label">Sub Description</label>
                                <textarea id="my-editor" name="subdescription" class="form-control ckeditor" rows="10"
                                    placeholder="Enter service sub description">{!! old('subdescription', $service->subdescription) !!}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="mb-4 mt-4">
                                    <div class="text-editor add-list add">
                                        <div class="col-lg-12">
                                            <div class="add-choosen">
                                                <div class="mb-3">
                                                    <div class="image-upload image-upload-two">
                                                        <input type="file" name="image" id="image">
                                                        <div class="image-uploads">
                                                            <i data-feather="plus-circle"
                                                                class="plus-down-add me-0"></i>
                                                            <h4>Edit Images</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="phone-img">
                                                    <img src="{{ url('public/uploads/services/' . $service->image) ? url('public/uploads/services/' . $service->image) : asset('assets/images/noimage.png') }}"
                                                        alt="image">
                                                    <a href="javascript:void(0);"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-x x-square-add remove-product">
                                                        </svg></a>
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
                                        <input type="hidden" name="status" value="2">

                                        <input class="form-check-input"
                                            type="checkbox"
                                            name="status"
                                            id="switch-lg"
                                            value="1"
                                            {{ old('status', $service->status) == 1 ? 'checked' : '' }}>

                                        <label class="form-check-label" for="switch-lg">
                                            Active / Inactive
                                        </label>

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
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
</form>
@endsection
@section('script')
<script>

</script>
@endsection