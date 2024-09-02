<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\BusinessService;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class ServiceController extends Controller
{
    public function index(){
        return view("admin.service_provider.service_listing");
    }

    public function data(Request $request)
    {
        $session_role = session("role");
        $role = $request->role;

        // dd($role);
        $data = User::where("is_delete", 0)->where('role','S')->get();

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
                // if ($session_role == 'S') {
                //     $roles = AdminAccess::where('admin_id', $admin_id)->value('access_id');
                //     $roles_array = explode(',', $roles);

                //     if (!in_array(1, $roles_array) && !in_array(4, $roles_array)) {
                //         $btn = '';
                //     } else if (!in_array(1, $roles_array)) {
                //         $btn = '<button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>';
                //     } else if (!in_array(4, $roles_array)) {
                //         $btn = '<a href="' . route('admin-user-edit', ['id' => $id]) . '" class="btn btn-primary btn-sm"><i class="ti-eye"></i></a>';
                //     } else {
                //         $btn = '<a href="' . route('admin-user-edit', ['id' => $id]) . '" class="btn btn-primary btn-sm"><i class="ti-eye"></i></a> &nbsp
                //              <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>';
                //     }

                // } else {
                    $btn = '<a href="' . route('admin-user-edit', ['id' => $id]) . '" class="btn btn-primary btn-sm"><i class="ti-pencil"></i></a> &nbsp
                    <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>&nbsp
                    <a href="' . route('service-provider-edit', ['id' => $id]) . '" class="btn btn-success btn-sm"><i class="ti-eye"></i></a>';
                // }
                return $btn;
            })

            ->addColumn('approval_status', function ($row) {
                $session_role = session("role");
                $admin_id = auth()->guard('admin')->user()->id;
                // if ($session_role == 'S') {
                //     $roles = AdminAccess::where('admin_id', $admin_id)->value('access_id');
                //     $roles_array = explode(',', $roles);

                //     if(!in_array(3, $roles_array)) {
                //         $toggleBtn = "Don't have an access";
                //     }else{
                //         $toggleBtn = $row->is_active == 1
                //     ? '<button type="button" class="btn btn-warning btn-sm toggle active" value="' . $row->id . '" data-id="' . $row->is_active . '">Active</button>'
                //     : '<button type="button" class="btn btn-danger btn-sm toggle in-active" value="' . $row->id . '" data-id="' . $row->is_active . '">Inactive</button>';
                //     }

                // }else{
                    $toggleBtn = $row->is_approved == 1
                    ? '<button type="button" class="btn btn-warning btn-sm toggle active" value="' . $row->id . '" data-id="' . $row->is_active . '">Approved</button>'
                    : '<button type="button" class="btn btn-danger btn-sm toggle in-active" value="' . $row->id . '" data-id="' . $row->is_active . '">Pending</button>';
                // }

                return $toggleBtn;
            })

            ->addColumn('status', function ($row) {
                $session_role = session("role");
                $admin_id = auth()->guard('admin')->user()->id;
                // if ($session_role == 'S') {
                //     $roles = AdminAccess::where('admin_id', $admin_id)->value('access_id');
                //     $roles_array = explode(',', $roles);

                //     if(!in_array(3, $roles_array)) {
                //         $toggleBtn = "Don't have an access";
                //     }else{
                //         $toggleBtn = $row->is_active == 1
                //     ? '<button type="button" class="btn btn-warning btn-sm toggle active" value="' . $row->id . '" data-id="' . $row->is_active . '">Active</button>'
                //     : '<button type="button" class="btn btn-danger btn-sm toggle in-active" value="' . $row->id . '" data-id="' . $row->is_active . '">Inactive</button>';
                //     }

                // }else{
                    $toggleBtn = $row->is_active == 1
                    ? '<button type="button" class="btn btn-warning btn-sm toggle active" value="' . $row->id . '" data-id="' . $row->is_active . '">Active</button>'
                    : '<button type="button" class="btn btn-danger btn-sm toggle in-active" value="' . $row->id . '" data-id="' . $row->is_active . '">Inactive</button>';
                // }

                return $toggleBtn;
            })
            ->rawColumns(['action', 'status','approval_status'])
            ->make(true);
    }


    public function create(){
        return view("admin.service_provider.service_form");
    }

    public function store(Request $request){
        dd($request->all());
    }


    // public function view($id){
    //     $owner_id = base64_decode($id);
    //     $business_id = Business::where('owner_id',$owner_id)->value('id');
    //     // dd($business_id);
    //     $business = Business::where("owner_id",$owner_id)->first();
    //     $services = BusinessService::with('service')->where('business_id',$business_id)->where('is_delete',0)->get();
    //     return view('admin.service_provider.service_provider_detail',compact('business','services'));
    // }

}
