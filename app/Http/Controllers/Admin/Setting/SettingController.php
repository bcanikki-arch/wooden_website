<?php

namespace App\Http\Controllers\Admin\Setting;

use \App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function index()
    {
        $socials = Social::all()->keyBy('label');
        return view('Admin.SocialSetting.index', compact('socials'));
    }

    public function store(Request $request)
    {
        foreach ($request->socials as $key => $social) {
            Social::updateOrCreate(
                ['label' => $social['label']], 
                [
                    'value'  => $social['value'] ?? null,
                    'status' => isset($social['status']) ? 1 : 0,
                ]
            );
        }
        return redirect()->route('social')->with('success', 'Social links updated successfully!');
    }


}
