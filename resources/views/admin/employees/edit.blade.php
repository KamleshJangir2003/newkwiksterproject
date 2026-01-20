@extends('admin.common.app')

@section('main')
<style>
    .content-wrapper {
    margin-left: 220px;
}
</style>

<div class="content-wrapper">
    <div class="container-fluid p-4">

        <h3 class="mb-3">Edit Employee</h3>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $employee->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ $employee->email }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ $employee->phone }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="0" {{ $employee->role == 0 ? 'selected' : '' }}>Admin</option>
                                    <option value="1" {{ $employee->role == 1 ? 'selected' : '' }}>Agent</option>
                                    <option value="2" {{ $employee->role == 2 ? 'selected' : '' }}>Manager</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="designation">Designation</label>
                                <input type="text" name="designation" id="designation" class="form-control" value="{{ $employee->designation }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="male" {{ $employee->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $employee->gender == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Employee</button>
                    <a href="{{ route('employees') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection