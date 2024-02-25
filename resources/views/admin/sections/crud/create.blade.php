
@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-plus-circle"></i> Create a receipt</h3>
                                <div class="card-tools">
                                </div>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6 d-flex flex-column align-items-center justify-content-center">
                                                    <label for="image_input_field">Hospital logo (optional)</label><br>
                                                    <img src="{{ asset('admin/img/placeholder.png')}}"
                                                         class="img-fluid img-circle"
                                                         style="border: 5px solid lightgrey;width: 150px;height: 150px"
                                                         alt=""
                                                         id="image_preview">
                                                     <br>
                                                    <input type="file" id="image_input_field" class="mt-1" name="society_logo"><br>
                                                    @error('society_logo')
                                                    <span class="text-danger text-sm pull-right">{{$errors->first('society_logo')}}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="name">Name</label>
                                                                <input type="text" id="name" name="name" class="form-control"
                                                                       value="{{old('name')}}"
                                                                       placeholder="Enter ">
                                                                @error('name')
                                                                <span class="text-danger text-sm pull-right">{{$errors->first('name')}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="text" id="email" name="email" class="form-control"
                                                                       value="{{old('email')}}"
                                                                       placeholder="Enter ">
                                                                @error('email')
                                                                <span class="text-danger text-sm pull-right">{{$errors->first('email')}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="contact">Contact</label>
                                                                <input type="number" id="contact" name="contact" class="form-control"
                                                                       value="{{old('contact')}}"
                                                                       placeholder="Enter ">
                                                                @error('contact')
                                                                <span class="text-danger text-sm pull-right">{{$errors->first('contact')}}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <textarea class="form-control" rows="1" id="address" name="address"
                                                                  placeholder="Enter ">{{old('address')}}</textarea>
                                                        @error('address')
                                                        <span
                                                            class="text-danger text-sm pull-right">{{$errors->first('address')}}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group float-right">
                                                      <label for="status">Status</label><br>
                                                      <input type="hidden" name="status" value="0">
                                                      <input type="checkbox" id="status" name="status"
                                                             class="bt-switch"
                                                             data-size="small" data-on-text="Yes" data-off-text="No"
                                                             value="1"
                                                             {{old('status')==1?'checked="checked"':''}}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="float-right">
                                                <button class="btn btn-info"><i class="fas fa-save"></i> Save Record</button>
                                            </div>
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
