@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card elevation-0 mt-3">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-lock"></i> Update Password
                                </h3>
                            </div>
                        </div>
                        <div class="card elevation-0 mt-3">
                            <form action="{{route('admin.store-password')}}" method="POST">
                                @csrf
                                @method('post')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 pt-2">
                                            <label for="">Current Password*</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="current_password" placeholder="Current Password" id="current-password-input" value="{{ old('current_password')}}">
                                                <div class="input-group-append" onclick="togglePassword('current-password-input')">
                                                    <div class="input-group-text">
                                                        <span  class="fas fa-eye"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('current_password')
                                            <span class="text-danger text-sm pull-right">{{ $errors->first('current_password') }}</span>
                                            @enderror
                                        </div>
                                    
                                        <div class="col-md-12 pt-2">
                                            <label for="">Change Password*</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="change_password" placeholder="Change Password" id="change-password-input" value="{{ old('change_password')}}">
                                                <div class="input-group-append" onclick="togglePassword('change-password-input')">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-eye"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('change_password')
                                            <span class="text-danger text-sm pull-right">{{ $errors->first('change_password') }}</span>
                                            @enderror
                                        </div>
                                    
                                        <div class="col-md-12 pt-2">
                                            <label for="">Confirm Password*</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" id="confirm-password-input" value="{{ old('confirm_password')}}">
                                                <div class="input-group-append" onclick="togglePassword('confirm-password-input')">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-eye"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            @error('confirm_password')
                                            <span class="text-danger text-sm pull-right">{{ $errors->first('confirm_password') }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12 pt-3">
                                        <div class="d-flex float-right">
                                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>
                                                Update Password
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<script>
    function togglePassword(inputId) {
        var input = document.getElementById(inputId);

        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
</script>
