@extends('admin.layout.index')

@section('title') Dashboard @endsection
@section('css')
<link rel="stylesheet" href="{{ url('admin-assets/css/ecommerce.css') }}">
@endsection
@section('content')

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Dashboard </h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Info box -->
    <!-- ============================================================== -->

    @include('admin.common.flash')
    <!-- Main Content -->
    <section class="content home">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Dashboard
                        <small class="text-muted">Welcome to {{config('constant.PROJECT_NAME')}} Application</small>
                    </h2>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <ul class="breadcrumb float-md-right">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}"><i class="zmdi zmdi-home"></i> Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                    <div class="header">
                        <h2>Product Graph</h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                    aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more-vert"></i> </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">All On</a></li>
                                    <li><a href="javascript:void(0);">All Off</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <div id="bar_chart" class="graph"></div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        

        
    </section>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->

@endsection
@section('js')
<!-- Chart JS -->
<script src="{{ url('admin-assets/plugins/morrisjs/morris.js') }}"></script>


<script>
$(function () {
    "use strict";  
    initSparkline();
    
    getMorris('bar', 'bar_chart');
});


function getMorris(type, element) {
    console.log(type);
    if (type === 'bar') {
        Morris.Bar({
            element: element,
            data: {!!$graphData!!},

            xkey: 'x',
            ykeys: ['y', 'z'],
            labels: ['Visited', 'Purchased'],
            barColors: ['#40b988', '#f67a82'],
        });
    } 
}
</script>
@endsection