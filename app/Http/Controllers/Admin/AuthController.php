<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminAccess;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{

    public function dashboard()
    {
        return view("admin.index");
    }
    public function getLogin()
    {
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        // dd($request->all());

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // dd("Working 2");

            $user = auth()->guard('admin')->user();
            // dd($user);
            if ($user) {
                $request->session()->put('admin_id', $user->id);
                $request->session()->put('role', $user->role);
                return redirect()->route('admin-d')->with('success', 'You are Logged in sucessfully.');
            }
        } else {
            return back()->with('error', 'Whoops! invalid email and password.');
        }
    }


    public function changePasswordGet(Request $request)
    {
        return view('admin.change_password');
    }

    public function ChangePasswordPost(Request $request)
    {
        // dd("Changed");

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = auth()->guard('admin')->user();


        // Check if the current password matches the user's existing password
        if (Hash::check($request->old_password, $user->password)) {
            // Update the user's password with the new hashed password
           $change = $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            if($change){
                // dd("Changed");
                return redirect()->route('admin-profile')->with('success', 'Password changed successfully!');
            }else{
            return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            // dd("Failed");

            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
    }



    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('admin-login-get'));
    }


    public function show(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        // dd($user);
        return view('admin.admin_profile', compact('admin'));
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $admin = Admin::find($request->id);
        // dd($admin);
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        $admin->email = $request->email;
        $admin->mobile = $request->mobile;

        if ($admin->save()) {
            return redirect()->route('admin-profile')->with('success', 'Profile updaetd');
        } else {
            return back()->with('error', 'Something went wrong');
        }

        // return redirect()->back()->with('success', 'Profile updated');
    }




}

