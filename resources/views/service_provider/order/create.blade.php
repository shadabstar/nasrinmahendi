@extends('service_provider.layout.main')

@section('main-container')
@section('title', isset($order) ? 'Order Edit' : 'Order Add')

@section('category', 'active')

<div class="content-page">

    <!-- Start content -->
    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">
                        @if (isset($order))
                            Edit
                        @else
                            Add
                        @endif Order
                    </h4>
                    <ol class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="javascript:;" onclick = "history.back()">Category</a></li>
                        <li class="active">
                            @if (isset($order))
                                Edit
                            @else
                                Add
                            @endif Order
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row">

                <div class="card-box">
                    @if (Session::get('success'))
                        <div class="alert alert-success alert-dismissible"><button type="button" class="close"
                                data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>{{ Session::get('success') }}</div>
                    @endif

                    @if (Session::get('error'))
                        <div class="alert alert-danger alert-dismissible"><button type="button" class="close"
                                data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>{{ Session::get('error') }}</div>
                    @endif

                    {{-- {{ $user }} --}}
                    @if (isset($order))
                        <form action="{{ route('order-update', ['id' => $order->id]) }}" enctype="multipart/form-data"
                            id="user_form" method="post" role="form">
                            @csrf
                        @else
                            <form action="{{ route('order-store') }}" enctype="multipart/form-data" id="user_form"
                                method="post" role="form">
                                @csrf
                    @endif

                    <h4>Order Details</h4>
                    <hr>

                    <div class="row">
                        {{-- {{dd($order)}} --}}
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <input type="text" name="name" required placeholder="Enter Party Name"
                                    class="form-control" id="name"
                                    value="{{ isset($order->name) ? $order->name : '' }}">
                                @error('name')
                                    {{ 'message' }}
                                @enderror
                            </div>
                        </div>


                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="mobile">Contact No*</label>
                                <input type="text" required placeholder="Enter Mobile No" name="mobile"
                                    class="form-control" id="mobile"
                                    value="{{ isset($order->mobile) ? $order->mobile : '' }}">
                                @error('mobile')
                                    {{ 'message' }}
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="form-group">
                                <label for="sider">Siders*</label>
                                <input type="number" placeholder="Enter No Of Siders" name="sider"
                                    class="form-control" id="sider"
                                    value="{{ isset($order->sider) ? $order->sider : '' }}">
                                @error('sider')
                                    {{ 'message' }}
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="date">Date*</label>
                                <input type="date" required placeholder="Select date" name="date"
                                    class="form-control" id="date"
                                    value="{{ isset($order->date) ? $order->date : '' }}">
                                @error('date')
                                    {{ 'message' }}
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address">Address*</label>
                                <textarea class="form-control" id="address" name="address" placeholder="Enter Address">{{ isset($order->address) ? $order->address : '' }}</textarea>
                                @error('address')
                                    {{ 'message' }}
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" name="price" placeholder="Enter Price" class="form-control"
                                    id="price" value="{{ isset($order->price) ? $order->price : '' }}">
                                @error('price')
                                    {{ 'message' }}
                                @enderror
                            </div>

                            @if (isset($order))
                                <div class="form-group">
                                    <label for="my_earning">My Earnings</label>
                                    <input type="text" name="my_earning" placeholder="Enter Your Earning Price"
                                        class="form-control" id="my_earning"
                                        value="{{ isset($order->my_earning) ? $order->my_earning : '' }}">
                                    @error('my_earning')
                                        {{ 'message' }}
                                    @enderror
                                </div>
                            @endif

                        </div>

                        <div class="col-lg-6">

                            <div class="form-group">
                                <label for="bridal">Bridal*</label>
                                <input type="number" placeholder="Enter No Of Bridal" name="bridal"
                                    class="form-control" id="bridal"
                                    value="{{ isset($order->bridal) ? $order->bridal : '' }}">
                                @error('bridal')
                                    {{ 'message' }}
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="timing">Time*</label>
                                <select name="timing" required class="form-control" name="timing" id="timing">
                                    <option value="">--Select--</option>
                                    <option value="0"
                                        {{ isset($order->timing) && $order->timing == 0 ? 'selected' : '' }}>
                                        Morning</option>
                                    <option value="1"
                                        {{ isset($order->timing) && $order->timing == 1 ? 'selected' : '' }}>Noon
                                    </option>
                                    <option value="0"
                                        {{ isset($order->timing) && $order->timing == 2 ? 'selected' : '' }}>
                                        Evening </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="comment">Comment*</label>
                                <textarea class="form-control" id="comment" name="comment" placeholder="Enter Comment">{{ isset($order->comment) ? $order->comment : '' }}</textarea>
                                @error('comment')
                                    {{ 'message' }}
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Images</label>
                                <input type="file" name="image[]" accept="image/*" class="form-control"
                                    id="image" multiple>
                            </div>


                        </div>

                    </div>


                    <div class="row" style="display: none;" id="members">
                        <div class="col-12">
                            <h4>Member Details</h4>
                            <hr>
                        </div>
                        <div class="m">

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="member_name">Name*</label>
                                    <input type="text" placeholder="Enter Member Name" name="member_name[]"
                                        class="form-control member-data" id="member_name">
                                    <span class="text-danger member_name_error"></span>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="member_mobile">Mobile No*</label>
                                    <input type="text" placeholder="Enter Member Mobile No" name="member_mobile[]"
                                        class="form-control member-data" id="member_mobile_1">
                                    <span class="text-danger member_mobile_error"></span>

                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="special_comment">Special Comment*</label>
                                    <input type="text" placeholder="Enter Special Comment"
                                        name="special_comment[]" accept="image/*" class="form-control member-data"
                                        id="special_comment">
                                    <span class="text-danger member_comment_error"></span>

                                </div>
                            </div>

                            {{-- <div class="col-lg-3">
                                <div class="form-group">
                                    <label>&nbsp;</label> <!-- Empty label for spacing -->
                                    <button type="button"
                                        class="add-new form-control btn btn-sm btn-primary first-add-button">+</button>
                                </div>
                            </div> --}}
                        </div>
                    </div>

                    <button type="button" class="btn btn-success add-members"> Add Members </button>
                    <button type="button" class="add-new second-add-button btn btn-sm btn-primary"
                        style="display: none">+</button>
                    <button type="button" class="btn btn-danger rmv-members" style="display: none"> Remove All
                        Members </button>

                    <div class="form-group text-left" style="margin-top:20px">
                        <button class="btn btn-primary waves-effect waves-light" id="submit" type="submit">
                            Submit
                        </button>
                    </div>
                </div>

                </form>
            </div>

            @if (isset($order))
                <div class="row">

                    <div class="card-box">
                        <h4>Added Members</h4>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Name</th>
                                    <th>Mobile No</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                                @php
                                    $count = 1;
                                @endphp
                                @if (isset($order) && $order->MembersData->count() > 0)

                                    @foreach ($order->MembersData as $member)
                                        <tr data-id="{{ $member->id }}">
                                            <td class="no">{{ $count }}</td>
                                            <td class="name">{{ $member->name }}</td>
                                            <td class="mobile">{{ $member->mobile }}</td>
                                            <td class="comment">{{ $member->comment }}</td>
                                            <td class="action">
                                                <i class="ti-pencil edit-icon"></i>
                                                <i class="ti-trash delete-icon"></i>
                                            </td>
                                        </tr>
                                        @php
                                            $count++;
                                        @endphp
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Images section -->
                <div class="row">

                    <div class="card-box">
                        <h4>Added Images</h4>

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Sr No</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                                @php
                                    $count = 1;
                                @endphp
                                @if (isset($order) && $order->DesignImages->count() > 0)

                                    @foreach ($order->DesignImages as $image)
                                        <tr data-id="{{ $image->id }}">
                                            <td class="no">{{ $count }}</td>
                                            <td class="image">
                                                <a
                                                    href="{{ asset('service_provider/assets/images/design/' . $image->image) }}">
                                                    <img src="{{ asset('service_provider/assets/images/design/' . $image->image) }}"
                                                        alt="Design Image" width="100px" height="100px">
                                                </a>
                                            </td>
                                            <td class="action">
                                                <i class="ti-trash delete-image"></i>
                                            </td>
                                        </tr>
                                        @php
                                            $count++;
                                        @endphp
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <script src="{{ asset('service_provider/assets/js/jquery.min.js') }}"></script>

    {{-- <script defer type="text/javascript" src="{{ asset('service_provider/assets/plugins/parsleyjs/dist/parsley.min.js') }}"> --}}

    <script type="text/javascript"
        src="{{ asset('service_provider/assets/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('service_provider/assets/js/form.submit.js') }}"></script>

    <script defer src="{{ asset('service_provider/assets/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script defer src="{{ asset('service_provider/assets/pages/jquery.sweet-alert.init.js') }}"></script>

    <script defer src="{{ asset('service_provider/assets/plugins/sweetalert/dist/sweetalert.min.js') }}"></script>
    <script defer src="{{ asset('service_provider/assets/pages/jquery.sweet-alert.init.js') }}"></script>

    <script type="text/javascript">

        $.validator.addMethod("nonNegative", function(value, element) {
            return this.optional(element) || /^[0-9]+(\.[0-9]+)?$/.test(value);
        }, "Please enter a non-negative number");


        $.validator.addMethod("integer", function(value, element) {
            return this.optional(element) || /^-?\d+$/.test(value);
        }, "A positive or negative non-decimal number please");

        $.validator.addMethod("oneRequired", function(value, element, param) {
            var siderValue = $(param[0]).val();
            var bridalValue = $(param[1]).val();
            return siderValue > 0 || bridalValue > 0;
        }, "Either Sider or Bridal must have a value greater than 0");

        $.validator.addMethod("letterswithbasicpunc", function(value, element) {
            return this.optional(element) || /^[a-z\-.,()'"\s]+$/i.test(value);
        }, "Letters or punctuation only please.");

        $.validator.addMethod("mobileIND", function(value, element) {
            return this.optional(element) || /^[0-9]{10}$/.test(value);
        }, "Please enter a valid 10-digit mobile number");

        $.validator.addMethod("noEmoji", function(value, element) {
            return this.optional(element) || /^[^\p{Emoji_Presentation}\p{Extended_Pictographic}]*$/u
                .test(value);
        }, "No emojis allowed");


        $("#user_form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                    letterswithbasicpunc: true,
                },
                mobile: {
                    required: true,
                    mobileIND: true
                },
                date: {
                    required: true,
                },
                sider: {
                    min: 0,
                    max: 100,
                    integer: true,
                    oneRequired: ['#sider', '#bridal'] // Custom validation rule

                },
                bridal: {
                    min: 0,
                    max: 100,
                    integer: true,
                    oneRequired: ['#sider', '#bridal'] // Custom validation rule

                },
                address: {
                    required: true,
                    noEmoji: true
                },
                timing: {
                    required: true,
                },
                comment: {
                    // required: true,
                },
                price: {
                    nonNegative: true,
                },
                my_earning: {
                    nonNegative: true,
                }
            },

            submitHandler: function(form, event) {
                event.preventDefault();
                $('#submit').prop('disabled', true);
                submitForm(form);
            }

        });

        function validateLastMemberRow() {
            let isValid = true;

            // Get the last member row
            let lastMemberRow = $('#members .m').last();

            // Name validation: Only characters and whitespace
            let nameInput = lastMemberRow.find('input[name="member_name[]"]');
            let namePattern = /^[A-Za-z\s]+$/;
            if (!namePattern.test(nameInput.val().trim())) {
                isValid = false;
                nameInput.addClass('error'); // Add error class for styling
                lastMemberRow.find('.member_name_error').text('Name should only contain characters and whitespace.');
            } else {
                nameInput.removeClass('error'); // Remove error class if valid
                lastMemberRow.find('.member_name_error').text('');
            }

            // Mobile validation: Only numeric values
            let mobileInput = lastMemberRow.find('input[name="member_mobile[]"]');
            let mobilePattern = /^[0-9]+$/;
            if (!mobilePattern.test(mobileInput.val().trim())) {
                isValid = false;
                mobileInput.addClass('error'); // Add error class for styling
                lastMemberRow.find('.member_mobile_error').text('Mobile number should only contain numeric values.');
            } else {
                mobileInput.removeClass('error'); // Remove error class if valid
                lastMemberRow.find('.member_mobile_error').text('');
            }

            // Comment validation: Can be blank
            let commentInput = lastMemberRow.find('input[name="special_comment[]"]');
            // No pattern check needed since it can be blank or any text
            commentInput.removeClass('error'); // Remove any error class (if previously added)
            lastMemberRow.find('.member_comment_error').text('');

            return isValid;
        }

        $('.add-new').click(function() {
            if (validateLastMemberRow()) {
                var memberDiv = `
                <div class='m mmbr'>
                <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="member_name">Name*</label>
                                    <input type="text" placeholder="Enter Member Name" name="member_name[]"
                                        class="form-control member-data" id="member_name" value="">
                                    <span class="text-danger member_name_error"></span>

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="member_mobile">Mobile No*</label>
                                    <input type="text" placeholder="Enter Member Mobile No"
                                        name="member_mobile[]" class="form-control member-data" id="">
                                    <span class="text-danger member_mobile_error"></span>

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="special_comment">Special Comment*</label>
                                    <input type="text" placeholder="Enter Special Comment"
                                        name="special_comment[]" class="form-control member-data" id="">
                                    <span class="text-danger member_comment_error"></span>

                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>&nbsp;</label> <!-- Empty label for spacing -->
                                    <button type="button"
                                        class="rmv-this form-control btn btn-sm btn-danger">-</button>
                                </div>
                            </div>
                        </div>`;

                $('#members').append(memberDiv);
            } else {
                swal({
                    title: "Opp!",
                    text: "Please fill in all fields in the last member row before adding a new one",
                    icon: "info"
                });
            }
        });

        $('.add-members').click(function() {
            $('#members').removeClass('d-none').show(); // Removes the d-none class and shows the div
            $('.rmv-members').show();
            $('.add-members').hide();
            $('.first-add-button').hide();
            $('.second-add-button').show();

        });

        $('#members').on('click', '.rmv-this', function() {
            // Remove the rmv-this div and the three previous sibling divs
            $(this).closest('.m').remove();

        });

        $('.rmv-members').click(function() {
            $('.rmv-members').hide();
            $('.add-members').show();
            $('.mmbr').remove();
            $('.member-data').val("");
            $('#members').removeClass('d-none').hide();
            $('.first-add-button').show();
            $('.second-add-button').hide();
        });

        $('table').on('click', '.edit-icon', function() {
            var $row = $(this).closest('tr');
            var $nameTd = $row.find('.name');
            var $mobileTd = $row.find('.mobile');
            var $commentTd = $row.find('.comment');
            var $actionTd = $row.find('.action');

            // Convert td to input
            $nameTd.html('<input type="text" value="' + $nameTd.text() + '" class="name-input">');
            $mobileTd.html('<input type="text" value="' + $mobileTd.text() + '" class="mobile-input">');
            $commentTd.html('<input type="text" value="' + $commentTd.text() + '" class="comment-input">');

            // Replace edit icon with save icon
            $actionTd.html('<i class="ti-save save-icon"></i>');

            // Handle save action
            $actionTd.find('.save-icon').on('click', function() {
                var id = $row.data('id');
                var name = $row.find('.name-input').val();
                var mobile = $row.find('.mobile-input').val();
                var comment = $row.find('.comment-input').val();

                // AJAX call to save updated data
                $.ajax({
                    url: "{{ route('order-update-member') }}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        name: name,
                        id: id,
                        mobile: mobile,
                        comment: comment
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update the table row with new data
                            $nameTd.text(name);
                            $mobileTd.text(mobile);
                            $commentTd.text(comment);

                            // Restore the action icons
                            $actionTd.html(
                                '<i class="ti-pencil edit-icon"></i> <i class="ti-trash delete-icon"></i>'
                            );

                            // Reattach event listeners
                            attachEditDeleteEvents();
                        }
                    }
                });
            });
        });


        // Delegated event handling for delete functionality
        $('table').on('click', '.delete-icon', function() {
            var $row = $(this).closest('tr');
            var id = $row.data('id');

            swal({
                title: "Are you sure?",
                text: "Do you want to delete member from this order!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, change it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    // AJAX call to delete the data
                    $.ajax({
                        url: "{{ route('order-delete-member') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove the row from the table
                                $row.remove();
                            }
                            swal("Done", "Member deleted successfully)", "success");
                        }
                    });
                } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                }
            });
        });


        $('table').on('click', '.delete-image', function() {
            var $row = $(this).closest('tr');
            var id = $row.data('id');

            swal({
                title: "Are you sure?",
                text: "Do you want to delete image from this order!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function(isConfirm) {
                if (isConfirm) {
                    // AJAX call to delete the data
                    $.ajax({
                        url: "{{ route('order-delete-image') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            id: id,
                        },
                        success: function(response) {
                            if (response.success) {
                                // Remove the row from the table
                                $row.remove();
                            }
                            swal("Done", "Order deleted successfully)", "success");
                        }
                    });
                } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                }
            });
        });
    </script>
@endsection
