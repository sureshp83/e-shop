<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="baseUrl" content="{{ url('/') }}">

    <!--=== Favicon ===-->
    
    
    <title>@yield('title') | Admin {{ config('app.name') }}</title>
    <!-- This page CSS -->
    <link rel="icon" href="{{url('admin-assets/images/')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{ url('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/plugins/jvectormap/jquery-jvectormap-2.0.3.css') }}"/>
    <link rel="stylesheet" href="{{ url('admin-assets/plugins/morrisjs/morris.css') }}" />
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ url('admin-assets/plugins/jquery-datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/color_skins.css') }}">
     
    <link href="{{ url('admin-assets/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" />
    <!-- Sweetalert Css -->
    <link href="{{ url('admin-assets/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ url('admin-assets/css/custom_change.css') }}">
    
    <!-- <link href="{{ url('admin-assets/sweetalert/sweetalert.css') }}" rel="stylesheet" /> -->

<style>
    .attribute_div,.attr_combination_div {
        border:solid gray;
    }
</style>

@yield('css')