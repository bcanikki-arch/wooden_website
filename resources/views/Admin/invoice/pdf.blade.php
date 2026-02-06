<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @font-face {
            font-family: 'DejaVu Sans';
            src: url('https://cdnjs.cloudflare.com/ajax/libs/font-mfizz/2.4.1/font-mfizz.woff') format('woff');
            font-weight: normal;
            font-style: normal;
        }
    </style>
    <title>Invoice {{ 1000 + $invoice->id }}</title>
</head>

<body>

    <section class="invoice">
        <style>
          
            .invoice-container {
                width: 100%;
                margin: 0 auto;
                padding: 15px;
                background-color: white;
                font-family: 'DejaVu Sans', 'Times New Roman', serif; 
                font-size: 10pt;
            }
            
            .invoice-header, .party-info {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
                line-height: 1.2;
            }

             .refno p {
                font-size: 10pt;
                margin: 0;
            }
          .invoicenoanddate p {
                font-size: 10pt;
                margin: 0;
            }
            .invoicenoanddate
            {
                display: flex;
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
                text-align: center;
            }

            .party-info p {
                font-size: 10pt;
                margin: 0;
            }

            .state-details {
                /* border-left: 1px solid black; */
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
            .invoice-table th:first-child, .invoice-table tbody td:first-child { width: 5%; text-align: center; }
            .invoice-table th:nth-child(2), .invoice-table tbody td:nth-child(2) { width: 45%; } 
            .invoice-table th:nth-child(3), .invoice-table tbody td:nth-child(3) { width: 10%; text-align: center; }
            .invoice-table th:nth-child(4), .invoice-table tbody td:nth-child(4) { width: 10%; text-align: right; }
            .invoice-table th:nth-child(5), .invoice-table tbody td:nth-child(5) { width: 5%; text-align: center; }
            .invoice-table th:nth-child(6), .invoice-table tbody td:nth-child(6) { width: 25%; text-align: right; font-weight: bold; }


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
            }
            .invoice-totals {
                border: none;
                padding: 0;
                margin: 0;
                width: 100%;
            }

            .total-row-table {
                width: 100%;
                border-collapse: collapse;
                border-top: 1pt solid black; 
                border-bottom: 1pt solid black;
            }

            .total-row-table td {
                padding: 5pt 5px;
                font-weight: bold;
                font-size: 10pt;
                height: 30pt;
                vertical-align: middle;
                border: none;
            }

            /* Column 1: Total Label (50% width) */
            .total-row-table td:first-child { 
                width: 50%;
                text-align: left;
                border-left: 1pt solid black;
            }

            /* Column 2: Total Quantity (10% width) */
            .total-row-table td:nth-child(2) { 
                width: 10%;
                text-align: center;
                border-left: 1pt solid black;
            }

            /* Column 3: Total Amount (40% width) */
            .total-row-table td:last-child {
                width: 40%;
                text-align: right;
                border-left: 1pt solid black;
                border-right: 1pt solid black;
            }


            /* Fix for the E. & O.E. text */
            .e-o-e {
                text-align: right;
                font-size: 8pt;
                margin: 5pt 0 5pt 0;
                padding-right: 10pt;
                font-style: italic;
                font-weight: normal;
            }


            /* --- Footer Styles --- */
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
                /* margin-top: 15px; */
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
                /* width: 50%; */
                text-align: right;
            }
            
            .signature p {
                margin: 0;
            }

            .auth-signatory {
                border-top: 1px solid black;
                /* margin-top: 40px !important; */
                /* padding-top: 2px !important; */
                font-size: 9pt !important;
            }

          

            /* Hide app components during printing */
            @media print {
                .app-header, .app-sidebar, .app-breadcrumb, .d-print-none {
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
                    width: 100%;
                }
            }
            /* --- End Custom CSS --- */
        </style>

        @php
                $set=setting();
            $total_qty = 0;
            $total_amount = 0;
            foreach ($sales as $sale) {
                $total_qty += $sale->qty;
                $total_amount += $sale->amount;
            }
            $amount_in_words = function_exists('indianCurrency') ? indianCurrency($total_amount) : 'Five Thousand Eighty-Six Rupees and Ninety-Five Paise'; // Placeholder text added for testing
        @endphp

        <div class="invoice-container">
            <div class="invoice-header ">            
                <div class="invoicenoanddate">
                    <p><strong>Invoice No. {{ $invoice->invoice_no ?? (1000 + $invoice->id) }}</strong></p>
                    <p style="text-align: right;padding-top:0px;">Dated <strong>{{ $invoice->created_at->format('d-M-y') }}</strong></p>
                </div>
                <div class="refno ">
                    <p>Ref. No. {{ $invoice->ref_no ?? '' }}</p>
                </div>
            </div>

            <section class="invoice-details-center">
                <h3>
                    {{ $set['name'] ?? 'MRP MB' }} ( 2024 - 2025 ) GA</h3>
                <p>State Name : Delhi, Code : 07</p>
                <!-- <h1>INVOICE(Page 4)</h1> -->
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
                        <th>SL No.</th>
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
                    @if(count($sales) < 6)
                   <tr>
                    <td  class="spacer-row-content"></td>
                    <td  class="spacer-row-content"></td>
                    <td  class="spacer-row-content"></td>
                    <td  class="spacer-row-content"></td>
                    <td  class="spacer-row-content"></td>
                    <td  class="spacer-row-content"></td>
                </tr>
                    @endif
                </tbody>
            </table>
            <table class="total-row-table">
                <tr>
                    <td>Total</td>
                    
                    <td>{{ $total_qty }} PCS</td>
                    <td>₹ {{ number_format($total_amount, 2) }}</td>
                </tr>
            </table>
            
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
                <div class="signature ">
                    <p>for {{ $set['name'] ?? 'MRP MB' }} ( 2024 - 2025 ) GA</p>
                    <p class="auth-signatory">Authorised Signatory</p>
                </div>
            </footer>
        </div>
        
    </section>

</body>
</html>