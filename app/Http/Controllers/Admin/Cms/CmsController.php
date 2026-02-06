<?php

namespace App\Http\Controllers\Admin\Cms;

use \App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class CmsController extends Controller
{

    public function index()
    {
        $metatitle = "Cms";
        $cms = Cms::all();
        return view('Admin.Cms.index', compact('metatitle', 'cms'));
    }
    
    public function getcmsAjax(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');
            $recordsTotal = Cms::count();
            $records = Cms::whereIn('status', [0, 1]);

            // Global search
            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('cms_pages.title', 'like', "%{$searchValue}%")
                        ->orWhere('cms_pages.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('cms_pages.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
             

                $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
              
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
                            <a href="' . route('cms.edit', $data->id) . '" class="me-2 p-2 text-success">
                                <i data-feather="edit" class="feather-edit"></i>
                            </a>
                           <!-- <a href="javascript:void(0);" class="p-2 text-danger remove-item-btn" data-id="' . $data->id . '">
                                <i data-feather="trash-2" class="feather-trash-2"></i>
                            </a>-->
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
            $cms = Cms::findOrFail($id);
            $cms->status = $request->status;
            $cms->save();

            return response()->json([
                'success' => true,
                'message' => 'cms status updated successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed for cms ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update cms status.'
            ], 500);
        }
    }

    public function create()
    {
        return view('Admin.Cms.create');
    }



public function store(Request $request)
{
    $request->validate([
        'title'   => 'required|string|max:255',
        'content' => 'nullable|string',
    ]);
    $slug = Str::slug($request->title);
    $originalSlug = $slug;
    $count = 1;
    while (Cms::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $count++;
    }
    $cms = new Cms();
    $cms->title   = $request->title;
    $cms->slug    = $slug;
    $cms->content = $request->content;
    $cms->status  = 1;
    $cms->save();

    return redirect()->route('cms')->with('success', 'Page created successfully.');
}


    public function edit($id)
    {
        $cms = Cms::findOrFail($id);
        return view('Admin.Cms.edit', compact('cms'));
    }

public function update(Request $request)
{
    $request->validate([
        'id'      => 'required|integer|exists:cms_pages,id',
        'title'   => 'required|string|max:255',
        // 'slug'    => 'required|string|unique:cms_pages,slug,' . $request->id, // ignore same record
        'content' => 'nullable|string',
        'status' => 'nullable',
    ]);
    $cms = Cms::findOrFail($request->id);

    $cms->update($request->only(['title', 'content','status']));

    return redirect()->route('cms')->with('success', 'Cms updated successfully!');
}


    public function destroy(Request $request, $id)
    {
        $product = Cms::find($id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Cms not found'], 404);
        }      
        $product->delete();
        return response()->json(['status' => 'success', 'message' => 'Cms deleted successfully']);
    }
}
