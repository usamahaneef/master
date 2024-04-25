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
                        @if(session('success'))
                            <h5 class="fw-bold text-info">Note: {{ session('success') }}</h5>
                        @else
                            <h5 class="fw-bold">Enter email to receive password link</h5>
                        @endif                    
                    </div>
                    <div class="card-body login-card-body">
                        <form action="{{route('admin.forgot.password.send-email')}}" method="POST">
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
                            <div class="row mt-3">
                                <div class="px-2 ">
                                    <button type="submit" class="btn btn-primary btn-sm float-right">Send Reset Link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
