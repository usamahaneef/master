@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content py-2">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card elevation-0">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <span class="text-lg font-weight-bold">Manage Roles</span>
                                    <button data-toggle="modal" data-target="#add-new-role" class="btn btn-outline-success btn-sm"><i class="fas fa-plus"></i> Add Role</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card elevation-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Users</th>
                                        <th class="text-center">Permissions</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        @if($role->name != 'society user')
                                        <tr>
                                            <td>
                                                <span class="font-weight-bold px-2">{{ $role->name }}</span>
                                            </td>
    
                                            <td>
                                                <span class="font-weight-bold">{{ $role->users_count }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-info">{{ $role->permissions_count }}</span>
                                            </td>
                                            <td class="text-right">
                                                <a title="Permissions" href="{{route('admin.role.permissions.index' , $role)}}" style="cursor: pointer;" class="btn btn-outline-success btn-xs"><i class="fas fa-user-edit"></i></a>
                                                <a title="Edit Role" onclick="editRoleModal({{ $role->id }},'{{ $role->name }}')" style="cursor: pointer;" class="btn btn-outline-success btn-xs"><i class="fas fa-edit"></i></a>
                                                <button title="Delete Role" onclick="deleteRoleModal({{ $role->id }})" class="btn btn-outline-danger btn-xs"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="edit-role" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Role</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="accept-enrollment-form" action="{{route('admin.role.update')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <input id="edit-role-id" type="hidden" name="edit_role_id" value="" />
                            <div class="form-group">
                                <label>Role Name</label>
                                <input id="edit-role-name" class="form-control" name="edit_role_name" placeholder="Name" value="{{ old('edit_role_name') }}" />
                                @error('add_role_name')
                                    <span class="text-danger text-sm"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-trash"></i> Update Role</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
        <div class="modal fade" id="delete-role" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirmation!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="accept-enrollment-form" action="{{route('admin.role.delete')}}" method="post">
                        @csrf
                        @method('delete')
                        <div class="modal-body">
                            <input id="delete-role-id" type="hidden" name="delete_role_id" value="" />
                            <div class="form-group">
                                <label>Are you sure you want to delete this role?</label>
                                <span id="accept_error" class="text-sm text-danger"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete Role</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="add-new-role" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Role</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('admin.role.add')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Role Name</label>
                                    <input class="form-control" name="add_role_name" placeholder="Name" value="{{ old('add_role_name') }}" />
                                    @error('add_role_name')
                                        <span class="text-danger text-sm"> {{ $message }} </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">Add Role</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
@endsection
@push('script')
<script>
    $(function(){
        if ("{{ session()->has('modal') ?? '0'}}" == "1") {
            $("#{{session()->get('modal')}}").modal('show');
        }
    })

    $(document).on('click', '[data-dismiss="modal"]', function (e) {
        e.target.closest('.modal-dialog').querySelectorAll('.text-danger').forEach(el => el.remove());
    });

    function deleteRoleModal(roleId)
    {
        $("#delete-role-id").val(roleId);
        $("#delete-role").modal('show');
    }
    function editRoleModal(roleId, roleName)
    {
        console.log(roleName);

        $("#edit-role-id").val(roleId);
        $("#edit-role-name").val(roleName);
        $("#edit-role").modal('show');
    }
</script>
@endpush