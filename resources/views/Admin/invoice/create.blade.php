@extends('Layouts.app')

@section('style')
<style>
    .accordion-button:after {
        content: none;
    }

    .add-product-form .table tbody tr td {
        padding: 5px !important;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Add invoice</h4>
        </div>
    </div>
    <div class="page-btn mt-0">
        <a href="{{ route('invoice.index') }}" class="btn btn-secondary">
            <i data-feather="arrow-left" class="me-2"></i>Back to invoice
        </a>
    </div>
</div>

<form action="{{ route('invoice.store') }}" method="POST" class="add-product-form" enctype="multipart/form-data">
    @csrf
    <div class="add-product">
        <div class="accordion-item border mb-4">
            <h2 class="accordion-header">
                <div class="accordion-button collapsed bg-primary">
                    <h5 class="text-light">Add Product</h5>
                </div>
            </h2>

          @error('customer_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        @if ($errors->has('product_id.*') || $errors->has('qty.*') || $errors->has('price.*'))
            <div class="alert alert-warning">
                Please check the quantity and price fields for all items.
            </div>
        @endif

        @if (session('errors'))
            @if ($errors->has('stock_error'))
                <div class="alert alert-danger">
                    {{ $errors->first('stock_error') }}
                </div>
            @endif
        @endif

            <div class="accordion-body border-top">
                <div class="form-group col-md-3 mb-3">
                    <label>Customer Name</label>
                    <select name="customer_id" class="form-control">
                        <option>Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{$customer->id}}">{{$customer->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-3 mb-3">
                    <label>Date</label>
                    <input name="date" class="form-control" value="{{ date('Y-m-d') }}" type="date">
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount %</th>
                            <th>Amount</th>
                            <th scope="col"><a class="addRow btn btn-success "><i class="fa fa-plus"></i></a></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="product_id[]" class="form-control productname">
                                    <option>Select Product</option>
                                    @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary decrement">-</button>
                                    <input type="text" name="qty[]" class="form-control qty text-center" value="0" readonly>
                                    <button type="button" class="btn btn-outline-secondary increment">+</button>
                                </div>
                            </td>



                            <td><input type="text" name="price[]" class="form-control price"></td>
                            <td><input type="text" name="dis[]" class="form-control dis" value="0"></td>
                            <td><input type="text" name="amount[]" class="form-control amount" value="0.00"></td>
                            <td><a class="btn btn-danger remove"><i class="fa fa-remove"></i></a></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td><b>Total</b></td>
                            <td><b class="total">0.00</b></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
$(document).ready(function() {

    // ================================
    // PRODUCT SELECT EVENT
    // ================================
    $(document).on("change", ".productname", function () {
        var tr = $(this).closest("tr");
        var product_id = $(this).val();

        $.ajax({
            type: "GET",
            url: "{{ route('check.stock') }}",
            data: { id: product_id },
            dataType: "json",
            success: function (data) {

                // Set price
                tr.find(".price").val(data.sellprice);

                // Save stock to row
                tr.attr("data-stock", data.stock);

                // Default qty = 1
                tr.find(".qty").val(1);

                // Check stock across rows
                if (!checkTotalStock(product_id)) {
                    tr.find(".qty").val(0);
                    tr.find(".amount").val("0.00");
                    alert("Stock unavailable, already used in another row.");
                    total();
                    return;
                }

                calculateRow(tr);
            }
        });
    });

    // ================================
    // INCREMENT QTY
    // ================================
    $(document).on("click", ".increment", function () {
        var tr = $(this).closest("tr");
        var product_id = tr.find(".productname").val();

        if (!product_id) {
            alert("Please select a product first!");
            return;
        }

        var qtyInput = tr.find(".qty");
        var newQty = parseInt(qtyInput.val()) + 1;

        qtyInput.val(newQty);

        if (!checkTotalStock(product_id)) {
            qtyInput.val(newQty - 1);
            alert("Not enough stock available!");
            return;
        }

        calculateRow(tr);
    });

    // ================================
    // DECREMENT QTY
    // ================================
    $(document).on("click", ".decrement", function () {
        var tr = $(this).closest("tr");
        var qtyInput = tr.find(".qty");
        var qty = parseInt(qtyInput.val());

        if (qty > 1) {
            qtyInput.val(qty - 1);
            calculateRow(tr);
        }
    });

    // ================================
    // INPUT CHANGE EVENTS
    // ================================
    $(document).on("keyup change", ".qty, .price, .dis", function () {
        var tr = $(this).closest("tr");
        calculateRow(tr);
    });

    // ================================
    // ADD NEW ROW
    // ================================
    $(".addRow").on("click", function () {

        var row = `
        <tr data-stock="0">
            <td>
                <select name="product_id[]" class="form-control productname">
                    <option value="" disabled selected>Select Product</option>
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                    @endforeach
                </select>
            </td>

            <td>
                <div class="input-group">
                    <button type="button" class="btn btn-outline-secondary decrement">-</button>
                    <input type="number" name="qty[]" class="form-control qty text-center" value="0" readonly>
                    <button type="button" class="btn btn-outline-secondary increment">+</button>
                </div>
            </td>

            <td><input type="number" name="price[]" class="form-control price" value="0.00"></td>
            <td><input type="number" name="dis[]" class="form-control dis" value="0" min="0"></td>
            <td><input type="text" name="amount[]" class="form-control amount" readonly></td>
            <td><a class="btn btn-danger remove"><i class="fa fa-remove"></i></a></td>
        </tr>`;

        $("tbody").append(row);
    });

    // ================================
    // REMOVE ROW
    // ================================
    $(document).on("click", ".remove", function () {
        $(this).closest("tr").remove();
        total();
    });

    // ================================
    // STOCK CHECK FUNCTION
    // ================================
    function checkTotalStock(product_id) {
        var totalUsed = 0;
        var stock = 0;

        $("tbody tr").each(function () {
            var rowProduct = $(this).find(".productname").val();
            if (rowProduct == product_id) {
                totalUsed += parseInt($(this).find(".qty").val()) || 0;
                stock = parseInt($(this).attr("data-stock")) || 0;
            }
        });

        return totalUsed <= stock;
    }

    // ================================
    // CALCULATE ROW AMOUNT
    // ================================
    function calculateRow(tr) {
        var qty = parseFloat(tr.find(".qty").val()) || 0;
        var price = parseFloat(tr.find(".price").val()) || 0;
        var dis = parseFloat(tr.find(".dis").val()) || 0;

        var totalPrice = qty * price;
        var discount = (totalPrice * dis) / 100;
        var amount = totalPrice - discount;

        tr.find(".amount").val(amount.toFixed(2));
        total();
    }

    // ================================
    // CALCULATE TOTAL
    // ================================
    function total() {
        var sum = 0;

        $(".amount").each(function () {
            sum += parseFloat($(this).val()) || 0;
        });

        $(".total").text(sum.toFixed(2));
    }

});
</script>
@endsection

