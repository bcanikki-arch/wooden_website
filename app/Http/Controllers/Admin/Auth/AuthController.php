<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('Auth.login');
    }


    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         $request->session()->regenerate();
    //         return redirect('/admin/dashboard');
    //     }

    //     return back()->withErrors([
    //         'email' => 'The provided credentials do not match our records.',
    //     ])->onlyInput('email');
    // }
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {

        $user = Auth::user();

        if ($user->role == 1) {
            return redirect()->route('dashboard');
        }

        Auth::logout();
        return back()->withErrors(['email' => 'You are not an admin']);
    }

    return back()->withErrors(['email' => 'Invalid credentials']);
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }


    public function showRegistrationForm()
    {
        return view('Auth.register');
    }


    public function register(Request $request)
    {
        dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }

    public function showForgotPasswordForm()
    {
        return view('Auth.password_email');
    }
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        $token = Str::random(60);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = route('password.reset', ['token' => $token, 'email' => $user->email]);

        Mail::raw('Click this link to reset your password: ' . $resetLink, function ($message) use ($user) {
            $message->to($user->email)->subject('Reset Your Password');
        });
        // Mail::to($data['email'])->send(new ContactMail($data));



        return back()->with('status', 'A password reset link has been sent to your email address.');
    }

    public function showResetPasswordForm(Request $request)
    {
        return view('Auth.password_reset', ['token' => $request->token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset || !Hash::check($request->token, $passwordReset->token)) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'This password reset token is invalid.']);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Your password has been reset!');
    }
    public function profile()
    {
        $metatitle = "My Acount";
        $user = Auth::user();
        return view('Admin.User.profile', compact('metatitle', 'user'));
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'mobile'  => 'nullable|string|max:20',
            'email'   => 'required|email|unique:users,email,' . Auth::id(),
            'city'    => 'nullable',
            'country' => 'nullable',
            'pincode' => 'nullable',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $oldImagePath = public_path($user->image);
            if (file_exists($oldImagePath) && !empty($user->image)) {
                unlink($oldImagePath);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/profile'), $imageName);
            $user->image =  $imageName;
        }

        $user->update([
            'name'    => $request->name,
            'mobile'  => $request->mobile,
            'email'   => $request->email,
            'city'    => $request->city,
            'country' => $request->country,
            'pincode' => $request->pincode,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function user()
    {
        $metatitle = "User listing";
        $users = User::all();
        return view('Admin.User.index', compact('users'));
    }
    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $draw = intval($request->input('draw'));
            $start = intval($request->input('start'));
            $length = intval($request->input('length'));
            $orderColIndex = intval($request->input('order.0.column'));
            $orderCol = $columns[$orderColIndex] ?? 'id';
            $orderDir = $request->input('order.0.dir') ?? 'asc';
            $searchValue = $request->input('search.value');

            $recordsTotal = User::count();
            $records = User::whereIn('role', [1, 2]);

            if (!empty($searchValue)) {
                $records->where(function ($q) use ($searchValue) {
                    $q->where('users.name', 'like', "%{$searchValue}%")
                        ->orWhere('users.id', 'like', "%{$searchValue}%");
                });
            }

            $recordsFiltered = $records->count();

            $record = $records->select('users.*')->orderBy($orderCol, $orderDir)->offset($start)->limit($length)->get();
            $dataArr = [];
            $key = 0;
            foreach ($record as $key => $data) {
                $url = '';
                if (!empty($data->image) && File::exists(public_path('uploads/profile/' . $data->image))) {
                    $url = url('public/uploads/profile/' . $data->image);
                }
                $dataArr[$key]['id'] = !empty($data->id) ? $data->id : '';
                $image = !empty($url) ? '<div class="d-flex align-items-center">
                            <a href="javascript:void(0);" class="avatar avatar-md me-2">
                                <img src="' . $url . '" alt="' . $data->name . ' Category" ">
                            </a>
                        </div>' : '';

                $dataArr[$key]['image'] = $image;
                $dataArr[$key]['name'] = !empty($data->name) ? $data->name : '';
                $dataArr[$key]['role'] = !empty($data->role) ? $data->role : '';

                // if ($data->status == true) {

                //     $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
                //             class="badge bg-success fw-medium fs-10 status-toggle-btn" 
                //             data-id="' . $data->id . '" 
                //             data-current-status="' . $data->status . '" 
                //             data-next-status="0"> Active</a>';
                // } 
                // else {

                //     $dataArr[$key]['status'] = '<a href="javascript:void(0);" 
                //             class="badge bg-danger fw-medium fs-10 status-toggle-btn" 
                //             data-id="' . $data->id . '" 
                //             data-current-status="' . $data->status . '" 
                //             data-next-status="1"> Inactive</a>';
                // }

                $action = '';
                $action .= '<div class="edit-delete-action float-end">
                            <a href="#" class="me-2 p-2 text-success">
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
}
