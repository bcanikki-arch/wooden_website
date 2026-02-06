<?php

namespace App\Http\Controllers\Admin\ProductType;

use \App\Models\ProductType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductTypeController extends Controller
{

    public function index()
    {
        $metatitle = "Product Type";
        $producttype = ProductType::all();
        return view('Admin.ProductType.index', compact('metatitle', 'producttype'));
    }

    public function getProducttypeAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');

            $recordsTotal = ProductType::count();
            $records = ProductType::whereIn('status', [0, 1]);

            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('product_types.name', 'like', "%{$searchValue}%")
                        ->orWhere('product_types.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('product_types.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
                $url = '';

                if (!empty($data->image) && File::exists(public_path('uploads/product_type/' . $data->image))) {
                    $url = url('public/uploads/product_type/' . $data->image);
                }

                $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
                $image = !empty($url) ? '<div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                <img src="' . $url . '" alt="' . $data->name . ' Category" ">
                            </a>
                        </div>' : '';

                $dataArr[$key]['image'] = $image;
                $dataArr[$key]['name'] = !empty($data->name) ? $data->name : '';

                if ($data->status == true) {

                    $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
                            class="badge bg-success fw-medium fs-10 status-toggle-btn" 
                            data-id="' . $data->id . '" 
                            data-current-status="' . $data->status . '" 
                            data-next-status="0"> Active</a>';
                } else {

                    $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
                            class="badge bg-danger fw-medium fs-10 status-toggle-btn" 
                            data-id="' . $data->id . '" 
                            data-current-status="' . $data->status . '" 
                            data-next-status="1"> Inactive</a>';
                }

                $action = '';
                $action .= '<div class="edit-delete-action float-end">
                            <a href="' . route('producttype.edit', $data->id) . '" class="me-2 p-2 text-success">
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
        return view('Admin.ProductType.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name',
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'status' => 'nullable',
        ]);

        $productType = new ProductType();
        $productType->name = $validated['name'];
        $productType->slug = Str::slug($validated['name']);
        $productType->description = $validated['description'] ?? null;
        $productType->status = $request->has('status') ? 1 : 0;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/product_type');
            $thumbPath = public_path('uploads/product_type/thumbnails');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
            if (!file_exists($thumbPath)) mkdir($thumbPath, 0777, true);
            $originalPath = $file->move($uploadPath, $filename);
            $productType->image = $filename;
            $manager = new ImageManager(new Driver());
            $image = $manager->read($originalPath);
            $image->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($thumbPath . '/' . $filename);
        }

        $productType->save();

        return redirect()->route('producttype')->with('success', 'Product Type added successfully!');
    }
    public function edit($id)
    {

        $producttype = ProductType::findOrFail($id);

        return view('Admin.ProductType.edit', compact('producttype'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_types,name,' . $request->id,
            'description' => 'nullable|string',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'status' => 'nullable',
        ]);

        $productType = ProductType::findOrFail($request->id);
        $productType->name = $validated['name'];
        $productType->slug = Str::slug($validated['name']);
        $productType->description = $validated['description'] ?? null;
        $productType->status = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/product_type/' . $productType->image);
            $oldThumbPath = public_path('uploads/product_type/thumbnails/' . $productType->image);
            if (!empty($productType->image)) {
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
            $uploadPath = public_path('uploads/product_type');
            $thumbPath = public_path('uploads/product_type/thumbnails');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
            if (!file_exists($thumbPath)) mkdir($thumbPath, 0777, true);
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $originalPath = $file->move($uploadPath, $filename);
            $validated['image'] = $filename;
            try {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($originalPath);
                $image->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($thumbPath . '/' . $filename);
            } catch (\Exception $e) {
                \Log::error('Thumbnail generation failed: ' . $e->getMessage());
            }
        }
            $productType->update($validated);

        return redirect()->route('producttype')->with('success', 'Product Type updated successfully!');
    }

    public function destroy($id)
    {
        $Producttype = ProductType::find($id);
        if (!$Producttype) {
            return redirect()->back()->with('error', 'Produc tType not found.');
        }
        if ($Producttype->image) {
            $filename = $Producttype->image;
            $basePath = 'uploads/product_type/';
            $thumbPath = 'uploads/product_type/thumbnails/';
            $originalFilePath = public_path($basePath . $filename);
            $thumbnailFilePath = public_path($thumbPath . $filename);
            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }
            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }
        $Producttype->delete();
        return redirect()->back()->with('success', 'Product Type deleted successfully.');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|boolean']);
        try {
            $producttype = ProductType::findOrFail($id);
            $producttype->status = $request->status;
            $producttype->save();

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed for Product type ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update Product type status.'
            ], 500);
        }
    }
}
