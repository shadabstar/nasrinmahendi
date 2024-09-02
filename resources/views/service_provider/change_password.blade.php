@extends('service_provider.layout.main')
@section('main-container')
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

                <div class="row">
                    <div class="">
                        <div class="card-box " style="width: 25%">
                            <div class="panel-heading">
                                <h3 class="text-center"> Change Password </h3>
                            </div>

                            <div class="">
                                <form method="post" action="{{ route('service-provider-change-password') }}" id="password_form"
                                    role="form" class="">
                                    @csrf
                                    {{-- <div class="form-group m-b-0"> --}}
                                    <div class="form-group">
                                        <label class="form-label" for="old_password">Old password</label>
                                        {{-- <div class="input-group"> --}}
                                            <input type="password" class="form-control" id="old_password"
                                                name="old_password" placeholder="Enter Old Password" required>
                                            {{-- <span class="input-group-btn">
                                                <button type="button" class="btn btn-pink w-sm waves-effect waves-light"
                                                    onclick="togglePassword('old_password')">
                                                    <i class="ion-eye"></i>
                                                </button>
                                            </span> --}}
                                            {{-- <div class="input-group-append">
                                            <span class="input-group-text toggle-password"
                                                onclick="togglePassword('confirm_password')">
                                                <i class="ion-eye"></i>
                                            </span>
                                        </div> --}}
                                            @error('old_password')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="new_password">New password</label>
                                        {{-- <div class="input-group"> --}}
                                            <input type="password" class="form-control" id="new_password"
                                                name="new_password" placeholder="Enter New Password" required>
                                            {{-- <span class="input-group-btn">
                                                <button type="button" class="btn btn-pink w-sm waves-effect waves-light"
                                                    onclick="togglePassword('new_password')">
                                                    <i class="ion-eye"></i>
                                                </button>
                                            </span> --}}
                                            @error('new_password')
                                                {{ $message }}
                                            @enderror
                                        {{-- </div> --}}
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="confirm_password">Re-enter New password</label>
                                        {{-- <div class="input-group"> --}}
                                            <input type="password" class="form-control" id="confirm_password"
                                                name="confirm_password" placeholder="Re-enter New Password" required>
                                            {{-- <span class="input-group-btn">
                                                <button type="button" class="btn btn-pink w-sm waves-effect waves-light"
                                                    onclick="togglePassword('confirm_password')">
                                                    <i class="ion-eye"></i>
                                                </button>
                                            </span> --}}
                                            @error('confirm_password')
                                                {{ $message }}
                                            @enderror
                                        {{-- </div> --}}
                                    </div>
                                    {{-- <span class="input-group-btn">
                                                    <button type="submit" class="btn btn-pink w-sm waves-effect waves-light">
                                                        Reset
                                                    </button>
                                                </span> --}}
                                    <button type="submit" class="btn btn-pink w-sm waves-effect waves-light">
                                        Change
                                    </button>
                            </div>
                            {{-- </div> --}}

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('service_provider/assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript"
        src="{{ asset('service_provider/assets/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script type="text/javascript"
        src="{{ asset('service_provider/assets/plugins/jquery-validation/dist/additional-methods.min.js') }}"></script>

    <script type="text/javascript">
        function togglePassword(inputId) {
            var x = document.getElementById(inputId);
            var icon = document.querySelector(`[data-toggle="${inputId}"] i`);

            if (x.type === "password") {
                x.type = "text";
                icon.classList.remove("ion-eye");
                icon.classList.add("ion-eye-disabled");
            } else {
                x.type = "password";
                icon.classList.remove("ion-eye-disabled");
                icon.classList.add("ion-eye");
            }
        }

        $("#password_form").validate({

            rules: {

                old_password: {
                    required: true,

                },

                new_password: {
                    required: true,
                    strongPassword: true

                },

                confirm_password: {
                    required: true,
                    strongPassword: true,
                    equalTo: "#new_password",

                },
            },

            messages: {
                old_password: {
                    required: "Please enter your old password",

                },

                new_password: {
                    required: "Please enter new password",

                },

                confirm_password: {
                    required: "Please confirm the password",

                },
            }
        });
    </script>
@endsection
