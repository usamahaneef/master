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
                        <h5 class="fw-bold" >Set password to start your session </h5>
                    </div>
                    @if(session('success'))
                    <div class="card-header">
                        <h5 class="fw-bold text-success">{{ session('success') }}</h5>
                    </div>
                    @endif
                    @php
                        $email = $_GET['email']; 
                    @endphp                
                    <div class="card-body login-card-body">
                        <form action="{{route('admin.password.reset')}}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email"
                                        value="{{$email}}"
                                        placeholder="Enter email address"
                                        {{$email ? 'readonly' : ''}}>
                            </div>
                            @error('email')
                            <span class="text-danger text-sm">{{$errors->first('email')}}</span>
                            @enderror
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"><br>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span onclick="password()" class="fas fa-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('password')
                            <span class="text-danger text-sm pull-right">{{$errors->first('password')}}</span>
                            @enderror
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span onclick="confirm_password()" class="fas fa-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('password_confirmation')
                            <span
                                class="text-danger text-sm pull-right">{{$errors->first('password_confirmation')}}</span>
                            @enderror
                            <p><span class="text-bold text-danger">Note*: </span><span class="text-sm">Password should contain Numbers, Alphabets, Special Characters and should be atleast 8 characters</span></p>
                            <div class="row mt-3">
                                <div class="px-2">
                                    <button type="submit" class="btn btn-primary btn-sm">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
<script>
    function password() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function confirm_password() {
        var x = document.getElementById("password_confirmation");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
