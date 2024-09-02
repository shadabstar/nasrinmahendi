<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="{{ asset('service_provider/assets/images/favicon_1.ico') }}">

    <title>ServaGO Login</title>

    <link href="{{ asset('service_provider/assets/plugins/bootstrapvalidator/src/css/bootstrapValidator.css') }}"
        rel="stylesheet" type="text/css" />

    <link href="{{ asset('service_provider/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('service_provider/assets/js/modernizr.min.js') }}"></script>

</head>

<body>

    <div class="account-pages"></div>
    <div class="clearfix"></div>

    <div class="wrapper-page">
        <div class="card-box">
            <div class="panel-heading">
                <h3 class="text-center"> Register to <strong class="text-custom">ServaGO</strong></h3>
            </div>

            <div class="panel-body">
                <div class="row">
                    <form class="form-horizontal m-t-20" id="service_provider_form"
                        action="{{ route('service-provider-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required name="name" id="name"
                                    value="{{ old('name') }}" placeholder="Enter Your Name">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" name="mobile" id="mobile"
                                    value="{{ old('mobile') }}" placeholder="Enter Mobile Number">
                                @error('mobile')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="email" required="" name="email" id="email"
                                    value="{{ old('email') }}" placeholder="Enter Email">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" name="password"
                                    id="password" value="{{ old('password') }}" placeholder="Enter Password">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" name="confirm_password"
                                    id="confirm_password" value="{{ old('confirm_password') }}"
                                    placeholder="Re Enter Password">
                                @error('confirm_password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox">
                                    <label for="checkbox-signup"> <small>By Sign up, you agree with our <span
                                                class="text-danger">Terms & Conditions</span> and <span
                                                class="text-danger"> Privacy Policy<span></small></label>
                                </div>

                            </div>
                        </div> --}}

                        <div class="form-group ">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" name="checkbox_signup" type="checkbox">
                                    <!-- Added name attribute -->
                                    <label for="checkbox-signup">
                                        <small>By signing up, you agree with our
                                            <span class="text-danger">Terms & Conditions</span> and
                                            <span class="text-danger">Privacy Policy</span>
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block waves-effect waves-light" type="submit">
                                    Create an account
                                </button>
                            </div>
                        </div>

                        <div class="form-group m-t-20 m-b-0 text-center">
                            <div class="col-sm-12">
                                <i class="fa fa-user m-r-5"></i>Already have an account?
                                <a href="{{ route('service-provider-loginget') }}" class="text-dark">
                                    SignIn</a>
                            </div>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>

    <script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="{{ asset('service_provider/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/detect.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/waves.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/jquery.scrollTo.min.js') }}"></script>


    <script src="{{ asset('service_provider/assets/js/jquery.core.js') }}"></script>
    <script src="{{ asset('service_provider/assets/js/jquery.app.js') }}"></script>

    <script type="text/javascript" src="{{ asset('service_provider/assets/plugins/parsleyjs/dist/parsley.min.js') }}">
    </script>
    <script type="text/javascript"
        src="{{ asset('service_provider/assets/plugins/jquery-validation/dist/jquery.validate.min.js') }}"></script>

    <script type="text/javascript"
        src="{{ asset('service_provider/assets/plugins/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('service_provider/assets/js/form.submit.js') }}"></script>


    <script type="text/javascript">
        $("#service_provider_form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                    letterswithbasicpunc: true
                },
                country_code: {
                    required: true
                },
                mobile: {
                    required: true,
                    mobileIND: true,
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    strongPassword: true,
                },
                confirm_password: {
                    required: true,
                    equalToPassword: true
                },
                checkbox_signup: { // Adding checkbox validation
                    required: true
                },

            },

            messages: {
                name: {
                    required: "Please enter your name",
                    minlength: "Minimum 3 charector required",
                    nowhitespace: "No white space allowed",
                    maxlength: "Maximum 100 charector allowed for name",
                    letterswithbasicpunc: "Enter letters only"
                },
                country_code: {
                    required: "Please select the country code"
                },

                mobile: {
                    required: "Pleas enter mobile number",
                },

                email: {
                    required: "Pleae enter email",
                    email: "Please specify a valid email"
                },

                password: {
                    required: "Plrase enter password"
                },
                confirm_password: {
                    required: "Please re-enter password"
                },
                checkbox_signup: { // Checkbox error message
                    required: "You must agree with our Terms & Conditions and Privacy Policy"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "checkbox_signup") {
                    error.insertAfter(element.closest('.checkbox')); // Places error message below checkbox
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                submitForm(form);
            }
        });
    </script>

</body>

</html>
