@extends('Layouts.app')
@section('style')
<style>
    .accordion-button:after {
        content: none;
    }

    .invoice-container {
        width: 750px;
        margin: 0 auto;
        padding: 15px;
        background-color: white;
        font-family: 'Times New Roman', serif;
        font-size: 10pt;
    }

    .invoice-header,
    .party-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 5px;
        line-height: 1.2;
    }

    .header-left p,
    .header-right p {
        font-size: 10pt;
        margin: 0;
    }

    .invoice-details-center {
        text-align: center;
        margin: 10px 0 5px 0;
        line-height: 1.1;
    }

    .invoice-details-center h3 {
        font-size: 12pt;
        margin: 0;
        font-weight: bold;
    }

    .invoice-details-center p {
        font-size: 9pt;
        margin: 2px 0;
    }

    .invoice-details-center h1 {
        font-size: 13pt;
        margin: 10px 0 10px 0;
        border-bottom: 1px solid black;
        padding-bottom: 1px;
        display: inline-block;
        font-weight: 900;
    }

    .party-info {
        border-bottom: 1px solid black;
        padding-bottom: 3px;
        margin-bottom: 0;
    }

    .party-info p {
        font-size: 10pt;
        margin: 0;
    }

    .state-details {
        border-left: 1px solid black;
        padding-left: 10px;
    }

    /* --- Table Styles --- */
    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0;
    }

    .invoice-table thead th {
        border: 1px solid black;
        padding: 5px;
        text-align: left;
        font-weight: bold;
        font-size: 9pt;
        line-height: 1.1;
    }

    /* Column widths and alignments */
    .invoice-table th:first-child,
    .invoice-table tbody td:first-child {
        width: 5%;
        text-align: center;
    }

    .invoice-table th:nth-child(2),
    .invoice-table tbody td:nth-child(2) {
        width: 45%;
    }

    .invoice-table th:nth-child(3),
    .invoice-table tbody td:nth-child(3) {
        width: 10%;
        text-align: center;
    }

    .invoice-table th:nth-child(4),
    .invoice-table tbody td:nth-child(4) {
        width: 10%;
        text-align: right;
    }

    .invoice-table th:nth-child(5),
    .invoice-table tbody td:nth-child(5) {
        width: 5%;
        text-align: center;
    }

    .invoice-table th:nth-child(6),
    .invoice-table tbody td:nth-child(6) {
        width: 25%;
        text-align: right;
        font-weight: bold;
    }


    .invoice-table tbody td {
        border-left: 1px solid black;
        border-right: 1px solid black;
        padding: 3px 5px;
        vertical-align: top;
        font-size: 9pt;
    }

    .item-amount {
        font-weight: bold;
    }

    .invoice-table tbody tr:last-child td {
        border-bottom: 1px solid black;
    }

    .spacer-row-content {
        height: 350px;
        /* border: none !important; */
    }


    /* --- Totals and Footer Styles --- */
    .invoice-totals {
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        padding: 0;
        margin-top: -1px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
    }

    .totals-area {
        display: flex;
        align-items: center;
        border-top: 1px solid black;
        width: 125%;
    }

    .totals-area p {
        margin: 0;
        padding: 5px 10px;
        font-weight: bold;
        font-size: 10pt;
        border-left: 1px solid black;
    }

    .totals-area p:nth-child(1) {
        width: 30%;
        text-align: left;
        border-left: none;
    }

    .totals-area p:nth-child(2) {
        width: 14%;
        text-align: center;
    }

    .totals-area p:nth-child(3) {
        width: 40%;
        text-align: right;
    }


    .e-o-e {
        text-align: right;
        font-size: 8pt;
        margin: 5px 10px 10px 0;
        font-style: italic;
        font-weight: normal;
    }

    .amount-in-words {
        padding: 5px 0;
        border-bottom: 1px solid black;
    }

    .amount-in-words p {
        margin: 2px 0;
    }

    .amount-in-words p:first-child {
        font-size: 9pt;
    }

    .amount-in-words p:last-child {
        font-size: 10pt;
        font-weight: bold;
    }

    .invoice-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 10pt;
    }

    .declaration {
        width: 50%;
    }

    .declaration p {
        margin: 0;
    }

    .declaration p:last-child {
        font-size: 8pt;
        line-height: 1.3;
        width: 90%;
        font-weight: normal;
    }

    .signature {
        width: 50%;
        text-align: right;
    }

    .signature p {
        margin: 0;
    }

    .auth-signatory {
        border-top: 1px solid black;
        margin-top: 40px !important;
        padding-top: 2px !important;
        font-size: 9pt !important;
    }

    .computer-generated {
        text-align: center;
        font-size: 9pt;
        margin-top: 20px;
    }

    /* Hide app components during printing */
    @media print {

        .header,
        .copyright-footer,
        .sidebar,
        .app-breadcrumb,
        .d-print-none {
            display: none !important;
        }

        .app-content {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .tile {
            border: none !important;
            box-shadow: none !important;
        }

        .invoice-container {
            border: none !important;
            /* Remove the outer 1px border for clean print */
            width: 100%;
        }
    }

    /* --- End Custom CSS --- */
</style>
@endsection
@section('content')
<div class="page-header d-print-none">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4 class="fw-bold">Invoice Preview</h4>
            <p>Print or Download Invoice for {{ $invoice->customer->name ?? 'Customer' }}</p>
        </div>
    </div>

</div>
<div class="card ">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3 bg-primary d-print-none">
        <div>
            <h4 class="text-light">Invoice Preview</h4>

        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <section class="invoice">


                    @php
                    $total_qty = 0;
                    $total_amount = 0;
                    // Calculate totals
                    foreach ($sales as $sale) {
                    $total_qty += $sale->qty;
                    $total_amount += $sale->amount;
                    }
                    $amount_in_words = function_exists('indianCurrency') ? indianCurrency($total_amount) : 'Amount in Words Placeholder';
                    @endphp

                    <div class="invoice-container">
                        <header class="invoice-header">
                            <div class="header-left">
                                <p><strong>Invoice No. {{ $invoice->invoice_no ?? (1000 + $invoice->id) }}</strong></p>
                                <p>Ref. No. {{ $invoice->ref_no ?? '' }}</p>
                            </div>
                            <div class="header-right">
                                <p>Dated <strong>{{ $invoice->created_at->format('d-M-y') }}</strong></p>
                            </div>
                        </header>
                        <section class="invoice-details-center">
                            <h3>{{ $invoice->customer->name ?? 'Company Name' }} ( 2024 - 2025 ) GA</h3>
                            <p>State Name : {{$invoice->customer->city->state->name}}, Code : {{ $invoice->customer->name ?? '07' }}</p>
                            <h1>INVOICE(Page 4)</h1>
                        </section>

                        <section class="party-info">
                            <p>Party : {{ $invoice->customer->name ?? 'MRP MB' }}</p>
                            <div class="state-details">
                                <p>State Name : {{ $invoice->customer->state_name ?? 'Delhi' }}, Code : {{ $invoice->customer->state_code ?? '07' }}</p>
                            </div>
                        </section>

                        <table class="invoice-table">
                            <thead>
                                <tr>
                                    <th>Sl No.</th>
                                    <th>Description of Goods</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>per</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sales as $index => $sale)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $sale->product->name ?? 'N/A' }}</td>
                                    <td>{{ $sale->qty }} PCS</td>
                                    <td>{{ number_format($sale->price, 2) }}</td>
                                    <td>PCS</td>
                                    <td class="item-amount">{{ number_format($sale->amount, 2) }}</td>
                                </tr>
                                @endforeach

                                {{-- Spacer row only if the number of items is low --}}
                                @if(count($sales) < 10)
                                    <tr>
                                    <td class="spacer-row-content"></td>
                                    <td class="spacer-row-content"></td>
                                    <td class="spacer-row-content"></td>
                                    <td class="spacer-row-content"></td>
                                    <td class="spacer-row-content"></td>
                                    <td class="spacer-row-content"></td>
                                    </tr>
                                    @endif
                            </tbody>
                        </table>

                        <div class="invoice-totals">
                            <div style="width: 50%;"></div>
                            <div class="totals-area">
                                <p>Total</p>
                                <p>{{ $total_qty }} PCS</p>
                                <p>₹ {{ number_format($total_amount, 2) }}</p>
                            </div>
                        </div>
                        <p class="e-o-e">E. & O.E</p>

                        <section class="amount-in-words">
                            <p>Amount Chargeable (in words)</p>
                            <p>INR {{ convertNumberToWords($total_amount)  }} Only</p>
                        </section>

                        <footer class="invoice-footer">
                            <div class="declaration">
                                <p>Declaration</p>
                                <p>We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</p>
                            </div>
                            <div class="signature">
                                <p>for {{ $invoice->customer->name ?? 'Company Name' }} ( 2024 - 2025 ) GA</p>
                                <p class="auth-signatory">Authorised Signatory</p>
                            </div>
                        </footer>
                        <p class="computer-generated">This is a Computer Generated Invoice</p>
                    </div>
                    <div class="row  mt-4 d-print-none">
                        <div class="col-12 " style="text-align:center;">
                            <a class="btn btn-primary" href="javascript:void(0);" onclick="printInvoice();"><i class="fa fa-print"></i> Print</a>
                            <a class="btn btn-success" href="{{ route('invoice.download', $invoice->id) }}"><i class="fa fa-download"></i> Download PDF</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
    function printInvoice() {
        window.print();
    }
</script>
@endsection