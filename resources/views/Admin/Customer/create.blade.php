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
            <h4 class="fw-bold">Add Party</h4>
        </div>
    </div>
    <div class="page-btn mt-0">
        <a href="#" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to Parties</a>
    </div>
</div>

<form action="{{route('customer.store')}}" method="POST" class="add-product-form" enctype="multipart/form-data">
    @csrf
    <div class="add-product">
        <div class="container mt-4">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            {{-- This section displays validation errors when redirecting back --}}
            @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Validation Error!</strong> Please check the form fields below.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
        <div class="accordions-items-seperate" id="accordionSpacingExample">
            <div class="accordion-item border mb-4">
                <h2 class="accordion-header">
                    <div class="accordion-button collapsed bg-primary">
                        <div class="d-flex align-items-center justify-content-between flex-fill">
                            <h5 class="d-flex align-items-center text-light"><span>Party Details</span></h5>
                        </div>
                    </div>
                </h2>
                <div id="SpacingOne" class="accordion-collapse collapse show">
                    <div class="accordion-body border-top">

                        <div class="col-md-12 mt-3">
                            <label class="form-label">Party Name<span class="text-danger">*</span></label>
                            {{-- Added name="name" --}}
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter name" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="form-label">Mobile Number</label>
                            {{-- Added name="mobile" --}}
                            <input type="text" name="mobile" value="{{ old('mobile') }}" class="form-control @error('mobile') is-invalid @enderror" placeholder="Enter mobile number">
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label">Email</label>
                            {{-- Added name="email" --}}
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control @error('address') is-invalid @enderror"></textarea>
                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="row">
                            {{-- State Dropdown --}}
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">State<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="state_id" id="state_id">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                        {{-- Ensure value is the ID --}}
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- City Dropdown (Target for AJAX) --}}
                            <div class="col-sm-6 col-12">
                                <div class="mb-3">
                                    <label class="form-label">City<span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="city_id" id="city_id">
                                        {{-- Initial default option --}}
                                        <option value="">Select State First</option>
                                    </select>
                                    @error('city_id')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Other fields here (e.g., Category dropdown you had previously) --}}

                        </div>
                        <div class="col-md-12 mt-3">
                            <label class="form-label">Details</label>
                            <textarea name="details" class="form-control @error('details') is-invalid @enderror"></textarea>
                            @error('details')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="col-md-12 mt-3">
                            <label class="form-label">Previous Credit Balance</label>
                            <input name="previous_balance" class="form-control @error('previous_balance') is-invalid @enderror" type="text" placeholder="Example: 2000">
                            @error('previous_balance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="d-flex align-items-center justify-content-end mb-4">
            <button type="submit" class="btn btn-primary">Save Party</button>
        </div>
    </div>
</form>


@endsection
@section('script')
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $('#state_id').on('change', function() {
            var stateID = $(this).val();
            var cityDropdown = $('#city_id');
            cityDropdown.empty().append('<option value="">Loading Cities...</option>');

            if (stateID) {
                $.ajax({
                    url: "{{ route('citiesget') }}",
                    type: "POST",
                    data: {
                        state_id: stateID
                    },
                    dataType: "json",
                    success: function(data) {
                        cityDropdown.empty();
                        cityDropdown.append('<option value="">Select City</option>');
                        $.each(data.cities, function(key, value) {
                            cityDropdown.append('<option value="' + value.id + '">' + value.city + '</option>');
                        });
                        if (cityDropdown.hasClass('select') && $.fn.select2) {
                            cityDropdown.select2('destroy');
                            cityDropdown.select2();
                        }
                    },
                    error: function(xhr) {
                        console.error("Error loading cities:", xhr.responseText);
                        cityDropdown.empty().append('<option value="">Error loading cities</option>');
                    }
                });
            } else {
                // If the user selects "Select State"
                cityDropdown.empty().append('<option value="">Select State First</option>');
            }
        });
    });
</script>
@endsection