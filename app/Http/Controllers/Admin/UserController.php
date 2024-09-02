<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccess;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        return view("admin.user.listing");
    }

    public function userData(Request $request)
    {
        $session_role = session("role");
        $role = $request->role;

        // dd($role);
        $data = User::where("is_delete", 0)->get();
        if ($role) {
            // Add additional conditions based on the user role
            $data->where('role', $role);
            // dd("Role mila");
        }

        /**
         *Difference numbers for different action
         *1=>view
         *2=>edit
         *3=>status
         *4=>delete
         *5=>add
         */

        return Datatables::of($data)->addIndexColumn()

            ->addColumn('action', function ($row) {
                $session_role = session("role");
                $admin_id = auth()->guard('admin')->user()->id;

                $id = base64_encode($row->id);
                if ($session_role == 'S') {
                    $roles = AdminAccess::where('admin_id', $admin_id)->value('access_id');
                    $roles_array = explode(',', $roles);

                    if (!in_array(1, $roles_array) && !in_array(4, $roles_array)) {
                        $btn = '';
                    } else if (!in_array(1, $roles_array)) {
                        $btn = '<button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>';
                    } else if (!in_array(4, $roles_array)) {
                        $btn = '<a href="' . route('admin-user-edit', ['id' => $id]) . '" class="btn btn-primary btn-sm"><i class="ti-eye"></i></a>';
                    } else {
                        $btn = '<a href="' . route('admin-user-edit', ['id' => $id]) . '" class="btn btn-primary btn-sm"><i class="ti-eye"></i></a> &nbsp
                             <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>';
                    }

                } else {
                    $btn = '<a href="' . route('admin-user-edit', ['id' => $id]) . '" class="btn btn-primary btn-sm"><i class="ti-pencil"></i></a> &nbsp
                    <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>&nbsp
                    <a href="' . route('admin-user-view', ['id' => $id]) . '" class="btn btn-success btn-sm"><i class="ti-eye"></i></a>';
                }
                return $btn;
            })

            ->addColumn('status', function ($row) {
                $session_role = session("role");
                $admin_id = auth()->guard('admin')->user()->id;
                if ($session_role == 'S') {
                    $roles = AdminAccess::where('admin_id', $admin_id)->value('access_id');
                    $roles_array = explode(',', $roles);

                    if (!in_array(3, $roles_array)) {
                        $toggleBtn = "Don't have an access";
                    } else {
                        $toggleBtn = $row->is_active == 1
                            ? '<button type="button" class="btn btn-warning btn-sm toggle active" value="' . $row->id . '" data-id="' . $row->is_active . '">Active</button>'
                            : '<button type="button" class="btn btn-danger btn-sm toggle in-active" value="' . $row->id . '" data-id="' . $row->is_active . '">Inactive</button>';
                    }

                } else {
                    $toggleBtn = $row->is_active == 1
                        ? '<button type="button" class="btn btn-warning btn-sm toggle active" value="' . $row->id . '" data-id="' . $row->is_active . '">Active</button>'
                        : '<button type="button" class="btn btn-danger btn-sm toggle in-active" value="' . $row->id . '" data-id="' . $row->is_active . '">Inactive</button>';
                }

                return $toggleBtn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.user.user_form');
    }

    // public function store(Request $request){
    //     // dd(request()->all());
    //     $user = User::create([
    //         'first_name'=> $request->first_name,
    //         'middle_name'=> $request->middle_name,
    //         'last_name'=> $request->last_name,
    //         'email'=> $request->email,
    //         'mobile'=> $request->mobile,
    //         'password'=> Hash::make($request->password),
    //         'age'=> $request->age,
    //         'birth_date'=> $request->dob,
    //         'role'=> $request->role,
    //     ]);

    // }
    public function edit($id)
    {
        $id = base64_decode($id);
        $user = User::find($id);
        if ($user) {
            return view('admin.user.user_form')->with('user', $user);
        } else {
            return view('admin.user.user_form');
        }

    }

    public function update(Request $request, $id)
    {
        // dd($request);

        $user = User::find($id);
        if ($user) {
            $user->first_name = $request->first_name;
            $user->middle_name = $request->middle_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->mobile_number = $request->mobile;
            $user->role = $request->role;
            $user->country_id = $request->country_code;
            $user->birth_date = $request->dob;
            $user->age = $request->age;


            if ($user->save()) {
                return redirect()->route('admin-user-list')->with('success', 'User data updated');
            }
        }
    }


    public function view($id){
        $user_id =  base64_decode($id);
        $user = User::find($user_id);
        // dd($user);
        return view('admin.user.view_user')->with('user', $user);
    }

    public function delete(Request $request)
    {
        // dd($request->id);
        $user = User::find($request->user_id);
        if ($user) {

            $user->is_delete = 1;
            $user->is_online = 0;
            $user->save();


        }
    }

    public function changeStatus(Request $request)
    {
        // dd("Working");
        $user_id = $request->user_id;
        $status = $request->status;

        $user = User::find($user_id);
        $user->is_active = $status;
        $user->save();
    }
}
