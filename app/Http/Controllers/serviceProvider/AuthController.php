<?php

namespace App\Http\Controllers\serviceProvider;

use App\Http\Controllers\Controller;
use App\Mail\OTPMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Mail;

class AuthController extends Controller
{

    public function loginGet()
    {
        return view("service_provider/auth/login");

    }


    public function loginPost(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->email;
        $password = $request->password;

        $userdata = User::where('email', $email)->first();

        if ($userdata && Hash::check($password, $userdata->password)) {
            if ($userdata->status == 0) {
                return redirect()->back()->with('error', 'Your account is deleted');
            } elseif ($userdata->status == 2) {
                return redirect()->back()->with('error', 'Your account is blocked');
            } else {
                $credentials = $request->only('email', 'password');

                if (Auth::attempt($credentials)) {
                    // $request->session()->put('user_email', $request->email);
                    $user = Auth::user();
                    // Auth::login($user);
                    // $request->session()->put('user_id', $user->id);
                    return redirect()->route('service-provider-dashboard')->with('success', 'Login success');

                }
            }
        } else {
            return redirect()->back()->with('error', 'Invalid credentials');
        }


    }

    public function create()
    {

        return view("service_provider.auth.register");
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            "name" => "required|string|max:100|min:3",
            "mobile" => "required|numeric|unique:users,mobile",
            "email" => "email|required||unique:users,email",
            'password' => 'required|string|min:8|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password' => 'required|same:password',
        ]);

        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            // "country_id" => 1,
            "mobile" => $request->mobile,
            "password" => Hash::make($request->password),
            "otp_code" => $otp
        ]);

        if ($user->save()) {

            $email_data = [
                'title' => 'OTP',
                'body' => 'Your otp is' . $otp
            ];
            Mail::to($request->email)->send(new OTPMail($email_data));

            $request->session()->put('servicePrviderEmail', $user->email);

            $output['status'] = 'success';
            $output['message'] = 'User created successfully';
            $output['redirect'] = route('service-provider-dashboard');
            $output['slideToTop'] = true;
            $output['selfReload'] = false;

            return response()->json($output);

        }

    }

    public function otpPage()
    {
        return view('service_provider.auth.otp');
    }


    public function varification(Request $request)
    {
        // $user = User::find($id);
        // dd($request);

        $user = User::where('email', '=', $request->email)->first();
        if ($user) {
            // dd($user->);
            if ($user->is_delete == 0) {

                if ($user->otp_code == $request->otp) {
                    $user->update([
                        "is_varified" => '1',
                        "otp_code" => null
                    ]);
                    return redirect()->route('service-provider-loginget')->with('Success', 'Your account is varified');
                } else {
                    return redirect()->back()->with('error', 'Entered otp is incorrect');
                }

            } else {
                return redirect()->route('service-provider-create')->with('error', 'Account deleted');
            }

        } else {
            return redirect()->route('service-provider-create')->with('error', 'Not registered user');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('service-provider-loginget')->with('success', 'You are loged out');
    }


    public function changePasswordGet()
    {
        return view('service_provider.change_password');
    }

    public function ChangePasswordPost(Request $request)
    {
        // dd("Changed");

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        $user = auth()->user();

        // dd($user);
        // Check if the current password matches the user's existing password
        if (Hash::check($request->old_password, $user->password)) {
            // Update the user's password with the new hashed password
            $change = $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            if ($change) {
                return redirect()->route('service-provider-dashboard')->with('success', 'Password changed successfully!');
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        } else {
            // dd("Failed");

            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
    }

    // public function varifiedOtp(Request $request){

    // }

    // public function resendOtp(){

    // }


    // public function sendOtp($user){
    //     $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);
    //     $time =  time();

    // }
}
