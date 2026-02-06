<?php

namespace App\Http\Controllers\Admin\Category;

use \App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{

    public function index()
    {
        $metatitle = "Category";
        $categorys = Category::all();
        return view('Admin.Category.index', compact('metatitle', 'categorys'));
    }

    public function create()
    {
        return view('Admin.Category.create');
    }

    public function getCategoriesAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');
            $recordsTotal = Category::count();
            $records = Category::whereIn('status', [0, 1]);

            // Global search
            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('categories.name', 'like', "%{$searchValue}%")
                        ->orWhere('categories.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('categories.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
                $url = '';

                if (!empty($data->image) && File::exists(public_path('uploads/category/thumbnails/' . $data->image))) {
                    $url = url('public/uploads/category/thumbnails/' . $data->image);
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
                            <a href="' . route('category.edit', $data->id) . '" class="me-2 p-2 text-success">
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
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|boolean']);
        try {
            $category = Category::findOrFail($id);
            $category->status = $request->status;
            $category->save();

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed for category ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update category status.'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'status' => 'nullable',
        ]);

        $category = new Category();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/category');
            $thumbPath = public_path('uploads/category/thumbnails');
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
        $category->fill($validated)->save();

        return redirect()->route('category')->with('success', 'Category inserted successfully!');
    }



    public function edit($id)
    {

        $category = Category::findOrFail($id);
        return view('Admin.Category.edit', compact('category'));
    }


    public function update(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'image'  => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/category/' . $category->image);
            $oldThumbPath = public_path('uploads/category/thumbnails/' . $category->image);
            if (!empty($category->image)) {
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
            $uploadPath = public_path('uploads/category');
            $thumbPath = public_path('uploads/category/thumbnails');
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
        $category->update($validated);

        return redirect()->route('category')->with('success', 'Category updated successfully!');
    }
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->back()->with('error', 'Category not found.');
        }
        if ($category->image) {
            $filename = $category->image;
            $basePath = 'uploads/category/';
            $thumbPath = 'uploads/category/thumbnails/';
            $originalFilePath = public_path($basePath . $filename);
            $thumbnailFilePath = public_path($thumbPath . $filename);
            if (file_exists($originalFilePath)) {
                unlink($originalFilePath);
            }
            if (file_exists($thumbnailFilePath)) {
                unlink($thumbnailFilePath);
            }
        }
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully, including images.');
    }
}
