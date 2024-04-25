@extends('auth.admin.layout')
@section('content')
    <div class="row" style="height: 100vh">
        <div class="col align-items-center justify-content-center d-none d-sm-flex" style="background-color: #d0ae3d">
            <img src="{{asset('admin/img/login-image.png')}}" alt="" style="" class="img-fluid">
        </div>
        <div class="col d-flex align-items-center justify-content-center bg-gray-light">
            <div class="login-box">
                <div class="card elevation-0">
                    <div class="card-header align-items-center" align="center">
                        <div class="d-block d-sm-none">
                            <img src="{{ asset('admin/img/login-logo.png') }}" class="w-50" alt="">
                        </div>
                        <h5 class="fw-bold">Log In to start your session </h5>
                    </div>
                    <div class="card-body login-card-body">
                        <form action="{{route('admin.login')}}" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            @error('email')
                            <span class="text-danger text-sm">{{$errors->first('email')}}</span>
                            @enderror
                            <div class="input-group mt-3">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>

                            </div>
                            @error('password')
                            <span class="text-danger text-sm pull-right">{{$errors->first('password')}}</span>
                            @enderror

                            <div class="row mt-3">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-3">
                            <div class="col-8">
                                <a href="" class="btn btn-sm btn-default">Forgot My Password</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
