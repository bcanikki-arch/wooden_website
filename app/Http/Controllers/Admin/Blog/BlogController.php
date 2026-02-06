<?php

namespace App\Http\Controllers\Admin\Blog;

use \App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class BlogController extends Controller
{
    public function index()
    {

        $blogs = Blog::all();
        return view('Admin.Blog.index', compact('blogs'));
    }

     public function getblogAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');
            $recordsTotal = Blog::count();
            $records = Blog::whereIn('status', [0, 1]);
            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('blogs.title', 'like', "%{$searchValue}%")
                        ->orWhere('blogs.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('blogs.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
                $url = '';

                if (!empty($data->image) && File::exists(public_path('uploads/blogs/' . $data->image))) {
                    $url = url('public/uploads/blogs/' . $data->image);
                }

                $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
                $image = !empty($url) ? '<div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                <img src="' . $url . '" alt="' . $data->title . ' blog" ">
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
                            <a href="' . route('blog.edit', $data->id) . '" class="me-2 p-2 text-success">
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
            $blog = blog::findOrFail($id);
            $blog->status = $request->status;
            $blog->save();

            return response()->json([
                'success' => true,
                'message' => 'blog status updated successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed for blog ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update blog status.'
            ], 500);
        }
    }
    public function create()
    {
        return view('Admin.Blog.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
        ]);
        // $slug = \Str::slug($request->title, '-');
        $blog = new Blog();
        $blog->title = $request->title ? $request->title : '';
        $blog->slug = Str::slug($request->title, '-');
        $blog->subtitle = $request->subtitle ? $request->subtitle : '';
        $blog->author = $request->author ? $request->author : '';
        $blog->description = $request->description  ? $request->description : '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $imageName);
            $blog->image =   $imageName;
        }

        $blog->save();

        return redirect()->route('blog')->with('success', 'Blog created successfully.');
    }
    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('Admin.Blog.edit', compact('blog'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'subtitle' => 'required',
            'author' => 'required',
            'description' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
        ]);
        $blog = Blog::find($request->id);
        $blog->title = $request->title;
        // $blog->slug = Str::slug($request->title, '-') ;
        $blog->subtitle = $request->subtitle;
        $blog->author = $request->author;
        $blog->description = $request->description;

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            $oldImagePath = public_path($blog->image);
            if (file_exists($oldImagePath) && !empty($blog->image)) {
                unlink($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/blogs'), $imageName);
            $blog->image = $imageName;
        }
        $blog->save();

        return redirect()->route('blog')->with('success', 'Blog updated successfully.');
    }
    public function destroy($id)
    {

        $blog = Blog::find($id);
        if ($blog) {
            $oldImagePath = public_path($blog->image);
            if (file_exists($oldImagePath) && !empty($blog->image)) {
                unlink($oldImagePath);
            }
            $blog->delete();
            return response()->json(['status' => 'success', 'message' => 'Blog deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Blog not found']);
        }
    }
}
