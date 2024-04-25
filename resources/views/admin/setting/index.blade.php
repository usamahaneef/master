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
                                    <i class="fas fa-info-circle"></i> Personal Information
                                </h3>
                            </div>
                            <form action="{{route('admin.setting-update')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div
                                                    class="col-md-12 py-3 mb-3 d-flex flex-column align-items-center justify-content-center">
                                                    <img src="{{ auth('admin')->user()->avatar_url}}"
                                                         class="img-fluid img-circle"
                                                         style="border: 5px solid lightgrey;width: 150px;height: 150px"
                                                         alt=""
                                                         id="image_preview">
                                                    <input type="file" name="avatar" id="image_input_field">
                                                    <span class="mt-2"></span>
                                                    <b></b>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="first_name">Name</label>
                                                        <input type="text" id="first_name" name="first_name"
                                                            class="form-control"
                                                            value="{{auth('admin')->user()->name}}"
                                                            placeholder="Enter First Name">

                                                        @error('first_name')
                                                        <span
                                                            class="text-danger text-sm pull-right">{{$errors->first('first_name')}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <p></p>
                                    <div class="d-flex float-right">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>
                                            Update Profile
                                        </button>
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
