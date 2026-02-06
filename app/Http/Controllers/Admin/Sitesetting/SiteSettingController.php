<?php

namespace App\Http\Controllers\Admin\Sitesetting;

use \App\Models\Sitesetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;

class SiteSettingController extends Controller
{
    public function create()
    {
        $sitesetting = Sitesetting::first();
        return view('Admin.SiteSetting.create', compact('sitesetting'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'url'              => 'required|url|max:255',
            'contact'          => 'required|string|max:20',
            'email'            => 'required|email|max:255',
            'address'          => 'required|string|max:500',
            'color'            => 'nullable|string|max:7',
            'background_color'  => 'nullable|string|max:7',
            'footer_text'      => 'nullable|string|max:255',
            'logo'             => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
            'favicon'          => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',
            'background_image' => 'nullable|mimes:jpg,jpeg,png,gif,webp,bmp,svg,tiff,ico,avif|max:4096',

        ]);
        $data = $request->except(['logo', 'favicon', 'background_image']);
        foreach (['logo', 'favicon', 'background_image'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('uploads/sitesetting');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                $file->move($destinationPath, $filename);
                $data[$fileKey] =  $filename;
            }
        }
        $data['status'] = $request->has('status') ? 1 : 0;
        $data['contact1'] = $request->has('contact1') ? $request->contact1 : '';
        $data['contact2'] = $request->has('contact2') ? $request->contact2 : '';
        $setting = Sitesetting::firstOrNew();
        $setting->fill($data);
        $setting->save();

        return redirect()->route('sitesetting.create')->with('success', 'Site settings saved successfully!');
    }
}
