<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UniSocial Solutions Admin | {{$title}}</title>
    
    <link rel="icon" type="image/png" href="{{asset('admin/img/favicon.png')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('admin/plugins')}}/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/css/adminlte.min.css">
    <link rel="stylesheet" href="{{asset('admin/plugins')}}/select2/css/select2.css">
    <link rel="stylesheet" href="{{asset('admin/plugins')}}/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="{{asset('admin/plugins')}}/toastr/toastr.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/css/custom.css">
    @stack('css')
    @livewireStyles
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                    <img 
                    src="{{ auth('admin')->user()->avatar_url}}"
                    style="width: 32px;height: 32px;border: 1px solid grey" class="img-circle" alt="User Image">
                </a>
            </li>
        </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{route('admin.dashboard')}}" class="brand-link elevation-4  text-center"
           style="background-color: #f0f1ef">
            <span class="">
                <img style="max-height: 38px" src="{{ asset('admin/img/admin-banner-image.png') }}" alt="AURA Logo" class="img-fluid" style="opacity: .8">
            </span>
            {{-- <span class="font-weight-light" style="color: black"></span> --}}
                
            </span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ auth('admin')->user()->avatar_url}}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block" style="color: black">{{ auth('admin')->user()->name }}</a>
                </div>
            </div>
            <nav class="mt-2">
                
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @if(auth('admin')->user()->can('dashboard.view') || auth('admin')->user()->hasRole('society user'))
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}" class=" nav-link {{$menu_active == 'dashboard' ? 'active' : ''}} text-white">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @endif

                    <li class="nav-item has-treeview {{ ($menu_active == 'admin_users' || $menu_active == 'roles') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ ($menu_active == 'admin_users' || $menu_active == 'roles') ? 'active' : '' }} parent-menu">
                          <i class="nav-icon fas fas fa-user-tag"></i>
                          <p>
                            GENERAL
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @if(checkAdminPermissions('SuperAdmin', 'roles.view') )
                            <li class="nav-item">
                                <a href="{{route('admin.roles')}}" class=" nav-link {{$menu_active == 'roles' ? 'active' : ''}} text-white">
                                    <i class="nav-icon fas fa-arrow-right"></i>
                                    <p>
                                        Roles
                                    </p>
                                </a>
                            </li>
                            @endif
                            @if(checkAdminPermissions('SuperAdmin', 'users.view') )
                            <li class="nav-item">
                                <a href="{{route('admin.user.index')}}" class=" nav-link {{$menu_active == 'admin_users' ? 'active' : ''}} text-white">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                    </p>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{ ($menu_active == 'password' || $menu_active == 'setting') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ ($menu_active == 'password' || $menu_active == 'setting') ? 'active' : '' }} parent-menu">
                          <i class="nav-icon fas fas fa-cogs"></i>
                          <p>
                            CONFIGURATION
                            <i class="right fas fa-angle-left"></i>
                          </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.setting')}}" class="nav-link {{$menu_active == 'setting' ? 'active' : ''}} text-white">
                                    <i class="nav-icon fas fa-arrow-right"></i>
                                    <p>
                                        Setting
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.update-password')}}" class="nav-link {{$menu_active == 'password' ? 'active' : ''}} text-white">
                                    <i class="nav-icon fas fa-arrow-right"></i>
                                    <p>
                                        Update Password
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
    @yield('content')
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0.
        </div>
        <strong>Copyright &copy; {{@date('Y')}} <a href="#">
            </a>.</strong> All rights reserved.
    </footer>

    <aside class="control-sidebar control-sidebar-dark">
        <div class="card" style="border-radius: 0px">
            <div class="card-body">
                <div class="align-items-center d-flex p-0 user-panel">
                    <div class="image mt-n3">
                        <img src="{{ auth('admin')->user()->avatar_url}}" class="img-circle elevation-2"
                             alt="User Image">
                    </div>
                    <div class="info">
                        <span class="d-flex flex-column text-black-50">
                            <b>{{ auth('admin')->user()->name }}</b>
                            <span class="mt-n1" style="font-size: small">{{auth('admin')->user()->email}}</span>
                        </span>
                        <form action="{{route('admin.logout')}}" method="post">
                            @csrf
                            <button class="btn btn-danger btn-xs">
                                <i class="fas fa-power-off"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">

            <li class="nav-item">
                <a href="{{route('admin.update-password')}}" class="nav-link text-white">
                    <i class="nav-icon fas fa-lock"></i>
                    <p>
                        Update Password
                    </p>
                </a>
            </li>

        </ul>
    </aside>
</div>
<script src="{{asset('admin/plugins')}}/jquery/jquery.min.js"></script>
<script src="{{asset('admin/plugins')}}/jquery-ui/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{asset('admin/plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('admin')}}/js/adminlte.min.js"></script>
<script src="{{asset('admin/plugins')}}/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="{{asset('admin/plugins')}}/select2/js/select2.full.min.js"></script>
<script src="{{asset('admin/plugins')}}/summernote/summernote-bs4.min.js"></script>
<script src="{{asset('admin/plugins')}}/toastr/toastr.min.js"></script>
@livewireScripts
@stack('script')
<script>
    $(function () {
        $('.bt-switch').bootstrapSwitch();
        $('.select2').select2();
        $('#image_input_field').change(function () {
            preview_img(this, $('#image_preview'));
        });
        $('#image_input_field_2').change(function () {
            preview_img(this, $('#image_preview_2'));
        });
        toastr.options = {
            "debug": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000
        }
        @if(session()->has('success'))
            toastr.success('{{session()->get('success')}}')
        @endif
        @if(session()->has('error'))
            toastr.error('{{session()->get('error')}}')
        @endif
    })

    function preview_img(input, img) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                img.attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>
