<?php

namespace App\Http\Controllers\Admin\SubCategory;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SubCategoryController extends Controller
{

    public function subcatindex()
    {
        $metatitle = "Category";
        $subcategorys = Subcategory::with('category')->where('status', '=', 1)->get();



        return view('Admin.SubCategory.index', compact('metatitle', 'subcategorys'));
    }

    public function getSubcategoriesAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');

            $recordsTotal = Subcategory::count();
            $records = Subcategory::with('category')->whereIn('status', [0, 1]);

            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('subcategories.name', 'like', "%{$searchValue}%")
                        ->orWhere('subcategories.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('subcategories.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
                $url = '';
                if (!empty($data->image) && File::exists(public_path('uploads/subcategorys/' . $data->image))) {
                    $url = url('public/uploads/subcategorys/thumbnails/' . $data->image);
                }
                $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
                $image = !empty($url) ? '<div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                <img src="' . $url . '" alt="' . $data->name . ' Category" ">
                            </a>
                        </div>' : '';

                $dataArr[$key]['image'] = $image;
                $dataArr[$key]['name'] = !empty($data->name) ? $data->name : '';
                $dataArr[$key]['category'] = !empty($data->category) ? $data->category->name : '';

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
                            <a href="' . route('subcategory.edit', $data->id) . '" class="me-2 p-2 text-success">
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


    public function subcatcreate()
    {
        $categorys = Category::all();
        return view('Admin.SubCategory.create', compact('categorys'));
    }
    public function subcatstore(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
            'status'            => 'nullable|string|max:7',
            'category_id'            => 'nullable|integer|exists:categories,id',
        ]);
        $subcategory = new Subcategory();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/subcategorys');
            $thumbPath = public_path('uploads/subcategorys/thumbnails');
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
        $subcategory->fill($validated)->save();

        return redirect()->route('subcategory')->with('success', 'Site settings saved successfully!');
    }
    public function subcatedit($id)
    {

        $subcategory = Subcategory::findOrFail($id);
        $category = Category::all();

        return view('Admin.SubCategory.edit', compact('category', 'subcategory'));
    }

    public function subcatupdate(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
            'status'      => 'nullable|string|max:7',
            'category_id' => 'nullable|integer|exists:categories,id',
        ]);

        $subcategory = Subcategory::findOrFail($request->id); 
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/subcategorys/' . $subcategory->image);
            $oldThumbPath = public_path('uploads/subcategorys/thumbnails/' . $subcategory->image);
            if (!empty($subcategory->image)) {
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
            $uploadPath = public_path('uploads/subcategorys');
            $thumbPath = public_path('uploads/subcategorys/thumbnails');
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
        $subcategory->update($validated);
        return redirect()->route('subcategory')
            ->with('success', 'Subcategory updated successfully!');
    }

    public function subcatdestroy($id)
    {

        $subcategory = Subcategory::find($id);
        if (!$subcategory) {
            return redirect()->back()->with('error', 'Sub Category not found.');
        }
        if ($subcategory->image) {
            $filename = $subcategory->image;
            $basePath = 'uploads/subcategorys/';
            $thumbPath = 'uploads/subcategorys/thumbnails/';
            $originalFilePath = public_path($basePath . $filename);
            $thumbnailFilePath = public_path($thumbPath . $filename);
            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }
            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }
        $subcategory->delete();
        return redirect()->back()->with('success', 'Sub Category deleted successfully.');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|boolean']);
        try {
            $subcategory = Subcategory::findOrFail($id);
            $subcategory->status = $request->status;
            $subcategory->save();

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed for sub$subcategory ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update sub$subcategory status.'
            ], 500);
        }
    }
}
