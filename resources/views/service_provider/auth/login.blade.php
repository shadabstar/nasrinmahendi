<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="{{ asset('service_provider/assets/images/favicon_1.ico') }}">

    <title>Service Provider Login</title>

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
                <h3 class="text-center"> Sign In to <strong class="text-custom">ServaGO</strong></h3>
            </div>

            <div class="panel-body">
                @if (session('success'))
                    <div class="alert alert-danger alert-dismissible">
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
                <form class="form-horizontal m-t-20" action="{{ route('service-provider-loginpost') }}" method="post">
                    @csrf
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" required="" name="email"
                                placeholder="Email">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" name="password"
                                placeholder="Password">
                                @error('password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Remember me </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-pink btn-block waves-effect waves-light"
                                type="submit" style="font-size: 18px">
                                Log In
                            </button>
                        </div>
                    </div>

                    <div class="form-group m-t-20 m-b-0">
                        <div class="col-sm-12">
                         {{-- <a href="page-recoverpw.html" class="text-danger"><i class="fa fa-lock m-r-5"></i> Forgot
                                password?</a><br> --}}
                                {{-- <i class="fa fa-user m-r-5"></i>Don't  have an account?
                                <a  href="{{route('service-provider-create')}}" class="text-dark">
                                    SignUp</a> --}}
                        </div>
                    </div>

                </form>

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


    <script type="text/javascript">
        $(document).ready(function() {
            $('form').parsley();
        });
    </script>

</body>

</html>
