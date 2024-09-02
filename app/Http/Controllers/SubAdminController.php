<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\AdminAccess;
use App\Models\Module;
use DataTables;
use Illuminate\Support\Facades\Hash;

class SubAdminController extends Controller
{

    public function index()
    {
        return view("admin.admin.admin_list");
    }
    public function create()
    {
        return view('admin.admin.admin_form');
    }

    public function store(Request $request)
    {
        

        $admin = Admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);



        if ($admin->save()) {

            $modules = Module::where("is_active", 1)->where("is_delete", 0)->get();

            // foreach ($modules as $module) {
            //     if($request->)
            // }
            if ($request->User) {
                $access_ids = implode(",", $request->User);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "User")->value("id");
                // dd($module_id);

                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,

                ]);
            }

            if ($request->Service) {
                $access_ids = implode(",", $request->Service);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Service")->value("id");



                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,
                ]);

            }

            if ($request->Business) {
                $access_ids = implode(",", $request->Business);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Business")->value("id");


                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,
                ]);
            }

            if ($request->Category) {
                $access_ids = implode(",", $request->Category);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Category")->value("id");


                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,
                ]);
            }

            if ($request->Sub_category) {
                $access_ids = implode(",", $request->Sub_category);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Sub_category")->value("id");


                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,
                ]);
            }

            if ($request->Coupon) {
                $access_ids = implode(",", $request->Coupon);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Coupon")->value("id");


                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,
                ]);
            }

            if ($request->Booking) {
                $access_ids = implode(",", $request->Booking);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Booking")->value("id");


                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,
                ]);
            }

            if ($request->Advertisement) {
                $access_ids = implode(",", $request->Advertisement);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Advertisement")->value("id");


                AdminAccess::create([
                    "admin_id" => $admin->id,
                    "module_id" => $module_id,
                    "access_id" => $access_ids,
                ]);
            }
            return redirect()->route('admin-list')->with('success', 'Admin inserted added succesfuly');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function changeStatus(Request $request)
    {
        // dd("Working");
        $user_id = $request->user_id;
        $status = $request->status;

        $user = Admin::find($user_id);
        $user->is_active = $status;
        $user->save();
    }

    public function adminData()
    {
        $data = Admin::where("is_delete", 0)->get();

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $id = base64_encode($row->id);
                $btn = '<a href="' . route('admin-show', ['id' => $id]) . '" class="btn btn-primary btn-sm"><i class="ti-eye"></i></a> &nbsp
                         <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>';
                return $btn;
            })
            ->addColumn('status', function ($row) {
                $toggleBtn = $row->is_active == 1
                    ? '<button type="button" class="btn btn-warning btn-sm toggle active" value="' . $row->id . '" data-id="' . $row->is_active . '">Active</button>'
                    : '<button type="button" class="btn btn-danger btn-sm toggle in-active" value="' . $row->id . '" data-id="' . $row->is_active . '">Inactive</button>';
                return $toggleBtn;
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function show($id)
    {
        // dd("Working");
        $admin_id = base64_decode($id);
        // dd($admin_id);
        $user = Admin::find($admin_id);
        // dd($user);
        return view('admin.admin.admin_form', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        // dd($request->all());
        $change = $admin->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile' => $request->mobile,

        ]);

        if ($change) {
            $admin_access = AdminAccess::where("admin_id", $id);

            if ($request->User) {
                $access_ids = implode(",", $request->User);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "User")->value("id");
                // dd($module_id);
                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);

            }


            if ($request->Service) {
                // dd("Srvice me mila");
                $access_ids = implode(",", $request->Service);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Service")->value("id");
                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);

            }


            if ($request->Business) {
                $access_ids = implode(",", $request->Business);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Business")->value("id");
                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);
            }

            if ($request->Category) {
                $access_ids = implode(",", $request->Category);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Category")->value("id");

                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);

            }

            if ($request->Sub_category) {
                $access_ids = implode(",", $request->Sub_category);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Sub_category")->value("id");

                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);

            }

            if ($request->Coupon) {
                $access_ids = implode(",", $request->Coupon);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Coupon")->value("id");

                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);
            }

            if ($request->Booking) {
                $access_ids = implode(",", $request->Booking);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Booking")->value("id");

                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);

            }

            if ($request->Advertisement) {
                $access_ids = implode(",", $request->Advertisement);
                $module_id = Module::where("is_active", 1)->where("is_delete", 0)->where("name", "Advertisement")->value("id");

                AdminAccess::where("module_id", $module_id)->where("admin_id", $id)->update([
                    "access_id" => $access_ids
                ]);

            }
            return redirect()->route('admin-list')->with('success', 'Admin detail updated');

        }else{
            return redirect()->route('admin-list')->with('error', 'Something went wrong');

        }

    }
}
