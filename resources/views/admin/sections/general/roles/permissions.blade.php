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
                                    <span class="text-lg font-weight-bold">Manage {{ $role->name }}'s Permissions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('admin.role.permissions.index', $role) }}" method="post">
                    <div class="table-responsive">
                        @foreach($permissions as $group => $groupPermissions)
                        <div class="card elevation-0">
                                @csrf
                                <div class="card-body  py-2">
                                    <span class="text-bold">{{ ucwords($group) }} Permissions</span>
                                    <hr class="my-2">
                                    <div class="row">
                                        @foreach($groupPermissions as $permission)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label><input type="checkbox" data-bootstrap-switch name="permissions[]" value="{{ $permission->id }}" @checked(in_array($permission->id, $rolePermissions))/> <span>{{ ucwords(str_replace('.',' ',$permission->name)) }}</span></label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success btn-sm">Update Permissions</button>
                    </div>
                </form>

            </div>
        </section>
    </div>
    @push('script')
    <script>
        function deleteCourseModal(courseId)
        {
            $("#delete-course-id").val(courseId);
            $("#delete-course").modal('show');
        }
    </script>
    @endpush
@endsection
