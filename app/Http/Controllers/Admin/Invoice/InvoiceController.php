<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Sales;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('Admin.invoice.index', compact('invoices'));
    }
    public function getInvoiceAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $columns = ['id', 'name', 'created_at'];
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            if ($orderColIndex === 3) {
                $orderCol = 'id';
            }

            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');
            $query = Invoice::query();
            $recordsTotal = $query->count();
            $recordsFiltered = $query->count();

            $records = $query->orderBy($orderCol, $orderDir)
                ->offset($start)
                ->limit($length)
                ->get();

            $dataArr = [];
            foreach ($records as $data) {
                $action = '<div class="edit-delete-action float-end">
                <a href="' . route('invoice.edit', $data->id) . '" class="me-2 p-2 text-success">
                    <i data-feather="edit" class="feather-edit"></i>
                </a>
                <a href="' . route('invoice.show', $data->id) . '" class="me-2 p-2 text-primary">
                    <i data-feather="eye" class="feather-eye"></i>
                </a>
                <a href="javascript:void(0);" class="p-2 text-danger remove-item-btn" data-id="' . $data->id . '">
                    <i data-feather="trash-2" class="feather-trash-2"></i>
                </a>
            </div>';

                $dataArr[] = [
                    'id'             => $data->id,
                    'name'             => $data->customer->name ?? 'N/A',
                    'created_at'    => $data->created_at->format('Y-m-d'),
                    'action'         => $action,
                ];
            }

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $dataArr,
            ]);
        }
    }
    // ... other functions
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '!=', 0)->orderBy('id', 'DESC')->get();
        return view('Admin.invoice.create', compact('customers', 'products'));
    }
    public function checkStock(Request $request)
    {
        $productId = $request->id;

        $stock = Stock::where('product_id', $productId)->first();
        $product = DB::table('products')
            ->select('sellprice')
            ->where('id', $productId)
            ->first();

        // If no price found
        $sellprice = $product->sellprice ?? 0;

        // Out of stock condition
        if (!$stock || $stock->total_stock == null || $stock->total_stock == 0) {
            return response()->json([
                'status' => false,
                'stock'  => 0,
                'sellprice' => $sellprice,
                'message' => 'Out of Stock'
            ]);
        }

        // In stock response
        return response()->json([
            'status' => true,
            'stock'  => $stock->total_stock,
            'sellprice' => $sellprice
        ]);
    }

    // public function findPrice(Request $request)
    // {
    //     $data = DB::table('products')->select('sellprice')->where('id', $request->id)->first();
    //     return response()->json($data);
    // }

    public function store(Request $request)
    {

        $request->validate([
            'customer_id'  => 'required|exists:customers,id',
            'product_id'   => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'qty.*'        => 'required|numeric|min:1',
            'price.*'      => 'required|numeric|min:0',
            'amount.*'     => 'required|numeric|min:0',
            'dis.*'        => 'nullable|numeric|min:0',
        ], [
            'customer_id.required' => 'Please select a customer before submitting.',
            'product_id.min'       => 'The invoice must contain at least one product item.',
            'price.*.required'       => 'Product price field is required.',
            'qty.*.min'            => 'Quantity must be greater than 0 for all items.',
        ]);

        $invoice = new Invoice();
        $invoice->customer_id = $request->customer_id;
        $invoice->total = 1000;
        $invoice->save();

        foreach ($request->product_id as $key => $product_id) {

            $sale = new Sale();
            $sale->qty = $request->qty[$key];
            $sale->price = $request->price[$key];
            $sale->dis = $request->dis[$key] ?? null;
            $sale->amount = $request->amount[$key];
            $sale->product_id = $product_id;
            $sale->invoice_id = $invoice->id;
            $sale->save();

            // Fetch product
            $product = Product::find($product_id);
            $product_stock = Stock::where('product_id', $product_id)->first();

            if ($product) {
                $product->stock -= $request->qty[$key];
                $product->save();
            }
            if ($product_stock) {
                $product_stock->total_stock -= $request->qty[$key];
                $product_stock->save();
            }
        }

        return redirect('invoice/' . $invoice->id)->with('message', 'Invoice created Successfully');
    }



    public function downloadInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $sales = Sale::where('invoice_id', $id)->get();

        $pdf = PDF::loadView('Admin.invoice.pdf', compact('invoice', 'sales'))->setPaper('A4', 'portrait');
        return $pdf->download('Invoice-' . $invoice->id . '.pdf');
        // $pdf = PDF::loadView('Admin.invoice.pdftest', compact('invoice', 'sales'))->setPaper('A4', 'portrait');
        // return view('Admin.invoice.pdftest', compact('invoice', 'sales'));
    }
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $sales = Sale::where('invoice_id', $id)->get();
        return view('Admin.invoice.show', compact('invoice', 'sales'));
    }
    //     public function print($id)
    // {
    //     $invoice = Invoice::with(['customer'])->findOrFail($id);
    //      $sales = Sale::where('invoice_id', $id)->get();

    //     return view('Admin.invoice.print', compact('invoice', 'sales'));
    // }

    public function edit($id)
    {
        $customers = Customer::all();
        $products = Product::orderBy('id', 'DESC')->get();
        $invoice = Invoice::findOrFail($id);
        $sales = Sale::where('invoice_id', $id)->get();
        return view('Admin.invoice.edit', compact('customers', 'products', 'invoice', 'sales'));
    }
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'customer_id' => 'required',
        //     'product_id' => 'required',
        //     'qty' => 'required',
        //     'price' => 'required',
        //     'dis' => 'nullable',
        //     'amount' => 'required',
        // ]);
          $request->validate([
            'customer_id'  => 'required|exists:customers,id',
            'product_id'   => 'required|array|min:1',
            'product_id.*' => 'required|exists:products,id',
            'qty.*'        => 'required|numeric|min:1',
            'price.*'      => 'required|numeric|min:0',
            'amount.*'     => 'required|numeric|min:0',
            'dis.*'        => 'nullable|numeric|min:0',
        ], [
            'customer_id.required' => 'Please select a customer before submitting.',
            'product_id.min'       => 'The invoice must contain at least one product item.',
            'price.*.required'       => 'Product price field is required.',
            'qty.*.min'            => 'Quantity must be greater than 0 for all items.',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->customer_id = $request->customer_id;
        $invoice->total = 1000;
        $invoice->save();
        $oldSales = Sale::where('invoice_id', $id)->get();

        foreach ($oldSales as $old) {

            $product = Product::find($old->product_id);
            if ($product) {
                $product->stock += $old->qty;
                $product->save();
            }

            $product_stock = Stock::where('product_id', $old->product_id)->first();
            if ($product_stock) {
                $product_stock->total_stock += $old->qty;
                $product_stock->save();
            }
        }

        Sale::where('invoice_id', $id)->delete();

        foreach ($request->product_id as $key => $product_id) {

            $sale = new Sale();
            $sale->qty = $request->qty[$key];
            $sale->price = $request->price[$key];
            $sale->dis = $request->dis[$key] ?? null;
            $sale->amount = $request->amount[$key];
            $sale->product_id = $product_id;
            $sale->invoice_id = $invoice->id;
            $sale->save();

            // Decrement product stock
            $product = Product::find($product_id);
            if ($product) {
                $product->stock -= $request->qty[$key];
                $product->save();
            }

            // Decrement total stock
            $product_stock = Stock::where('product_id', $product_id)->first();
            if ($product_stock) {
                $product_stock->total_stock -= $request->qty[$key];
                $product_stock->save();
            }
        }

        return redirect('invoice/' . $invoice->id)->with('message', 'Invoice updated Successfully');
    }


    public function destroy($id)
    {
        Sales::where('invoice_id', $id)->delete();
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->back();
    }
}
