{{-- resources/views/invoice/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_no ?? '1029' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Times New Roman', serif;
            font-size: 10pt;
            margin: 15mm;
            padding: 0;
            background: #fff;
            color: #000;
        }
        .container { width: 100%; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 5px 8px; font-size: 9.5pt; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }

        /* Header */
        .header-table td { padding: 3px 0; font-size: 11pt; }

        /* Table */
        .invoice-table { border: 1px solid #000; margin: 15px 0; }
        .invoice-table th { background: #f0f0f0; border: 1px solid #000; }
        .invoice-table td { border-left: 1px solid #000; border-right: 1px solid #000; }

        /* Totals */
        .totals-row { border-top: 2px solid #000; font-weight: bold; font-size: 11pt; }
        .amount-words { border-bottom: 1px solid #000; padding: 8px 0; margin: 15px 0; }

        /* Footer */
        .footer { margin-top: 40px; display: flex; justify-content: space-between; font-size: 10pt; }
        .signature { text-align: right; }
        .auth-sign { border-top: 1px solid #000; width: 250px; display: inline-block; margin-top: 50px; padding-top: 5px; }

        @media print {
            body { margin: 10mm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

@php
    $total_qty = $sales->sum('qty');
    $total_amount = $sales->sum('amount');
    $amount_in_words = function_exists('indianCurrency') 
        ? indianCurrency($total_amount) 
        : (function_exists('convertNumberToWords') 
            ? ucwords(convertNumberToWords($total_amount)) . ' Rupees Only' 
            : 'Nineteen Thousand Six Hundred Sixty One Rupees Only');
@endphp

<div class="container">

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="40%"><strong>Invoice No:</strong> {{ $invoice->invoice_no ?? '1029' }}</td>
            <td width="30%" class="text-center bold" style="font-size:13pt;">
                {{ $invoice->customer->name ?? 'KRISHNA SPARE' }} (2024 - 2025) GA
            </td>
            <td width="30%" class="text-right">
                <strong>Dated:</strong> {{ $invoice->created_at->format('d-M-Y') }}<br>
                Ref. No: {{ $invoice->ref_no ?? '-' }}
            </td>
        </tr>
    </table>

    <hr style="border: 1px solid #000; margin: 10px 0;">

    <table style="margin-bottom: 10px;">
        <tr>
            <td><strong>Party:</strong> {{ $invoice->customer->name ?? 'Customer' }}</td>
            <td class="text-right">State: Delhi, Code: 07</td>
        </tr>
    </table>

    <!-- Items -->
    <table class="invoice-table">
        <thead>
            <tr>
                <th width="5%">SL</th>
                <th width="45%">Description of Goods</th>
                <th width="10%">Quantity</th>
                <th width="12%">Rate</th>
                <th width="8%">Per</th>
                <th width="20%">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $i => $sale)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $sale->product->name }}</td>
                <td class="text-center">{{ $sale->qty }} PCS</td>
                <td class="text-right">{{ number_format($sale->price, 2) }}</td>
                <td class="text-center">PCS</td>
                <td class="text-right bold">{{ number_format($sale->amount, 2) }}</td>
            </tr>
            @endforeach
            @for($i = $sales->count(); $i < 12; $i++)
            <tr><td colspan="6" style="height: 35px;">&nbsp;</td></tr>
            @endfor
        </tbody>
    </table>

    <!-- Total -->
    <table class="invoice-table">
        <tr class="totals-row">
            <td colspan="2"><strong>Total</strong></td>
            <td class="text-center bold">{{ $total_qty }} PCS</td>
            <td colspan="2"></td>
            <td class="text-right bold">₹ {{ number_format($total_amount, 2) }}</td>
        </tr>
    </table>

    <div class="text-right" style="font-style:italic; margin:5px 0;">E. & O.E.</div>

    <div class="amount-words">
        <div>Amount Chargeable (in words)</div>
        <div class="bold" style="font-size:11pt;">INR {{ $amount_in_words }}</div>
    </div>

    <div class="footer">
        <div>
            <strong>Declaration</strong><br>
            We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.
        </div>
        <div class="signature">
            for <strong>{{ $invoice->customer->name ?? 'Company' }}</strong> (2024 - 2025) GA<br>
            <span class="auth-sign">Authorised Signatory</span>
        </div>
    </div>

    <div class="text-center" style="margin-top:30px; font-size:9pt;">
        This is a Computer Generated Invoice
    </div>

</div>

</body>
</html>