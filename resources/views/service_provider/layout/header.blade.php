<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
    <meta name="author" content="Coderthemes">

    <link rel="shortcut icon" href="{{ asset('service_provider/assets/images/favicon_1.ico') }}">

    {{-- <title>My Order:</title>
     --}}
     <title> {{env('APP_NAME')}} : @yield('title', 'My order')</title>

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('service_provider/assets/plugins/morris/morris.css') }}">
    {{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">  --}}
    {{-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">  --}}
    <link href="{{ asset('service_provider/assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('service_provider/assets/plugins/yajra_datatable/yajra_datatable.bootstrap4.min.css') }}">
    {{-- <link href="{{ asset('service_provider/assets/plugins/yajra_datatable/yajra_datatable.min.css') }}"> --}}
    <link href="{{ asset('service_provider/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/core.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/components.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('service_provider/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('service_provider/assets/js/modernizr.min.js') }}"></script>


    {{-- //sweetalert --}}
    <link href="{{ asset('service_provider/assets/plugins/sweetalert/dist/sweetalert.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('service_provider/assets/plugins/timepicker/bootstrap-timepicker.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('service_provider/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css') }}"
        rel="stylesheet">


</head>
