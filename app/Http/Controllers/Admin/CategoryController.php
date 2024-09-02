<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminAccess;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    public function index()
    {
        return view("admin.category.listing");
    }

    public function categoryData()
    {
        $session_role = session("role");

        // dd($role);
        $data = Category::where("is_delete", 0)->get();

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
                        $btn = '<a href="' . route('category-edit', ['id' => $id]) . '" class="btn btn-warning btn-sm"><i class="ti-eye"></i></a>';
                    } else {
                        $btn = '<a href="' . route('category-edit', ['id' => $id]) . '" class="btn btn-warning btn-sm"><i class="ti-eye"></i></a> &nbsp
                             <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>';
                    }

                } else {
                    $btn = '<a href="' . route('category-edit', ['id' => $id]) . '" class="btn btn-warning btn-sm"><i class="ti-eye"></i></a> &nbsp
                    <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '"><i class="ti-trash"></i></button>';
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

    public function create(Request $request)
    {
        return view('admin.category.category_form');
    }

    public function store(Request $request)
    {
        $file_name = '';

        if ($request->hasFile('image')) {
            $file_name = time() . '.' . $request->image->extension();
            $request->image->move(public_path('service_provider/assets/images/category'), $file_name);
        }

        $originalSlug = Str::slug($request->name);
        $slug = $originalSlug;
        $count = 1;

        while (Category::where('slug', $slug)->exists()) {
            // Append a unique identifier to the slug if it already exists
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $category = Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'image' => $file_name,
        ]);

        if ($category) {
            return redirect()->route('category-list')->with('success', 'Category added successfuly');
        } else {
            return redirect()->back()->with('error', 'Smomething went wrong');
        }
    }

    public function edit($id)
    {

        $id = base64_decode($id);
        $category = Category::find($id);
        if ($category) {
            return view('admin.category.category_form')->with('category', $category);
        } else {
            return view('admin.category.category_form');
        }
    }

    public function update(Request $request, $id)
    {
        $id = base64_decode($id);

        $originalSlug = Str::slug($request->name);
        $slug = $originalSlug;
        $count = 1;

        while (Category::where('slug', $slug)->where("id", "!=", $id)->exists()) {
            // Append a unique identifier to the slug if it already exists
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $category = Category::find($id);

        if ($category) {
            // Check if a new image is provided
            if ($request->hasFile('image')) {
                // Remove the existing image
                if ($category->image) {
                    $oldImagePath = public_path('service_provider/assets/images/category/' . $category->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                // Move the new image to the desired directory
                $file_name = time() . '.' . $request->image->extension();
                $request->image->move(public_path('service_provider/assets/images/category'), $file_name);

                // Update the category with the new image
                $update = $category->update([
                    'name' => $request->name,
                    'slug' => $slug,
                    'image' => $file_name,
                ]);
            } else {
                // If no new image is provided, update other fields without changing the image
               $update = $category->update([
                    'name' => $request->name,
                    'slug' => $slug,
                ]);
            }

            if ($update) {
                return redirect()->route('category-list')->with('success', 'Category data updated');
            } else {
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->category_id);
        if ($category) {
            $category->is_delete = 1;
            $category->save();
        }
    }

    public function changeStatus(Request $request)
    {
        $category_id = $request->category_id;
        $status = $request->status;

        $user = Category::find($category_id);
        $user->is_active = $status;
        $user->save();
    }
}
