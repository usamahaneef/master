@extends('admin.layout.app')
@section('content')
    @push('styles')
    <style>
        span.select2.select2-container.select2-container--default
        {
            width: 100% !important;
        }
    </style>
    @endpush
    <div class="content-wrapper">
        <section class="content py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card elevation-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <span class="text-lg font-weight-bold">Manage Users</span>
                                    @can('users.create')
                                    <button data-toggle="modal" data-target="#add-new-user" class="btn btn-outline-success btn-sm"><i class="fas fa-plus"></i> Add User</button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card elevation-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5"><span class="text-lg text-bold">User</span></div>
                            <div class="col-md-5"><span class="text-lg text-bold">Role</span></div>
                            <div class="col-md-2"><span class="text-lg text-bold">Action</span></div>
                        </div>
                    </div>
                </div>
                @foreach($users as $user)
                    <div class="card elevation-0 my-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="d-flex">
                                        <img class="rounded-circle" width="34" height="34" src="{{ $user->avatar_url }}" />
                                        <div class="d-flex flex-column mx-2">
                                            <span class="font-weight-bold px-2">{{ $user->name }}</span>
                                            <span class="px-2 mt-n2">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <span class="font-weight-bold">{{ $user->role_to_display }}</span>
                                </div>
                                <div class="col-md-2">
                                    @if($user->role_to_display !== 'SuperAdmin')
                                        @can('users.permissions')
                                        <a title="Assign custom permissions" href="{{ route('admin.user.permissions.create', $user) }}" class="btn btn-xs btn-outline-info">
                                            <i class="fas fa-user-shield"></i>
                                        </a>
                                        @endcan
                                    @endif
                                    @can('users.edit')
                                    <a title="Edit User" onclick="editUserModal({{ $user->id }})" style="cursor: pointer;" class="btn btn-outline-success btn-xs"><i class="fas fa-edit"></i></a>
                                    @endcan
                                    @can('users.delete')
                                        <button title="Delete user" onclick="deleteUserModal({{ $user->id }})" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash"></i></button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
    <div class="modal fade" id="edit-user" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.user.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input id="edit-user-id" type="hidden" name="edit_user_id" value="" />
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input id="edit-user-first-name" class="form-control" name="edit_first_name" placeholder="First Name" value="{{ old('edit_first_name') }}" />
                                    @error('edit_first_name')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input id="edit-user-email" class="form-control" name="edit_email" placeholder="Email" value="{{ old('edit_email') }}" />
                                    @error('edit_email')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input id="admin-role" type="hidden" name="admin_role" value="" />
                                    <label for="">Role</label><br>
                                    <select  id="edit-user-role" class="form-control selectRole" name="edit_role" data-placeholder="Select Role" @disabled($user->editCheck?->role)>
                                        <option></option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" @selected(old('edit_role'))>{{ ucwords($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    <span id="admin-role-error" class="text-danger text-sm" style="display: none;"></span>
                                    @error('edit_role')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Upload Image</label>
                                    <input type="file" class="form-control" name="avatar" />
                                    @error('add_avatar')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Edit User</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="add-new-user" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.user.add') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input class="form-control" name="add_first_name" placeholder="First Name" value="{{ old('add_first_name') }}" />
                                    @error('add_first_name')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" class="form-control" name="add_email" placeholder="Email" value="{{ old('add_email') }}" />
                                    @error('add_email')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Role</label><br>
                                    <select class="form-control" name="role" data-placeholder="Select Role">
                                        <option></option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ ucwords($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('add_phone')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Upload Image</label>
                                    <input type="file" class="form-control" name="avatar" />
                                    @error('add_phone')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Add New User</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="delete-user" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.user.delete') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <input id="delete-user-id" name="delete_user_id" value="" type="hidden" />
                        <p>Are you sure you want to delete this user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger btn-sm">Delete User</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
@endsection
@push('script')
<script>
    $(document).on('click', '[data-dismiss="modal"]', function (e) {
        e.target.closest('.modal-dialog').querySelectorAll('.text-danger').forEach(el => el.remove());
    });

    var url = "{{ route('admin.user.index') }}";
    $(function(){
        if ("{{ Session::get('add_user_modal') }}" === "1") {
            $("#add-new-user").modal('show');
        }
        if ("{{ Session::get('edit_user_modal') }}" === "1") {
            console.log("{{ old('admin_role') }}");

            $("#edit-user-id").val("{{ old('edit_user_id') }}");
            $("#edit-user-first-name").val("{{ old('edit_first_name') }}");
            $("#edit-user-last-name").val("{{ old('edit_last_name') }}");
            $("#edit-user-email").val("{{ old('edit_email') }}");
            if ("{{ old('admin_role') }}" === "SuperAdmin") {
                $(".selectRole").prop('disabled', 'disabled');
                $("#admin-role-error").html("SuperAdmin Role cannot be edited");
                $("#admin-role-error").css("display","block");
            }else{
                $(".selectRole").val("{{old('edit_role')}}").change();
            }
            $("#edit-user").modal('show');
        }

    })
    function deleteUserModal(userId)
    {
        $("#delete-user-id").val(userId);
        $("#delete-user").modal('show');
    }
    function editUserModal(userId)
    {
        $(".selectRole").val("").change();
        $(".selectRole").prop("disabled","");
        $("#admin-role-error").css("display","none");
        var id = userId;
        $.ajax({
            type: 'GET',
            url: "{{ route('admin.user.edit') }}",
            data: {'user_id': id, 'token': 'NON_AUTH'},
            success: function (response) {
                var data = response.data
                if (response.status === 102 || response.status === 100) {
                    toastr.error(response.message)
                }
                else if(response.status === 101){

                    $("#edit-user-id").val(data.user.id);
                    $("#edit-user-first-name").val(data.user.name);
                    $("#edit-user-last-name").val(data.user.last_name);
                    $("#edit-user-email").val(data.user.email);
                    $("#admin-role").val(data.userRole ? data.userRole.name : "");
                    if (data.userRole) {
                        if (data.userRole.name === "SuperAdmin") {
                            $(".selectRole").prop('disabled', 'disabled');
                            $("#admin-role-error").html("SuperAdmin Role cannot be edited");
                            $("#admin-role-error").css("display","block");
                        }else{
                            $(".selectRole").val(data.userRole.id).change();
                        }
                    }
                    $('#edit-user').modal('show');
                }
            }
        });
    }
</script>
@endpush