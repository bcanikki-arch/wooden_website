<?php

namespace App\Http\Controllers\Admin\Product;

use \App\Models\Product;
use \App\Models\Category;
use \App\Models\Subcategory;
use \App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use \App\Models\Stock;

class ProductController extends Controller
{

    public function index()
    {
        $metatitle = "Product";
        $products = Product::all();
        $categories = Category::all();
        return view('Admin.Product.index', compact('metatitle', 'products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $producttypes = ProductType::all();
        $brands = Brand::all();
        return view('Admin.Product.create', compact('categories', 'subcategories', 'producttypes', 'brands'));
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

    private function generateUniqueSku($name)
    {
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $name), 0, 3));
        $random = mt_rand(10000, 99999);
        $sku = $prefix . '-' . $random;
        while (Product::where('sku', $sku)->exists()) {
            $random = mt_rand(10000, 99999);
            $sku = $prefix . '-' . $random;
        }
        return $sku;
    }

    public function edit($id)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $producttypes = ProductType::all();
        $product = Product::findOrFail($id);
        $brands = Brand::all();
        return view('Admin.Product.edit', compact('product', 'categories', 'subcategories', 'producttypes', 'brands'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id'             => 'required|integer|exists:products,id',
            'category_id'    => 'required|integer|exists:categories,id',
            'name'           => 'required|string|max:255',
            'status' => 'required|in:1,2',
            'description'    => 'nullable',
            'image'          => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
        ]);
        $product = Product::findOrFail($request->id);
        $product->sku = $product->sku ?? $this->generateUniqueSku($request->name);
        if ($request->hasFile('image')) {
            $oldImagePath = public_path('uploads/products/' . $product->image);
            $oldThumbPath = public_path('uploads/products/thumbnails/' . $product->image);
            if (!empty($product->image)) {
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                if (file_exists($oldThumbPath)) {
                    unlink($oldThumbPath);
                }
            }
            $uploadPath = public_path('uploads/products');
            $thumbPath = public_path('uploads/products/thumbnails');
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
        $product->update($validated);
        return redirect()->route('product')->with('success', 'Product updated successfully!');
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

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|boolean']);
        try {
            $product = Product::findOrFail($id);
            $product->status = $request->status;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Status update failed for product ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status.'
            ], 500);
        }
    }
    public function getSubcategories(Request $request)
    {
        $category_id = $request->category_id;
        $subcategories = Subcategory::where('category_id', $category_id)->where('status', 1)->get(['id', 'name']);
        return response()->json($subcategories);
    }
}
