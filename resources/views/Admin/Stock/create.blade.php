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
            <h4 class="fw-bold">Add Stock</h4>
        </div>
    </div>
    <div class="page-btn mt-0">
        <a href="{{ route('stock') }}" class="btn btn-secondary"><i data-feather="arrow-left" class="me-2"></i>Back to
            stock</a>
    </div>
</div>
<form action="{{ route('stock.store') }}" method="POST" class="add-product-form" enctype="multipart/form-data">
    @csrf
    <div class="add-product">
        <div class="accordions-items-seperate">
            <div class="accordion-item border mb-4">
                <h2 class="accordion-header">
                    <div class="accordion-button collapsed bg-primary">
                        <div class="d-flex align-items-center justify-content-between flex-fill">
                            <h5 class="d-flex align-items-center text-light"><span>Add Stock</span></h5>
                        </div>
                    </div>
                </h2>

                <div id="SpacingOne" class="accordion-collapse collapse show">
                    <div class="accordion-body border-top">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Warehouse <span class="text-danger ms-1">*</span></label>
                                    <select class="select" name="warehouse" id="warehouse">
                                        <option value="">Select</option>
                                        <option selected value="warehouse">Main Warehouse</option>
                                        {{-- @foreach ($warehouse as $item)                                                
                                               <option  value="{{old('warehouse',$item->id)}}">{{$item->name}}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="search-form mb-0">
                                    <label class="form-label">Product <span class="text-danger ms-1">*</span></label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" name="product_search"
                                            id="productsearch" placeholder="Search and select Product">
                                        <i data-feather="search" class="feather-search"></i>
                                        <div id="productSearchResults" class="list-group position-absolute w-100 mt-1"
                                            style="z-index: 1000;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table " id="stock_table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Product</th>
                                                <th>SKU</th>
                                                <th>Category</th>
                                                <th>Qty</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="selectedProductsTableBody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="SpacingThree" class="accordion-collapse collapse show" aria-labelledby="headingSpacingThree">
                    <div class="accordion-body border-top">
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
    $(document).ready(function() {
        $('#productsearch').on('keyup', function() {
            let query = $(this).val();
            let resultsContainer = $('#productSearchResults');
            resultsContainer.empty();
            let url = '{{ route("stock.search.products") }}';
            if (query.length > 2) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function(response) {
                        if (response.products.length > 0) {
                            $.each(response.products, function(index, product) {
                                let itemHtml = `<a href="#" 
                                                        class="list-group-item list-group-item-action product-select-item"
                                                        data-id="${product.id}" 
                                                        data-name="${product.name}" 
                                                        data-sku="${product.sku}" 
                                                        data-category="${product.category_name}"
                                                        data-stock="${product.stock}"
                                                        data-image="${product.image}">
                                                        ${product.name} (${product.sku})
                                                    </a>`;
                                resultsContainer.append(itemHtml);
                            });
                        } else {
                            resultsContainer.append(
                                '<div class="list-group-item">No products found.</div>');
                        }
                    }
                });
            }
        });

        // Function to add the selected product to the table
        $(document).on('click', '.product-select-item', function(e) {
            e.preventDefault();
            let productId = $(this).data('id');
            let productName = $(this).data('name');
            let productSku = $(this).data('sku');
            let productCategory = $(this).data('category');
            let productImage = $(this).data('image');
            let productStock = $(this).data('stock');

            // Clear search results and input
            $('#productsearch').val('');
            $('#productSearchResults').empty();

            if ($(`#row-${productId}`).length) {
                alert('This product is already in the list.');
                return;
            }

            let newRow = `
                    <tr id="row-${productId}">
                        <td class="d-flex align-items-center">
                            <img src="${productImage}" alt="${productName}" width="30" class="me-2">
                            ${productName}
                        </td>
                        <td>${productSku}</td>
                        <td>${productCategory}</td>
                        <td>
                            <div class="input-group input-group-sm"style="width:50%;">
                                <button type="button" class="btn btn-outline-secondary btn-qty-minus" data-id="${productId}">-</button>
                                <input type="text" name="items[${productId}][quantity]" class="form-control text-center input-qty" value="1" min="1"  oninput="this.value = this.value.replace(/[^0-9]/g, '');" >
                                <button type="button" class="btn btn-outline-secondary btn-qty-plus" data-id="${productId}">+</button>
                            </div>
                            <input type="hidden" name="items[${productId}][product_id]" value="${productId}">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btn-remove-item" data-id="${productId}">
                                <i data-feather="trash-2"></i>
                            </button>
                        </td>
                    </tr>
                `;
            $('#selectedProductsTableBody').append(newRow);
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });

        $(document).on('click', '.btn-qty-plus', function() {
            let row = $(this).closest('tr');
            let input = row.find('.input-qty');
            let currentVal = parseInt(input.val());
            input.val(currentVal + 1);
        });

        $(document).on('click', '.btn-qty-minus', function() {
            let row = $(this).closest('tr');
            let input = row.find('.input-qty');
            let currentVal = parseInt(input.val());
            if (currentVal > 1) {
                input.val(currentVal - 1);
            }
        });

        // Handle Item Removal
        $(document).on('click', '.btn-remove-item', function() {
            let productId = $(this).data('id');
            $(`#row-${productId}`).remove();
        });
    });
</script>
@endsection