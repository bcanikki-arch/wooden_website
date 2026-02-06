<?php

namespace App\Http\Controllers\Admin\Testimonial;

use \App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestimonialController extends Controller
{
    public function index()
    {

        $testimonials = Testimonial::all();
        return view('Admin.Testimonial.index', compact('testimonials'));
    }
    public function create()
    {

        return view('Admin.Testimonial.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            // 'company' => 'required',
            'message' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
        ]);

        $testimonial = new Testimonial();
        $testimonial->name = $request->name ? $request->name : '';
        $testimonial->designation = $request->designation ? $request->designation : '';
        $testimonial->company = $request->company ? $request->company : '';
        $testimonial->message = $request->message  ? $request->message : '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/testimonials'), $imageName);
            $testimonial->image = 'uploads/testimonials/' . $imageName;
        }

        $testimonial->save();

        return redirect()->route('testimonial')->with('success', 'Testimonial created successfully.');
    }
    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        return view('Admin.Testimonial.edit', compact('testimonial'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            // 'company' => 'required',
            'message' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
        ]);
        $testimonial = Testimonial::find($request->id);
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->company = $request->company;
        $testimonial->message = $request->message;
        if ($request->hasFile('image')) {
            $oldImagePath = public_path($testimonial->image);
            if (file_exists($oldImagePath) && !empty($testimonial->image)) {
                unlink($oldImagePath);
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/testimonials'), $imageName);
            $testimonial->image = 'uploads/testimonials/' . $imageName;
        }
        $testimonial->update();
        return redirect()->route('testimonial')->with('success', 'Testimonial updated successfully.');
    }
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
        if ($testimonial) {
            $oldImagePath = public_path($testimonial->image);
            if (file_exists($oldImagePath) && !empty($testimonial->image)) {
                unlink($oldImagePath);
            }
            $testimonial->delete();
            return response()->json(['status' => 'success', 'message' => 'Testimonial deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Testimonial not found']);
        }
    }
}
