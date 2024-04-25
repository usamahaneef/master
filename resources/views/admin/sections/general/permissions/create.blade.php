@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card elevation-0">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-bars"></i> Societies</h3>
                                <div class="card-tools">
                                   
                                </div>
                            </div>
                            <form action="{{route('admin.user.permissions.societies', $user)}}" method="POST">
                                @csrf
                                <div class="card-body">
                                   <div class="form-group">
                                       <label for="societies_id"> Societies</label>
                                       <select id="societies_id" name="societies_id[]" class="form-control select2" multiple="multiple" 
                                               data-placeholder="Select Societies">
                                           @foreach($societies as $society)
                                               <option
                                                   value="{{$society->id}}" {{in_array($society->id ,$societyPermissions->permission_id ?? []) ? 'selected' : ''}}>{{$society->name}}
                                               </option>
                                           @endforeach
                                       </select>
                                       @error('societies_id')
                                       <span class="text-danger text-sm pull-right">{{$errors->first('societies_id')}}</span>
                                       @enderror
                                   </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary float-right"> <i class="fas fa-save"></i> Update Permissions</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card elevation-0">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-bars"></i> Venues</h3>
                                <div class="card-tools">
                                   
                                </div>
                            </div>
                            <form action="{{route('admin.user.permissions.venues', $user)}}" method="POST">
                                @csrf
                                <div class="card-body">
                                   <div class="form-group">
                                    <label for="venues_id">Venues</label>
                                    <select id="venues_id" name="venues_id[]" class="form-control select2" multiple="multiple" data-placeholder="Select Venues">
                                        @foreach($venues as $venue)
                                            <option value="{{ $venue->id }}" {{  in_array($venue->id, $venuesPermissions->permission_id ?? [])? 'selected' : '' }}>
                                                {{ $venue->venue_name}}
                                            </option>
                                        @endforeach
                                    </select>
                    
                                    @error('venues_id')
                                    <span class="text-danger text-sm pull-right">{{$errors->first('venues_id')}}</span>
                                    @enderror
                                </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-sm btn-primary float-right"> <i class="fas fa-save"></i> Update Permissions</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
