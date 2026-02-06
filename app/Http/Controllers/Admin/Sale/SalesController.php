<?php

namespace App\Http\Controllers\Admin\Sale;

// 1. **ADD THIS LINE:** Import the base Controller class from its correct namespace.
use App\Http\Controllers\Controller;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller // Now PHP knows where 'Controller' comes from
{
    public function index()
    {
        $sales = Sales::with('product')->get();
        return view('Admin.sales.index', compact('sales'));
    }
    public function getsaleAjax(Request $request)
    {
        if ($request->ajax()) {

            $draw = intval($request->input('draw'));
            $searchValue = $request->input('search.value');
            $query = Sales::with('product');
            $recordsTotal = $query->count();
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('id', 'like', "%{$searchValue}%")
                        ->orWhereHas('product', function ($q2) use ($searchValue) {
                            $q2->where('name', 'like', "%{$searchValue}%");
                        });
                });
            }

            // Filtered Count
            $recordsFiltered = $query->count();

            // Pagination
            $start  = $request->input('start');
            $length = $request->input('length');

            $sales = $query->skip($start)->take($length)->get();

            // Prepare data for datatable
            $dataArr = [];
            foreach ($sales as $key => $sale) {
                $dataArr[] = [
                    'id'  => $key + 1,
                    'name'  => $sale->product->name ?? '',
                    'qty'   => $sale->qty,
                    'price' => $sale->price,
                    'total' => $sale->amount,
                    'date'  => $sale->created_at->format('d-m-Y'),
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
}
