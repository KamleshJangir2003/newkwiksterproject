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
        <h4 >View Credentials</h4>
    
      <div class="row mt-4">
        <div class="col-lg-12 card rounded-0 p-4">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Name</th>
                <th>Pin</th>
            </tr>
        </thead>
        <tbody>
            @php
                    $i=1;
                    @endphp
            @foreach($pin as $p)
            <tr>
                <td>
                    @php
                    echo $i;
                    $i++;
                    @endphp
                </td>
                <td>
                    @php
                    $user= App\Models\user::find($p->user_id);
                    echo $user->name;
                    @endphp
                    </td>
                <td>{{$p->pin}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
        </div>
      </div>
    </div>
   
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$('#example').DataTable();
</script>




@endsection
