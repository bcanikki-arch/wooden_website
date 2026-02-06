<?php

namespace App\Http\Controllers\Admin\Brand;

use \App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BrandController extends Controller
{

    public function index()
    {
        $metatitle = "Brand";
        $brands = Brand::all();
        return view('Admin.Brand.index', compact('metatitle', 'brands'));
    }
    public function getBrandAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');

            $recordsTotal = Brand::count();
            $records = Brand::whereIn('status', [0, 1]);

            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('brands.name', 'like', "%{$searchValue}%")
                        ->orWhere('brands.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('brands.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
                // $url = '';
                // if (File::exists(public_path($data->image))) {
                //     $url = url('/public/uploads/brand' . $data->image);
                // }
                $url = '';

                if (!empty($data->image) && File::exists(public_path('uploads/brand/thumbnails/' . $data->image))) {
                    $url = url('public/uploads/brand/thumbnails/' . $data->image);
                }

                $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
                $image = !empty($url) ? '<div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                <img src="' . $url . '" alt="' . $data->title . ' Category" ">
                            </a>
                        </div>' : '';

                $dataArr[$key]['image'] = $image;
                $dataArr[$key]['title'] = !empty($data->title) ? $data->title : '';

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
                            <a href="' . route('brand.edit', $data->id) . '" class="me-2 p-2 text-success">
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
        return view('Admin.Brand.create');
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'image'  => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
            'status' => 'nullable',
        ]);

        $brand = new Brand();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/brand');
            $thumbPath = public_path('uploads/brand/thumbnails');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
            if (!file_exists($thumbPath)) mkdir($thumbPath, 0777, true);
            $originalPath = $file->move($uploadPath, $filename);
            $validated['image'] = $filename;
            $manager = new ImageManager(new Driver());
            $image = $manager->read($originalPath);
            $image->resize(100, 100, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($thumbPath . '/' . $filename);
        }
        $validated['status'] = $request->has('status') ? 1 : 0;
        $brand->fill($validated)->save();

        return redirect()->route('brand')->with('success', 'Brand inserted successfully!');
    }



    public function edit($id)
    {

        $brand = Brand::findOrFail($id);
        return view('Admin.Brand.edit', compact('brand'));
    }

    public function update(Request $request)
    {
        $brand = Brand::findOrFail($request->id);
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'image'  => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
            'status' => 'nullable',
        ]);
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/brand/' . $brand->image);
            $oldThumbPath = public_path('uploads/brand/thumbnails/' . $brand->image);
            if (!empty($brand->image)) {
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
            $uploadPath = public_path('uploads/brand');
            $thumbPath = public_path('uploads/brand/thumbnails');
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

        $validated['status'] = $request->has('status') ? 1 : 0;
        $brand->update($validated);

        return redirect()->route('brand')->with('success', 'Brand updated successfully!');
    }



    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->back()->with('error', 'Brand not found.');
        }
        if ($brand->image) {
            $filename = $brand->image;
            $basePath = 'uploads/brand/';
            $thumbPath = 'uploads/brand/thumbnails/';
            $originalFilePath = public_path($basePath . $filename);
            $thumbnailFilePath = public_path($thumbPath . $filename);
            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }
            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }
        $brand->delete();
        return redirect()->back()->with('success', 'Brand deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|boolean']);
        try {
            $brand = Brand::findOrFail($id);
            $brand->status = $request->status;
            $brand->save();

            return response()->json([
                'success' => true,
                'message' => 'Brand status updated successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed for brand ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update brand status.'
            ], 500);
        }
    }
}
