@extends('Layouts.app')
@section('style')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css" />

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
                <h4 class="fw-bold">Add site Setting</h4>
            </div>
        </div>
        {{-- <div class="page-btn mt-0">
            <a href="product-list.html" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to
                 sitesetting</a>
        </div> --}}
    </div>
    <form action="{{ route('sitesetting.store') }}" method="POST" class="add-product-form" enctype="multipart/form-data">
        @csrf
        <div class="add-product">
            <div class="accordions-items-seperate" id="accordionSpacingExample">
                <div class="accordion-item border mb-4">
                    <h2 class="accordion-header">
                        <div class="accordion-button collapsed bg-primary">
                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                <h5 class="d-flex align-items-center text-light"><span>Add site Setting</span></h5>
                            </div>
                        </div>
                    </h2>


                    <div id="SpacingOne" class="accordion-collapse collapse show">
                        <div class="accordion-body border-top">
                            @if (session('success'))
                                <div id="error-message" class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Site Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $sitesetting->name ?? '') }}" placeholder="Site Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Site URL</label>
                                        <input type="text" class="form-control" name="url"
                                            value="{{ old('url', $sitesetting->url ?? '') }}" placeholder="Site URL">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact</label>
                                        <input type="text" class="form-control" name="contact"
                                            value="{{ old('contact', $sitesetting->contact ?? '') }}"
                                            placeholder="Contact Number">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact 1</label>
                                        <input type="text" class="form-control" name="contact1"
                                            value="{{ old('contact1', $sitesetting->contact1 ?? '') }}"
                                            placeholder="Contact Number">
                                    </div>
                                </div>
                                <div class="col-sm-3 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Contact 2</label>
                                        <input type="text" class="form-control" name="contact2"
                                            value="{{ old('contact2', $sitesetting->contact2 ?? '') }}"
                                            placeholder="Contact Number">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $sitesetting->email ?? '') }}"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" name="address" rows="2" placeholder="Address">{{ old('address', $sitesetting->address ?? '') }}</textarea>
                                    </div>
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
                                                            <input type="file" name="logo" id="image">
                                                            <div class="image-uploads">
                                                                <i data-feather="plus-circle"
                                                                    class="plus-down-add me-0"></i>
                                                                <h4>Edit Logo</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="phone-img">
                                                        <img src="{{ url('public/uploads/sitesetting/' . $sitesetting->logo) }}"
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
                                        <div class="text-editor add-list add">
                                            <div class="col-lg-12">
                                                <div class="add-choosen">
                                                    <div class="mb-3">
                                                        <div class="image-upload image-upload-two">
                                                            <input type="file" name="favicon" id="image">
                                                            <div class="image-uploads">
                                                                <i data-feather="plus-circle"
                                                                    class="plus-down-add me-0"></i>
                                                                <h4>Edit Favicon</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="phone-img">
                                                        <img src="{{ url('public/uploads/sitesetting/' . $sitesetting->favicon) }}"
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
                                        <div class="text-editor add-list add">
                                            <div class="col-lg-12">
                                                <div class="add-choosen">
                                                    <div class="mb-3">
                                                        <div class="image-upload image-upload-two">
                                                            <input type="file" name="background_image" id="image">
                                                            <div class="image-uploads">
                                                                <i data-feather="plus-circle"
                                                                    class="plus-down-add me-0"></i>
                                                                <h4>Edit Background Image</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="phone-img">
                                                        <img src="{{ url('public/uploads/sitesetting/' . $sitesetting->background_image) }}"
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
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        {{-- <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label class="form-label">Primary Color</label>
                                                    <input type="color" style="height:100px;width:100px;"
                                                        class="form-control form-control-color" name="color"
                                                        value="{{ old('color', $sitesetting->color ?? '#000000') }}">
                                                </div>
                                            </div> --}}

                                        <label class="form-label" for="backgroundColor">Primary Color</label>
                                        <div class="position-relative">
                                            <input type="color" id="backgroundColor1" name="color"
                                                class="form-control form-control-color"
                                                value="{{ old('color', $sitesetting->color ?? '#000000') }}"
                                                style="width: 100%; height: 50px; cursor: pointer;">

                                            <input type="text" id="colorCode1" readonly
                                                class="form-control position-absolute top-0 start-0 "
                                                style="background: transparent; border: none; height: 50px; pointer-events: none; color: #000; font-weight: 600;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="backgroundColor">Background
                                            Color</label>
                                        <div class="position-relative">
                                            <input type="color" id="backgroundColor" name="background_color"
                                                class="form-control form-control-color"
                                                value="{{ old('background_color', $sitesetting->background_color ?? '#d6a9a4') }}"
                                                style="width: 100%; height: 50px; cursor: pointer;">

                                            <input type="text" id="colorCode" readonly
                                                class="form-control position-absolute top-0 start-0 "
                                                style="background: transparent; border: none; height: 50px; pointer-events: none; color: #dd6d6d; font-weight: 600;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                          

                            {{-- <div class="col-xxl-6 col-md-6">
                                            <div>
                                                <label class="form-label">Footer Text</label>
                                                <input type="text" class="form-control" name="footer_text"
                                                    value="{{ old('footer_text', $sitesetting->footer_text ?? '') }}">
                                            </div>
                                        </div> --}}

                            <!-- Status -->
                            {{-- <div class="col-xxl-12 col-md-6">
                                            <div>
                                                <div class="form-check form-switch pt-4">
                                                    <input class="form-check-input" type="checkbox" name="status"
                                                        value="1"
                                                        {{ old('status', $sitesetting->status ?? 0) ? 'checked' : '' }}>
                                                    <label class="form-check-label ms-1">Active</label>
                                                </div>
                                            </div>
                                        </div> --}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js">
</script>

@section('script')
    <script>
        const colorPicker = document.getElementById('backgroundColor');
        const colorCode = document.getElementById('colorCode');
        colorCode.value = colorPicker.value.toUpperCase();
        colorPicker.addEventListener('input', function() {
            colorCode.value = colorPicker.value.toUpperCase();
        });

        const colorPicker1 = document.getElementById('backgroundColor1');
        const colorCode1 = document.getElementById('colorCode1');
        colorCode1.value = colorPicker1.value.toUpperCase();
        colorPicker1.addEventListener('input', function() {
            colorCode1.value = colorPicker1.value.toUpperCase();
        });
    </script>
    <script>
        setTimeout(function() {
            const errorDiv = document.getElementById('error-message');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }, 3000);
    </script>
@endsection
