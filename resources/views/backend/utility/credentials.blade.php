@extends('backend.common.layout')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" type="text">
<style>
.dataTables_filter{
    text-align:end;
}
</style>
@endsection
@section('content')
    <div class="container-fluid">
        <h4 >Store Credentials</h4>
    <div class="row">
       <form action="{{url('/store/credentials')}}" method="post" class="d-flex">
           @csrf
           
        <div class="col-lg-2">
            <div class="form-group">
                <input type="text" placeholder="Enter Platform" name="platform" class="form-control">
                </div>
        </div>
        <div class="col-lg-2">
             <div class="form-group ms-4">
                <input type="text" placeholder="Enter Username" name="username" class="form-control">
                </div>
        </div>
        <div class="col-lg-2">
             <div class="form-group  ms-4">
                <input type="text" placeholder="Enter Password" name="password" class="form-control">
                </div>
        </div>
        <div class="col-lg-2">
             <div class="form-group  ms-4">
                <input type="text" placeholder="Paste Link" name="link" class="form-control">
                </div>
        </div>
        <div class="col-lg-2">
             <div class="form-group  ms-4">
                <input type="submit" class="btn btn-primary w-100" value="Save">
                </div>
        </div>
        <!--<div class="col-lg-2">-->
        <!--     <div class="form-group  ms-4">-->
        <!--        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#myModal1">Generate PIN</button>-->
        <!--        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#myModal2">Change PIN</button>-->
        <!--        </div>-->
        <!--</div>-->
       </form>
    </div>
    
      <div class="row mt-4">
        <div class="col-lg-12 card rounded-0 p-4">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <!--<th>Pin</th>-->
                <th>PlatForm</th>
                <th>Username</th>
                <th>Password</th>
                <th>Link</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                    $i=1;
                    @endphp
            @foreach($cs as $c)
            <tr>
                <td>
                    @php
                    echo $i;
                    $i++;
                    @endphp
                </td>
                <!--<td><input type="password" class="form-control pin" placeholder="Default PIN 1234"></td>-->
                <td>{{$c->platform}}</td>
                <td>{{$c->username}}</td>
                <td>{{$c->password}}</td>
                <td><a href="{{$c->link}}" target="_blank">{{$c->link}}</a></td>
                <td><a href="{{url('/delete/credentials/'.$c->id)}}" onclick="return confirm('Are you sure ?');" class="btn btn-danger">Delete</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
        </div>
      </div>
    </div>
    <!-- Default Modals -->
<div id="myModal1" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
                <form action="{{url('/generate/pin')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{auth()->user()->id}}" name="user_id">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Generate PIN</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                     <div class="form-group">
                <input type="password" placeholder="Enter New PIN" name="new_pin" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary ">Save</button>
            </div>
                    </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="myModal2" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
                 <form action="{{url('/change/pin')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{auth()->user()->id}}" name="user_id">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Change Pin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                     <div class="form-group mb-3">
                <input type="password" placeholder="Enter Old PIN" name="old_pin" class="form-control">
                </div>
                     <div class="form-group">
                <input type="password" placeholder="Enter New PIN" name="new_pin" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary ">Save</button>
            </div>
                    </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$('#example').DataTable();
</script>
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        $('.pin').on('input', function () {-->
<!--            var enteredPin = $(this).val();-->
            var correctPin = "{{$pin->pin??'1234'}}"; // Change this to your desired PIN

<!--            if (enteredPin === correctPin) {-->
                // Change password input type to text when the correct PIN is entered
<!--                $(this).closest('tr').find('.show_password').prop('type', 'text');-->
<!--            } else {-->
                // Change password input type back to password when the PIN is incorrect
<!--                $(this).closest('tr').find('.show_password').prop('type', 'password');-->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->



@endsection
