<?php

namespace App\Http\Controllers\Admin\Homes;

use \App\Models\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Supplier;
use App\Models\Invoice;
use App\Models\Stock;
use Carbon\Carbon;

class HomesController extends Controller
{
public function index()
{
    // --- 1. Key Performance Indicators (KPIs) ---
    // Efficiently retrieve total counts
    $totalProducts  = Product::count();
    $totalSales     = Sale::count();
    $totalSuppliers = Supplier::count();
    $totalInvoices  = Invoice::count();

    // --- 2. Monthly Sales (Revenue Trend) ---
    // Use Eloquent and DB facade for aggregation
    $monthlySalesRaw = Sale::selectRaw('SUM(amount) as total_amount, MONTH(created_at) as month_num')
        ->whereYear('created_at', Carbon::now()->year) // Filter for the current year (optional but recommended for charts)
        ->groupBy('month_num')
        ->orderBy('month_num')
        ->get();

    $monthlySales = $monthlySalesRaw->map(function ($sale) {
        // Use Carbon for reliable month name formatting
        return [
            'month'        => Carbon::createFromDate(null, $sale->month_num, 1)->format('F'),
            'total_amount' => (int) $sale->total_amount,
        ];
    })->toArray();

    // --- 3. Top 5 Products by Sales Revenue ---
    // OPTIMIZATION: Use a JOIN to fetch product name directly, avoiding the N+1 problem loop.
    $topSales = Sale::select('product_id', DB::raw('SUM(sales.amount) as total_sales'), 'products.name as productName')
        ->join('products', 'sales.product_id', '=', 'products.id') // Assuming 'products' table and 'id' column
        ->groupBy('product_id', 'products.name') // Group by both ID and Name to be SQL compliant
        ->orderByDesc('total_sales')
        ->take(5)
        ->get();

    // Convert to the desired format (already done by the select/join, just formatting the collection)
    $formattedTopSales = $topSales->map(function ($sale) {
        return [
            'productName' => $sale->productName,
            'totalSales'  => (float) $sale->total_sales, // Use float/decimal for monetary values
        ];
    })->toArray();


    // --- 4. Daily & Weekly Sales Comparisons ---
    $todaySales     = Sale::whereDate('created_at', Carbon::today())->sum('amount');
    $yesterdaySales = Sale::whereDate('created_at', Carbon::yesterday())->sum('amount');

    $thisWeekSales = Sale::whereBetween('created_at', [
        Carbon::now()->startOfWeek(),
        Carbon::now()->endOfWeek(),
    ])->sum('amount');

    $lastWeekSales = Sale::whereBetween('created_at', [
        Carbon::now()->subWeek()->startOfWeek(),
        Carbon::now()->subWeek()->endOfWeek(),
    ])->sum('amount');


    // --- 5. Stock Information ---
    // OPTIMIZATION: Eager load product to prevent N+1 issue if product name is accessed later in the view.
    $outOfStockProducts = Stock::with('product')
        ->where('total_stock', '<=', 0) // Check for 0 or less, just in case
        ->get();

    $outOfStockCount = $outOfStockProducts->count();

    // --- 6. Return View ---
    return view('Admin.Dashboard.index', compact(
        'monthlySales',
        'formattedTopSales',
        'totalProducts',
        'totalSales',
        'totalSuppliers',
        'totalInvoices',
        'todaySales',
        'yesterdaySales',
        'thisWeekSales',
        'lastWeekSales',
        'outOfStockCount',
        'outOfStockProducts'
    ));
}


    // public function StockgetAjax(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $draw = intval($request->input('draw'));
    //         $start = intval($request->input('start'));
    //         $length = intval($request->input('length'));
    //         $orderColIndex = intval($request->input('order.0.column'));
    //         $orderCol = $columns[$orderColIndex] ?? 'id';
    //         $orderDir = $request->input('order.0.dir') ?? 'asc';
    //         $searchValue = $request->input('search.value');
    //         $stockFilter = $request->input('stock_filter');
    //         $statusFilter = $request->input('status_filter');

    //         $recordsTotal = Product::count();
    //         $records = Product::with('category')
    //         ->when($stockFilter, function($q) use ($stockFilter) {
    //             if ($stockFilter == 'out') {
    //                 $q->whereRaw('(products.stock - IFNULL((SELECT SUM(quantity) FROM order_items WHERE order_items.product_id = products.id),0)) = 0');
    //             } elseif ($stockFilter == 'low') {
    //                 $q->whereRaw('(products.stock - IFNULL((SELECT SUM(quantity) FROM order_items WHERE order_items.product_id = products.id),0)) BETWEEN 1 AND 4');
    //             } elseif ($stockFilter == 'medium') {
    //                 $q->whereRaw('(products.stock - IFNULL((SELECT SUM(quantity) FROM order_items WHERE order_items.product_id = products.id),0)) BETWEEN 5 AND 20');
    //             } elseif ($stockFilter == 'high') {
    //                 $q->whereRaw('(products.stock - IFNULL((SELECT SUM(quantity) FROM order_items WHERE order_items.product_id = products.id),0)) > 20');
    //             }
    //         });

    //         if (!empty($searchValue)) {
    //             $records->where(function ($q) use ($searchValue) {
    //                 $q->where('products.name', 'like', "%{$searchValue}%")
    //                     ->orWhere('products.id', 'like', "%{$searchValue}%");
    //             });
    //         }
    //        if (isset($statusFilter)) {
    //             if ($statusFilter == '1') { 
    //                 $records->where('products.status', 1);
    //             } elseif ($statusFilter == '0') { 
    //                 $records->where('products.status', 0);
    //             }
    //         }

    //         $recordsFiltered = $records->count();
    //         $record = $records->select('products.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
    //         $dataArr = [];
    //         $key = 0;


    //         foreach ($record as $key => $data) {
    //             $url = '';
    //             if (!empty($data->image) && File::exists(public_path('uploads/products/thumbnails/' . $data->image))) {
    //                 $url = url('public/uploads/products/thumbnails/' . $data->image);
    //             }
    //             $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
    //             $image = !empty($url) ? '<div class="d-flex align-items-center">
    //                         <a href="javascript:void(0);" class="avatar avatar-md me-2">
    //                             <img src="' . $url . '" alt="' . $data->name . ' Category" ">
    //                         </a>
    //                     </div>' : '';

    //               $orderedQty = DB::table('order_items')->where('product_id', $data->id)->sum('quantity');
    //               $dataArr[$key]['image'] = $image;
    //               $dataArr[$key]['name'] = !empty($data->name) ? $data->name : '';

    //             $dataArr[$key]['stock'] = !empty($data->stock)? max(0, $data->stock - $orderedQty): 0;
    //             $remainingStock = $dataArr[$key]['stock'];
    //             if ($remainingStock == 0) {
    //             $dataArr[$key]['stock_status'] = '<a href="javascript:void(0);" class="badge bg-danger fw-medium fs-10">Out of Stock</a>';
    //             } elseif ($remainingStock <= 4) {
    //                 $dataArr[$key]['stock_status'] = '<a href="javascript:void(0);" class="badge bg-warning text-dark fw-medium fs-10">Low Stock</a>';
    //             } elseif ($remainingStock <= 20) {
    //                 $dataArr[$key]['stock_status'] = '<a href="javascript:void(0);" class="badge bg-info text-dark fw-medium fs-10">Medium Stock</a>';
    //             } else {
    //                 $dataArr[$key]['stock_status'] = '<a href="javascript:void(0);" class="badge bg-success fw-medium fs-10">High Stock</a>';
    //             }


    //             if ($data->status == true) {
    //                 $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
    //                         class="badge bg-success fw-medium fs-10 status-toggle-btn" 
    //                         data-id="' . $data->id . '" 
    //                         data-current-status="' . $data->status . '" 
    //                         data-next-status="0"> Active</a>';
    //             } else {
    //                 $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
    //                         class="badge bg-danger fw-medium fs-10 status-toggle-btn" 
    //                         data-id="' . $data->id . '" 
    //                         data-current-status="' . $data->status . '" 
    //                         data-next-status="1"> Inactive</a>';
    //             }
    //             $action = '';
    //             $action .= '<div class="edit-delete-action float-end">
    //                         <a href="' . route('product.edit', $data->id) . '" class="me-2 p-2 text-success">
    //                             <i data-feather="edit" class="feather-edit"></i>
    //                         </a>
    //                         <a href="javascript:void(0);" class="p-2 text-danger remove-item-btn" data-id="' . $data->id . '">
    //                             <i data-feather="trash-2" class="feather-trash-2"></i>
    //                         </a>
    //                     </div>';
    //             $dataArr[$key]['action'] = $action;
    //             $key++;
    //         }

    //         return response()->json([
    //             'draw' => $draw,
    //             'recordsTotal' => $recordsTotal,
    //             'recordsFiltered' => $recordsFiltered,
    //             'data' => $dataArr,
    //         ]);
    //     }
    // }

    //   public function sendmail(Request $request)
    //     {

    //         $data = $request->validate([
    //             'email' => 'required|email',
    //             'phone' => 'required',
    //             'number_of_employee_v1' => 'required',
    //         ]);

    //         Mail::to($data['email'])->send(new ContactMail($data));

    //         return back()->with('success', 'Message sent successfully!');
    //     }


}
