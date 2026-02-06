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
                <h4 class="fw-bold">Edit Stock</h4>
            </div>
        </div>
        <ul class="table-top-head">
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
            </li>
            <li>
                <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header">
                    <i class="ti ti-chevron-up"></i>
                </a>
            </li>
        </ul>
        <div class="page-btn mt-0">
            <a href="{{ route('stock') }}" class="btn btn-secondary">
                <i data-feather="arrow-left" class="me-2"></i> Back to Stock
            </a>
        </div>
    </div>

    <form action="{{ route('stock.update', $stock->id) }}" method="POST" class="add-product-form"
        enctype="multipart/form-data">
        @csrf

        <div class="add-product">
            <div class="accordions-items-seperate" id="accordionSpacingExample">
                <div class="accordion-item border mb-4">
                    <h2 class="accordion-header">
                        <div class="accordion-button collapsed bg-primary">
                            <div class="d-flex align-items-center justify-content-between flex-fill">
                                <h5 class="d-flex align-items-center text-light">
                                    <span>Edit Stock</span>
                                </h5>
                            </div>
                        </div>
                    </h2>
                    <div id="SpacingOne" class="accordion-collapse collapse show">
                        <div class="accordion-body border-top">
                            <input type="hidden" name="id" value="{{ $stock->id }}">

                            {{-- <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Warehouse <span class="text-danger ms-1">*</span></label>
                                    <select class="form-select" name="warehouse" id="warehouse" required>
                                        <option value="">Select</option>
                                        <option value="warehouse1" {{ $stock->warehouse == 'warehouse1' ? 'selected' : '' }}>Main Warehouse</option>
                                        <option value="warehouse2" {{ $stock->warehouse == 'warehouse2' ? 'selected' : '' }}>Secondary Warehouse</option>
                                    </select>
                                </div>
                            </div>
                        </div> --}}

                            {{-- <div class="row">
                            <div class="col-lg-6">
                                <div class="search-form mb-0">
                                    <label class="form-label">Product <span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="product_search" id="productsearch"
                                            placeholder="Search and select Product">
                                        <i data-feather="search" class="feather-search"></i>
                                        <div id="productSearchResults" class="list-group position-absolute w-100 mt-1" style="z-index: 1000;"></div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table" id="stock_table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Product</th>
                                                    <th>SKU</th>
                                                    <th>Qty</th>
                                                    {{-- <th>Action</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody id="selectedProductsTableBody">
                                                <tr id="row-{{ $stock->product->id }}">
                                                    <td class="d-flex align-items-center">
                                                        @if (!empty($stock->product->image) && file_exists(public_path('uploads/products/' . $stock->product->image)))
                                                            <img src="{{ url('public/uploads/products/' . $stock->product->image) }}"
                                                                alt="{{ $stock->product->name }}" width="30"
                                                                class="me-2 rounded">
                                                        @else
                                                            <img src="{{ url('assets/img/no-image.png') }}" alt="No Image"
                                                                width="30" class="me-2 rounded">
                                                        @endif
                                                        {{ $stock->product->name }}
                                                    </td>
                                                    <td>{{ $stock->product->sku }}</td>
                                                    <td>
                                                        <div class="input-group input-group-sm "style="width:50%;">
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-qty-minus"
                                                                data-id="{{ $stock->product->id }}">-</button>
                                                            <input type="text"
                                                                name="items[{{ $stock->product->id }}][quantity]"
                                                                class="form-control text-center input-qty"
                                                                value="{{ old('items.' . $stock->product->id . '.quantity', $stock->total_stock) }}"
                                                                min="1"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                            <button type="button"
                                                                class="btn btn-outline-secondary btn-qty-plus"
                                                                data-id="{{ $stock->product->id }}">+</button>
                                                        </div>
                                                        <input type="hidden"
                                                            name="items[{{ $stock->product->id }}][product_id]"
                                                            value="{{ $stock->product->id }}">
                                                    </td>

                                                    {{-- <td>
                                                    <button type="button" class="btn btn-danger btn-sm btn-remove-item"
                                                        data-id="{{ $stock->product->id }}">
                                                        <i data-feather="trash-2"></i>
                                                    </button>
                                                </td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
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
        </div>
    </form>
@endsection

@section('script')
    <script>
        // Quantity increment/decrement
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-qty-plus')) {
                const input = e.target.closest('.input-group').querySelector('.input-qty');
                input.value = parseInt(input.value) + 1;
            } else if (e.target.closest('.btn-qty-minus')) {
                const input = e.target.closest('.input-group').querySelector('.input-qty');
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            }

            if (e.target.closest('.btn-remove-item')) {
                const rowId = e.target.closest('.btn-remove-item').dataset.id;
                document.getElementById('row-' + rowId)?.remove();
            }
        });
    </script>
@endsection
