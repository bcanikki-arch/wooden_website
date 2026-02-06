<?php

namespace App\Http\Controllers\Admin\Service;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\ProductType;
use App\Models\Brand;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{

    public function index()
    {
        $metatitle = "Product";
        $services = Service::paginate(20);
        return view('Admin.Service.index', compact('metatitle', 'services'));
    }

    public function create()
    {

        $categories = Category::all();
        // $subcategories = Subcategory::all();
        // $producttypes = ProductType::all();
        // $brands = Brand::all();
        return view('Admin.Product.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'     => 'required|integer|exists:categories,id',
            'name'            => 'required|string|max:255',
            'description'     => 'nullable',
            'status' => 'required|in:1,2',
            'image'           => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
        ]);

        $validated['sku'] = 'SKU-' . date('Ymd') . '-' . strtoupper(Str::random(4)) . '-' . $this->generateUniqueSku($request->name);
        $product = new Product();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $uploadPath = public_path('uploads/products');
            $thumbPath = public_path('uploads/products/thumbnails');
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
        $validated['status'] = $request->input('status', 2);

        $product->fill($validated)->save();


        return redirect()->route('product')->with('success', 'Product inserted successfully!');
    }

    // private function generateUniqueSku($name)
    // {
    //     $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
    //     $random = mt_rand(10000, 99999);
    //     $sku = $prefix . '-' . $random;
    //     while (Service::where('sku', $sku)->exists()) {
    //         $random = mt_rand(10000, 99999);
    //         $sku = $prefix . '-' . $random;
    //     }
    //     return $sku;
    // }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('Admin.Service.edit', compact('service'));
    }

    public function update(Request $request)
    {

        $validated = $request->validate([
            'id'             => 'required|integer|exists:services,id',
            // 'category'    => 'required|integer|exists:categories,id',
            'name'           => 'required|string|max:255',
            'status' => 'required|in:1,2',
            'description'    => 'nullable',
            'subdescription'    => 'nullable',
            'image'          => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
        ]);
        $service = Service::findOrFail($request->id);
        // $service->sku = $service->sku ?? $this->generateUniqueSku($request->name);
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/services/' . $service->image);
            // $oldThumbPath = public_path('uploads/services/thumbnails/' . $service->image);
            if (!empty($service->image)) {
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                // if (file_exists($oldThumbPath)) {
                //     unlink($oldThumbPath);
                // }
            }
            $uploadPath = public_path('uploads/services');
            $thumbPath = public_path('uploads/services/thumbnails');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
            // if (!file_exists($thumbPath)) mkdir($thumbPath, 0777, true);
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
        $service->update($validated);
        return redirect()->route('service')->with('success', 'Service updated successfully!');
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }
        if ($product->image) {
            $basePath  = public_path('uploads/products/' . $product->image);
            $thumbPath = public_path('uploads/products/thumbnails/' . $product->image);

            if (file_exists($basePath)) {
                unlink($basePath);
            }

            if (file_exists($thumbPath)) {
                unlink($thumbPath);
            }
        }
        Stock::where('product_id', $product->id)->delete();
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    
    
}
