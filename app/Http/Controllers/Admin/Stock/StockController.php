<?php

namespace App\Http\Controllers\Admin\Stock;

use \App\Models\Stock;
use \App\Models\Category;
use \App\Models\Subcategory;
use \App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\File;



class StockController extends Controller
{

    public function index()
    {
        // $metatitle = "Stock";
        // $Stocks = Stock::all();
        return view('Admin.Stock.index');
    }

    public function getStockAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');
            $recordsTotal = Stock::count();
            $records = Stock::with('product');

            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('stocks.name', 'like', "%{$searchValue}%")
                        ->orWhere('stocks.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('stocks.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
                $url = '';

                if (!empty($data->product->image) && File::exists(public_path('uploads/products/' . $data->product->image))) {
                    $url = url('public/uploads/products/' . $data->product->image);
                }
                $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
                $image = !empty($url) ? '<div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                <img src="' . $url . '" alt="' . $data->product->name . ' Category" ">
                            </a>
                        </div>' : '';

                $dataArr[$key]['image'] = $image;
                // $dataArr[$key]['name'] = !empty($data->product->name) ? $data->product->name : '';
                $dataArr[$key]['name'] = !empty($data->product->name) ? (count($w = explode(' ', $data->product->name)) > 15 ? implode(' ', array_slice($w, 0, 15)) . '...' : $data->product->name) : '';
                $dataArr[$key]['totals'] = !empty($data->total_stock) ? $data->total_stock : '';
                $dataArr[$key]['solds'] = !empty($data->sold_stock) ? $data->sold_stock : '';
                $dataArr[$key]['res'] = !empty($data->remaining_stock) ? $data->remaining_stock : '';

                // if ($data->status == true) {
                //     $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
                //             class="badge bg-success fw-medium fs-10 status-toggle-btn" 
                //             data-id="' . $data->id . '" 
                //             data-current-status="' . $data->status . '" 
                //             data-next-status="0"> Active</a>';
                // } else {
                //     $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
                //             class="badge bg-danger fw-medium fs-10 status-toggle-btn" 
                //             data-id="' . $data->id . '" 
                //             data-current-status="' . $data->status . '" 
                //             data-next-status="1"> Inactive</a>';
                // }
                $action = '';
                $action .= '<div class="edit-delete-action float-end">
                            <a href="' . route('stock.edit', $data->id) . '" class="me-2 p-2 text-success">
                                <i data-feather="edit" class="feather-edit"></i>
                            </a>
                            <a href="javascript:void(0);" class="p-2 text-danger remove-item-btn" data-id="' . $data->id . '">
                                <i data-feather="trash-2" class="feather-trash-2"></i>
                            </a>
                        </div>';

                $dataArr[$key]['action'] = $action;
                $key++;
            }

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data' => $dataArr,
            ]);
        }
    }

    public function create()
    {
        $warehouse = Warehouse::all();
        return view('Admin.Stock.create', compact('warehouse'));
    }
    public function searchProducts(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%{$query}%")
            ->orWhere('sku', 'like', "%{$query}%")->with(['category'])->select('id', 'name', 'sku', 'category_id', 'stock', 'image')->limit(10)->get();
        $formattedProducts = $products->map(function ($product) {
            $imagePath = $product->image ? asset('public/uploads/products/' . $product->image) : asset('img/default-product.png');
            return [
                'id' => $product->id,
                'name' => $product->name,
                'sku' => $product->sku,
                'stock' => $product->stock,
                'category_name' => $product->category->name ?? 'N/A',
                'image' => $imagePath,
            ];
        });

        return response()->json(['products' => $formattedProducts]);
    }
    public function store(Request $request)
    {
        $request->validate([
            // 'warehouse' => 'required',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $items = $request->input('items');

        DB::beginTransaction();

        try {
            foreach ($items as $itemData) {
                $productId = $itemData['product_id'];
                $quantity = (int) $itemData['quantity'];
                $stock = Stock::firstOrCreate(
                    ['product_id' => $productId],
                    ['total_stock' => 0, 'sold_stock' => 0]
                );
                $stock->total_stock += $quantity;
                $stock->save();
                $product = Product::find($productId);
                if ($product) {
                    $product->stock =  $quantity;
                    // $product->stock = ($product->stock ?? 0) + $quantity;
                    $product->save();
                }
            }

            DB::commit();
            return redirect()->route('stock')->with('success', 'Stock successfully added and product updated!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to add stock. Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $stock = Stock::with('product')->findOrFail($id);

        return view('Admin.Stock.edit', compact('stock'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validate([
                'id' => 'required|exists:stocks,id',
                'items' => 'required|array',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|numeric|min:1',
            ]);
            $stock = Stock::findOrFail($validated['id']);
            foreach ($validated['items'] as $item) {
                $productId = $item['product_id'];
                $newQuantity = $item['quantity'];
                $stockItem = Stock::where('product_id', $productId)->first();

                if ($stockItem) {
                    $soldStock = $stockItem->sold_stock ?? 0;
                    $stockItem->total_stock = $newQuantity;
                    $stockItem->remaining_stock = max($newQuantity - $soldStock, 0);
                    $stockItem->save();
                } else {
                    Stock::create([
                        'product_id' => $productId,
                        'total_stock' => $newQuantity,
                        'sold_stock' => 0,
                        'remaining_stock' => $newQuantity,
                    ]);
                }
                $product = Product::find($productId);
                if ($product) {
                    $product->stock = $newQuantity;
                    $product->save();
                }
            }

            DB::commit();
            return redirect()->route('stock')->with('success', 'Stock updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

}
