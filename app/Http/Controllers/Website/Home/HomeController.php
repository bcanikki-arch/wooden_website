<?php

namespace App\Http\Controllers\Website\Home;

use \App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {

    //   $categories = Cache::remember('categories', 3600, function () {
    //             return Category::select('id','name')->get();
    //         });
        $products = Product::paginate(20);
        $teams = Testimonial::all();
        $categories = Category::all();


        return view('Website.home.index', compact('categories', 'products', 'teams'));
    }

    public function about()
    {
        $teams = Testimonial::inRandomOrder()->take(20)->get();
        return view('Website.about.index', compact('teams'));
    }
      public function sitemap()
    {
        // $services = Service::inRandomOrder()->whereStatus('1')->get();
        return view('Website.sitemap.index');
    }
      public function service()
    {
        $services = Service::inRandomOrder()->whereStatus('1')->get();
        return view('Website.service.index', compact('services'));
    }

    public function project()
    {
        $categories = Category::whereStatus('1')->get();
        return view('Website.project.index', compact('categories'));
    }
    public function projectgrid($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->get();
        return view('Website.project.projectgrid', compact('category', 'products'));
    }

    public function projectdetail($slug)
    {
        $products = Product::where('slug', $slug)->first();
        $product_all = Product::paginate(20);

        return view('Website.project.projectdetail', compact('products', 'product_all'));
    }

  
    public function shop(Request $request)
    {
        $subcategoryId = $request->subcategory;
        $categoryId = $request->category;
        $products = Product::query();
        if ($subcategoryId) {
            $products = $products->where('subcategory_id', $subcategoryId);
        }
        if ($categoryId) {
            $products = $products->where('category_id', $categoryId);
        }
        if ($request->producttype) {
            $products = $products->where('producttype_id', $request->producttype);
        }

        $products = $products->where('status', 1)->paginate(12);

        return view('Website.shop.index', compact('products'));
    }

    public function productDetail($id)
    {

        $product = Product::where('id', $id)->where('status', 1)->firstOrFail();
        $relatedproducts = Product::where('id', '!=', $product->id)->where('status', 1)->take(15)->get();

        return view('Website.shop.detail', compact('product', 'relatedproducts'));
    }
    public function search(Request $request)
    {
        $query = $request->query('query');
        $products = Product::where('name', 'LIKE', "%$query%")->orWhere('description', 'LIKE', "%$query%")->get();
        return view('Website.shop.search', compact('products', 'query'));
    }
    public function cart()
    {
        $user_id = Auth::id() ?? 6;
        $cart_Items = Cart::with('product')
            ->where('user_id', $user_id)
            ->get();
        return view('Website.cart.index', compact('cart_Items'));
    }
    public function contact()
    {
        return view('Website.contact.index');
    }
    public function appointment()
    {
        return view('Website.appointment.index');
    }
    public function add(Request $request)
    {
        $product = Product::find($request->product_id);

        $user_id = Auth::id() ?? 6;
        $existing = Cart::where('user_id', $user_id)->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->quantity += 1;
            $existing->subtotal = ($existing->price * $existing->quantity) + $existing->tax - $existing->discount;
            $existing->save();
        } else {

            Cart::create([
                'user_id'  => $user_id,
                'product_id' => $product->id,
                'price' => $product->sellprice,
                'quantity' => 1,
                'tax' => 0,
                'discount' => 0,
                'subtotal' => $product->sellprice,
            ]);
        }
        $cartItems = Cart::with('product')
            ->where('user_id', $user_id)
            ->get();

        $subtotal = $cartItems->sum('subtotal');
        return response()->json([
            'subtotal' => $subtotal
        ]);
    }
    public function ajaxDelete($id)
    {
        $cart = Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$cart) {
            return response()->json(['status' => 'error', 'message' => 'Not found']);
        }

        $cart->delete();

        $newCount = Cart::where('user_id', Auth::id())->count();

        $newTotal = Cart::where('user_id', Auth::id())
            ->sum(DB::raw('price * quantity'));

        return response()->json([
            'status' => 'success',
            'count' => $newCount,
            'total' => $newTotal
        ]);
    }
}
