@extends('service_provider.layout.main')
@section('main-container')
@section('title', 'Dashboard')

@section('dashboard', 'active');
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title">Dashboard</h4>
                    <ol class="breadcrumb">

                    </ol>
                    {{-- <p class="text-muted page-title-alt">Welcome {{ auth()->user()->id }}</p> --}}
                </div>
            </div>

            <div class="row">

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

                <div class="col-md-6 col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-icon-purple pull-left">
                            <i class="md md-equalizer text-purple"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b
                                    class="counter">{{ DB::table('order')->where('is_deleted', 0)->count('id') }}</b>
                            </h3>
                            <a href="{{ route('order-list') }}">
                                <p class="text-muted">Orders</p>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-icon-purple pull-left">
                            <i class="md md-equalizer text-purple"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b
                                    class="counter">{{ DB::table('order')->where('is_deleted', 0)->where('date', '>=', now())->count('id') }}</b>
                            </h3>
                            <a href="{{ route('order-list') }}">
                                <p class="text-muted">Upcoming Orders</p>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="widget-bg-color-icon card-box">
                        <div class="bg-icon bg-icon-purple pull-left">
                            <i class="md md-equalizer text-purple"></i>
                        </div>
                        <div class="text-right">
                            <h3 class="text-dark"><b
                                    class="counter">{{ DB::table('order')->where('is_deleted', 0)->where('date', '<', now())->count('id') }}</b>
                            </h3>
                            <a href="{{ route('order-list') }}">
                                <p class="text-muted">Past Orders</p>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

            </div>

        </div> <!-- container -->

    </div> <!-- content -->

    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
@endsection
