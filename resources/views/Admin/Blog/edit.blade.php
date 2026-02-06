@extends('Layouts.app')
@section('style')
<style>
#cke_notifications_area_my-editor
{
    display:none;
}
</style>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Blog Edit</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Blog Edit</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                         <div class="card-header">
                            <h4 class="card-title mb-0">Blogs Edit</h4>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <form action="{{ route('blog.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row gy-4">
                                        <input type="hidden" name="id" value="{{ $blog->id }}">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text"
                                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                                    id="title" value="{{ old('title', $blog->title) }}">
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="subtitle" class="form-label">Sub Title</label>
                                                <input type="text"
                                                    class="form-control @error('subtitle') is-invalid @enderror"
                                                    name="subtitle" id="subtitle"
                                                    value="{{ old('subtitle', $blog->subtitle) }}">
                                                @error('subtitle')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <label for="author" class="form-label">Author</label>
                                                <input type="text"
                                                    class="form-control @error('author') is-invalid @enderror"
                                                    name="author" id="author"
                                                    value="{{ old('author', $blog->author) }}">
                                                @error('author')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xxl-6 col-md-6">
                                            <label>Image</label><br>

                                            <input type="file" name="image"
                                                class="form-control  @error('image') is-invalid @enderror mt-2">
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-xxl-6 col-md-6">
                                            <img src="{{ url('public/' . $blog->image) ? url('public/' . $blog->image) : asset('assets/images/noimage.png') }}"
                                                width="60" height="60">
                                        </div>
                                        <div class="col-xxl-12 col-md-6">
                                            <div>
                                                <label for="description" class="form-label"> Description</label>

                                                <textarea id="my-editor" name="description" class="form-control ckeditor" rows="10"
                                                    placeholder="Enter page content here">{{ old('description', $blog->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xxl-12 col-md-12 text-center">
                                            <button type="submit" class="col-mb-2 btn btn-primary">Update Blog</button>
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
                <h4 class="fw-bold">Edit Cms</h4>
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
            <a href="{{ route('cms') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back
                to
                Cms</a>
        </div>
    </div>
    <form action="{{ route('cms.update') }}" method="POST" class="add-product-form" enctype="multipart/form-data">
        @csrf
        <div class="add-product">
            <div class="accordions-items-seperate" id="accordionSpacingExample">
                <div class="accordion-item border mb-4">
                    <h2 class="accordion-header">
                        <div class="accordion-button collapsed bg-primary">
                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                <h5 class="d-flex align-items-center text-light"><span>Edit cms</span></h5>
                            </div>
                        </div>
                    </h2>
                    <div id="SpacingOne" class="accordion-collapse collapse show">
                        <div class="accordion-body border-top">
                            <input type="hidden" name="id" value="{{ $cms->id }}">
                            <div class="row">
                                <div class="col-sm-6 col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Title<span
                                                class="text-danger ms-1">*</span></label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            value="{{ old('title', $cms->title) }}">
                                    </div>
                                </div>
                            </div>

  

                      
                            <div class="row">
                                <div class="col-lg-12">
                                    {{-- <div class="summer-description-box">
                                        <label class="form-label">Description</label>
                                        <div class="editor pages-editor">{!! old('description', $product->description) !!}
                                        </div>
                                    </div> --}}
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="my-editor" name="content" class="form-control ckeditor" rows="10"
                                        placeholder="Enter product description">{!! old('content', $cms->content) !!}</textarea>
                                </div>
                            </div>
                          
                            <div class="row">
                                <div class="col-sm-12 col-12">
                                    <div class="mb-4 mt-4">
                                        <label class="form-label">Status</label>

                                        <div class="form-check form-check-lg form-switch">
                                            <input class="form-check-input" type="checkbox" name="status"
                                                role="switch" id="switch-lg"
                                                value="{{ old('status', $cms->status ?? 0) == 1 ? '1' : '0' }}"
                                                {{ old('status', $cms->status ?? 0) == 1 ? 'checked' : '' }}>
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
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
    </form>
@endsection
@section('script')

@endsection
