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
                <h4 class="fw-bold">Social Media </h4>
            </div>
        </div>

        {{-- <div class="page-btn mt-0">
            <a href="product-list.html" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to
                Social Media</a>
        </div> --}}
    </div>
    <form action="{{ route('social.store') }}" method="POST" class="add-product-form" enctype="multipart/form-data">
        @csrf
        <div class="add-product">
            <div class="accordions-items-seperate" id="accordionSpacingExample">
                <div class="accordion-item border mb-4">
                    <h2 class="accordion-header">
                        <div class="accordion-button collapsed bg-primary">
                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                <h5 class="d-flex align-items-center text-light"><span>Social Media</span></h5>
                            </div>
                        </div>
                    </h2>
                    <div id="SpacingOne" class="accordion-collapse collapse show">
                        <div class="accordion-body border-top">
                            <div class="row p-2">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label me-2 pt-2">Facebook</label>
                                        <input type="hidden" name="socials[facebook][label]" value="Facebook">
                                        <input type="text" class="form-control me-2" name="socials[facebook][value]"
                                            value="{{ old('socials.facebook.value', $socials['Facebook']->value ?? '') }}"
                                            placeholder="Enter Facebook URL">
                                        <div class="form-check form-switch m-0 form-check-lg d-flex">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch-facebook" name="socials[facebook][status]" value="1"
                                                {{ old('socials.facebook.status', $socials['Facebook']->status ?? 0) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-1"
                                                for="switch-facebook">Active/Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row p-2">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label me-2 pt-2">Instagram</label>
                                        <input type="hidden" name="socials[instagram][label]" value="Instagram">
                                        <input type="text" class="form-control me-2" name="socials[instagram][value]"
                                            value="{{ old('socials.instagram.value', $socials['Instagram']->value ?? '') }}"
                                            placeholder="Enter Instagram URL">
                                        <div class="form-check form-switch m-0 form-check-lg d-flex">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch-instagram" name="socials[instagram][status]" value="1"
                                                {{ old('socials.instagram.status', $socials['Instagram']->status ?? 0) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-1"
                                                for="switch-instagram">Active/Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row p-2">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label me-2 pt-2">Twitter</label>
                                        <input type="hidden" name="socials[twitter][label]" value="Twitter">
                                        <input type="text" class="form-control me-2" name="socials[twitter][value]"
                                            value="{{ old('socials.twitter.value', $socials['Twitter']->value ?? '') }}"
                                            placeholder="Enter Twitter URL">
                                        <div class="form-check form-switch m-0 form-check-lg d-flex">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch-twitter" name="socials[twitter][status]" value="1"
                                                {{ old('socials.twitter.status', $socials['Twitter']->status ?? 0) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-1"
                                                for="switch-twitter">Active/Inactive</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row p-2">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3 d-flex">
                                        <label class="form-label me-2 pt-2">WhatsApp</label>
                                        <input type="hidden" name="socials[whatsapp][label]" value="WhatsApp">
                                        <input type="text" class="form-control me-2" name="socials[whatsapp][value]"
                                            value="{{ old('socials.whatsapp.value', $socials['WhatsApp']->value ?? '') }}"
                                            placeholder="Enter WhatsApp Number">
                                        <div class="form-check form-switch m-0 form-check-lg d-flex">
                                            <input class="form-check-input" type="checkbox" role="switch"
                                                id="switch-whatsapp" name="socials[whatsapp][status]" value="1"
                                                {{ old('socials.whatsapp.status', $socials['WhatsApp']->status ?? 0) ? 'checked' : '' }}>
                                            <label class="form-check-label ms-1"
                                                for="switch-whatsapp">Active/Inactive</label>
                                        </div>
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
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
@endsection
@section('script')
@endsection
