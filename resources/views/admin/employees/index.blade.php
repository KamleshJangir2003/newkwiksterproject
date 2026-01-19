@extends('admin.common.app')

@section('main')
<style>
    .content-wrapper {
    margin-left: 220px; /* jitna chaho badha sakte ho */
}

</style>

<div class="content-wrapper">
    <div class="container-fluid p-4">

        <h3 class="mb-3">Employees</h3>

        <a href="#" class="btn btn-primary mb-3">+ Add Employee</a>

        <div class="card">
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Rahul Sharma</td>
                            <td>rahul@example.com</td>
                            <td>Agent</td>
                            <td>
                                <button class="btn btn-sm btn-warning">Edit</button>
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@endsection
