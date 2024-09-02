<?php

namespace App\Http\Controllers\serviceProvider;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DesignImages;
use App\Models\Members;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Twilio\Rest\Client;

class OrderController extends Controller
{
    public function index()
    {
        return view('service_provider.order.listing');
    }

    public function orderData(Request $request)
    {
        $query = Order::where('user_id', auth()->id())
            ->where('is_deleted', '!=', 1)
            ->orderBy('date', 'DESC');

        if ($request->filled('payment_status')) {
            $query->where('is_paid', $request->payment_status);
        }

        if ($request->filled('order_status')) {
            $query->where('status', $request->order_status);
        }

        if ($request->filled('month')) {
            $monthYear = explode('/', $request->month);
            if (count($monthYear) == 2) {
                $month = $monthYear[0];
                $year = $monthYear[1];
                $query->whereYear('date', $year)
                    ->whereMonth('date', $month);
            }
        }

        $data = $query->get();

        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<a href="' . route('service-edit', ['id' => $row->id]) . '" class="btn btn-primary btn-sm">
                            <i class="ti-pencil" style="color:black; font-size:15px"></i></a> &nbsp;
                        <button type="button" class="btn btn-danger btn-sm delete" value="' . $row->id . '">
                            <i class="ti-trash" style="color:black; font-size:15px"></i></button>';
            })
            ->addColumn('status', function ($row) {
                $statusOptions = [
                    '0' => 'Pending',
                    '1' => 'Completed',
                    '2' => 'Canceled'
                ];

                $statusDropdown = '<select class="form-control status-dropdown" data-id="' . $row->id . '">';
                foreach ($statusOptions as $value => $label) {
                    $selected = $row->status == $value ? 'selected' : '';
                    $statusDropdown .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                }
                $statusDropdown .= '</select>';

                return $statusDropdown;
            })
            ->addColumn('is_paid', function ($row) {
                return $row->is_paid == 0
                    ? "<a href='javascript:void(0);' title='Make Paid'><span data-id='" . $row->id . "' class='label label-tabel label-inverse payment'>Unpaid</span></a>"
                    : "<a href='javascript:void(0);' title='Make Unpaid'><span data-id='" . $row->id . "' class='label label-tabel label-warning payment'>Paid</span></a>";
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->rawColumns(['action', 'status', 'is_paid', 'created_at'])
            ->make(true);
    }


    public function create()
    {
        return view('service_provider.order.create');
    }

    public function store(Request $request)
    {
        $params = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'date' => $request->date,
            'timing' => $request->timing,
            'sider' => $request->sider ? $request->sider : 0,
            'bridal' => $request->bridal ? $request->bridal : 0,
            'address' => $request->address,
            'comment' => $request->comment,
            'user_id' => auth()->id(),
            'price' => $request->price ? $request->price : 0,
        ];

        $create = Order::create($params);

        $time = '';
        if ($request->timing == 0) {
            $time = 'Morning';
        } elseif ($request->timing == 1) {
            $time = 'Noon';
        } else {
            $time = 'Evening';
        }

        if ($create) {

            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('service_provider/assets/images/design'), $imageName); // Save each image to the uploads directory

                    $image_params = [
                        'order_id' => $create->id,
                        'image' => $imageName,
                    ];
                    $create_image = DesignImages::create($image_params);
                }
            }

            // Check if member_name is set and not empty
            if (isset($request->member_name) && !empty($request->member_name)) {
                // Check the first index of member_name
                if ($request->member_name[0] != null) {
                    // Loop through member names and store member data
                    foreach ($request->member_name as $index => $memberName) {
                        // Store each member record
                        Members::create([
                            'order_id' => $create->id, // Assuming there is an order_id foreign key in the members table
                            'name' => $memberName,
                            'mobile' => $request->member_mobile[$index],
                            'comment' => $request->special_comment[$index],
                        ]);

                        $name = User::where('id', auth()->id())->value('name');

                        $message = "Hello $memberName, you are booked by $name for their order on $request->date at $time. You can contact them for further details.";

                        $this->sendSms($message, $request->member_mobile[$index]);
                        // $this->sendSms($request->member_mobile[$index], $memberName, $request->date, $time);
                    }
                }
            }

            $output['status'] = 'success';
            $output['message'] = 'Order created successfully';
            $output['redirect'] = route('order-list');
            $output['slideToTop'] = true;
            $output['selfReload'] = false;

            return response()->json($output);
        }
    }

    protected function sendSms($msg, $mobileNumber)
    {
        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');

        $client = new Client($sid, $authToken);

        $message = $msg;

        try {
            $client->messages->create(
                $mobileNumber, // Send to this number
                [
                    'from' => $twilioNumber, // From a valid Twilio number
                    'body' => $message
                ]
            );
            // dd(1);
        } catch (\Exception $e) {
            // dd($e->getMessage());

            // Log the error or handle as needed
            \Log::error('Twilio SMS failed: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $order = Order::with(['MembersData', 'DesignImages'])->find($id);
        if ($order) {
            return view('service_provider.order.create', compact('order'));
        } else {
            return redirect()->back()->with(session()->flash('error', 'Order not found'));
        }
    }


    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if ($order) {
            $params = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'date' => $request->date,
                'timing' => $request->timing,
                'sider' => $request->sider ? $request->sider : 0,
                'bridal' => $request->bridal ? $request->bridal : 0,
                'address' => $request->address,
                'comment' => $request->comment,
                'user_id' => auth()->id(),
                'price' => $request->price ? $request->price : 0,
                'my_earning' => $request->my_earning ? $request->my_earning : 0,
            ];

            $update = $order->update($params);

            if ($update) {

                if ($request->hasFile('image')) {
                    foreach ($request->file('image') as $image) {
                        $imageName = time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move(public_path('service_provider/assets/images/design'), $imageName); // Save each image to the uploads directory

                        $image_params = [
                            'order_id' => $id,
                            'image' => $imageName,
                        ];
                        $create_image = DesignImages::create($image_params);
                    }
                }

                // Check if member_name is set and not empty
                if (isset($request->member_name) && !empty($request->member_name)) {
                    // Check the first index of member_name
                    if ($request->member_name[0] != null) {
                        // Loop through member names and store member data
                        foreach ($request->member_name as $index => $memberName) {
                            // Store each member record
                            Members::create([
                                'order_id' => $id, // Assuming there is an order_id foreign key in the members table
                                'name' => $memberName,
                                'mobile' => $request->member_mobile[$index],
                                'comment' => $request->special_comment[$index],
                            ]);
                        }
                    }
                }

                $output['status'] = 'success';
                $output['message'] = 'Order created successfully';
                $output['redirect'] = route('order-list');
                $output['slideToTop'] = true;
                $output['selfReload'] = false;

                return response()->json($output);
            }
        } else {
            return redirect()->back()->with(session()->flash('error', 'Order not found'));
        }
    }


    public function updateMember(Request $request)
    {
        $member = Members::find($request->id);
        if ($member) {
            $params = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'comment' => $request->comment,
            ];

            $update = $member->update($params);

            if ($update) {
                return response()->json(['success' => 'true', 'message' => 'Member updated successfully']);
            }
        } else {
            return response()->json(['success' => 'false', 'message' => 'Something went wrong']);
        }
    }


    public function deleteMember(Request $request)
    {

        $member = Members::find($request->id);
        if ($member) {
            $delete = $member->delete();
            if ($delete) {
                $name = User::where('id', auth()->id())->value('name');
                $message = "Hello, $member->name, You are removed by $name for their order. You can contact to $name for further details.";
                $this->sendSms($message, $member->mobile);
                return response()->json(['success' => 'true', 'message' => 'Member deleted successfully']);
            }
        } else {
            return response()->json(['success' => 'false', 'message' => 'Something went wrong']);
        }
    }


    public function deleteImage(Request $request)
    {

        $image = DesignImages::find($request->id);
        if ($image) {
            $delete = $image->delete();
            if ($delete) {
                return response()->json(['success' => 'true', 'message' => 'Image deleted successfully']);
            }
        } else {
            return response()->json(['success' => 'false', 'message' => 'Something went wrong']);
        }
    }


    public function changeStatus(Request $request)
    {
        $order = Order::find($request->id);
        if ($order) {
            $params = [
                'status' => $request->status,
            ];

            $update = $order->update($params);

            if ($update) {

                if ($request->status == 2) {
                    $time = '';
                    if ($order->timing == 0) {
                        $time = 'Morning';
                    } elseif ($order->timing == 1) {
                        $time = 'Noon';
                    } else {
                        $time = 'Evening';
                    }
                    $members = Members::where('order_id', $request->id)->select('id', 'mobile', 'name')->get();

                    foreach ($members as $member) {
                        $name = User::where('id', auth()->id())->value('name');

                        $message = "The order for " . $order->date . " of " . $time . " is calceled for some reasons. You can contact to " . $name . " for further details.";
                        $this->sendSms($message, $member->mobile);
                    }
                }
                return response()->json(['success' => true, 'message' => 'Order Status updated successfully']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }


    public function delete(Request $request)
    {
        $order = Order::find($request->order_id);
        if ($order) {
            $params = [
                'is_deleted' => 1,
            ];

            $update = $order->update($params);

            if ($update) {
                return response()->json(['success' => true, 'message' => 'Order deleted successfully']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong']);
        }
    }


    public function payOrUnPay(Request $request)
    {
        $order = Order::find($request->id);

        if ($order) {
            if ($order->is_paid == 1) {
                $order->is_paid = 0;
                $msg = "Order mark as unpaid successfully.";
            } else {
                $order->is_paid = 1;
                $msg = "Order mark as paid successfully.";
            }
            $order->save();

            return response()->json(['success' => $msg]);
        } else {
            return response()->json(['error' => 'Order does not exist!']);
        }
    }
}
