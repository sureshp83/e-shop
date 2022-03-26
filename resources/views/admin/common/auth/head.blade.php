<!-- ============================================================== -->
<!-- login head file -->
<!-- ============================================================== -->

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!-- Favicon icon -->
<link rel="icon" href="{{url('admin-assets/images/')}}" type="image/x-icon">
<title>@yield('title') | {{ config('app.name') }}</title>
<!-- page css -->
 <!-- Custom Css -->
    <link rel="stylesheet" href="{{ url('admin-assets/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/authentication.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/color_skins.css') }}">
    <link rel="stylesheet" href="{{ url('admin-assets/css/custom_change.css') }}">
@yield('css')

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->