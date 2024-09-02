@extends('service_provider.layout.main')

@section('main-container')
@section('title', 'Order list')

@section('service', 'active')
<link href="{{ asset('service_provider/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
    rel="stylesheet">

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Failed!</strong> {{ session('error') }}
                </div>
            @endif

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Orders</h4>
                    <ol class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>

                        </li>
                        <li>
                            <a href="#">Orders</a>
                        </li>
                        <li class="active">
                            Listing
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="text-left">
                                    <a href="{{ route('order-create') }}" class="btn btn-warning">New Order</a>
                                </div>
                            </div><br><br>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-2">
                                <label class="form-label">Select Month</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Select Month"
                                        id="monthpicker" readonly>
                                    <span class="input-group-addon bg-custom b-0 text-white"><i
                                            class="icon-calender"></i></span>
                                </div>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-2">
                                <label class="form-label">Select Payment Status</label>
                                <select id="paymentStatus" name="paymentStatus" class="form-control">
                                    <option value="" selected>-- Please Select Payment Status--</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>

                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mt-2">
                                <label class="form-label">Select Order Status</label>
                                <select id="orderStatus" name="orderStatus" class="form-control">
                                    <option value="" selected>-- Please Select Order Status--</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Completed</option>
                                    <option value="2">Canceled</option>
                                </select>
                            </div>
                        </div><br>

                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered user_datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th data-orderable="false">Name</th>
                                        <th data-orderable="false">Siders</th>
                                        <th data-orderable="false">Bridals</th>
                                        <th data-orderable="false">Address</th>
                                        <th data-orderable="false">Price</th>
                                        <th>Booking Date</th>
                                        <th>Order Date</th>
                                        <th data-orderable="false">Status</th>
                                        <th data-orderable="false">Is Paid</th>
                                        <th data-orderable="false">Action</th>
                                    </tr>
                                </thead>


                                <tbody>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script src="{{ asset('service_provider/assets/js/jquery.min.js') }}"></script>
    <script defer src="{{ asset('service_provider/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script defer src="{{ asset('service_provider/assets/plugins/datatables/dataTables.bootstrap.js') }}"></script>


    {{-- <script defer src=""></script> --}}

    <script defer src="{{ asset('service_provider/assets/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script defer src="{{ asset('service_provider/assets/pages/jquery.sweet-alert.init.js') }}"></script>

    <script defer
        src="{{ asset('service_provider/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}">
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            jQuery('#monthpicker').datepicker({
                format: "mm/yyyy",
                startView: "months",
                minViewMode: "months",
                autoclose: true
            });

            $('.icon-calender').on('click', function() {
                $("#monthpicker").val('');
            });


            var table;

            function userList(month, payment, order) {

                if ($.fn.DataTable.isDataTable('#datatable')) {
                    $('#datatable').DataTable().destroy();
                }

                table = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "{{ route('order-data') }}",
                        type: "GET",
                        data: function(d) {
                            d.month = month;
                            d.payment_status = payment;
                            d.order_status = order;
                        }
                    },
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'sider',
                            name: 'sider'
                        },
                        {
                            data: 'bridal',
                            name: 'bridal'
                        },
                        {
                            data: 'address',
                            name: 'address'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'is_paid',
                            name: 'is_paid'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: true,
                            searchable: true
                        }
                    ]
                });
            }

            userList();

            $('#monthpicker, #paymentStatus, #orderStatus').on('change', function() {
                var month = $('#monthpicker').val();
                var payment = $('#paymentStatus').val();
                var order = $('#orderStatus').val();

                userList(month, payment, order);
            });

            $('.icon-calender').on('click', function() {
                $("#monthpicker").val('');
                var payment = $('#paymentStatus').val();
                var order = $('#orderStatus').val();

                userList('', payment, order);
            });




            $(document).on('change', '.status-dropdown', function() {
                let status = $(this).val();
                let id = $(this).data('id');

                swal({
                    title: "Are you sure?",
                    text: "Do you want to change status of the order!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "{{ route('order-status') }}",
                            type: "GET",
                            data: {
                                status: status,
                                id: id
                            },
                            success: function(data) {

                                if (data.success == true) {
                                    swal("Done",
                                        "Your order status is changed successfully)",
                                        "success");
                                } else {
                                    swal("Oops", "something went wrong)", "error");
                                }
                            },
                            error: function() {
                                swal("Oops! Something went wrong.", {
                                    icon: "error",
                                });
                            },
                        });
                    } else {
                        swal("Cancelled", "Your record is safe :)", "error");
                    }
                });
            });


            $("#user_role").change(function() {
                let role = $(this).val();
                userList(role);
            });

            // Automatically hide the alert-message message after 5 seconds
            setTimeout(function() {
                $("#alert-message").alert('close');
            }, 5000);

            $(document).on('click', '.delete', function() {

                let order_id = $(this).val();

                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this data!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "{{ route('order-delete') }}",
                            type: "GET",
                            data: {
                                'order_id': order_id,
                            },
                            success: function(data) {
                                swal("Poof!", "One record has been deleted!",
                                    "success");

                                $('#datatable').DataTable().ajax.reload();

                            },
                            error: function() {
                                swal("Oops! Something went wrong.", {
                                    icon: "error",
                                });
                            },
                        });
                    } else {
                        swal("Cancelled", "Your record is safe :)", "error");
                    }
                });

            });

            $(document).on('click', '.payment', function() {

                let id = $(this).data('id');

                swal({
                    title: "Are you sure?",
                    text: "You want to change payment status!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, change it!",
                    cancelButtonText: "No, cancel!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            url: "{{ route('order.paid.status') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                            },
                            success: function(data) {
                                swal("Done!", data.success,
                                    "success");

                                $('#datatable').DataTable().ajax.reload();

                            },
                            error: function() {
                                swal("Oops! Something went wrong.", {
                                    icon: "error",
                                });
                            },
                        });
                    } else {
                        swal("Cancelled", "Your record is safe :)", "error");
                    }
                });

            });


        });
    </script>
@endsection
