<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AURA</title>

    <link rel="icon" type="image/png" href="{{asset('admin/img/favicon.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('admin/plugins')}}/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{asset('admin/plugins')}}/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/css/adminlte.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/css/custom.css">
</head>
<body class="hold-transition">
@yield('content')
<script src="{{asset('admin/plugins')}}/jquery/jquery.min.js"></script>
<script src="{{asset('admin/plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('admin')}}/js/adminlte.min.js"></script>
</body>
</html>
