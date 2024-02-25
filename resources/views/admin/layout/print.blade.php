<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <title>{{$title}}</title>--}}
{{--    <link rel="icon" type="image/png" href="{{asset('admin/img/favicon.png')}}">--}}
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('admin/plugins')}}/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/css/adminlte.min.css">
            {{-- <link rel="stylesheet" href="{{asset('admin')}}/css/rtl-css.css"> --}}

    @stack('css')
    {{-- <style type="text/css" media="print">
        @page {
            size: landscape;
        }
        body {
            transform: rotate(90deg);
            transform-origin: left top;
            writing-mode: tb-rl;
            height: 100%;
        }
        .container {
            transform: rotate(-90deg);
            transform-origin: left top;
        }
    </style> --}}

</head>
<body onload="window.print()">

@yield('content')
<script src="{{asset('admin/plugins')}}/jquery/jquery.min.js"></script>
<script src="{{asset('admin/plugins')}}/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{asset('admin/plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>