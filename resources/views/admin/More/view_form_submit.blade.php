@extends('admin.common.app')
@section('css')
    <style>
        .pagination nav {
            display: inline-block;
        }

        .pagination nav div {
            display: inline-block;
        }

        .pagination nav div span {
            display: inline-block;
            margin-top: 10px;
        }

        .pagination nav div a {
            display: inline-block;
            font-size: 15px;
            min-width: 40px;
            width: auto;
            background-color: #004274 !important;
            color: white;
        }

        .pagination nav div p {
            display: none;
        }
    </style>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional styling for dropdown */
        .dropdown-menu {
            min-width: auto;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
@section('main')
   
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            {{-- <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">View form submit</h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> --}}
        </div>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">

                        <div class="page-content-wrapper">
                            <!-- show success and error messages -->
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </div>
                            @endif
                            <!-- End show success and error messages -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="form-group row">
                                            <div class="form-group" style="width:100%; margin-left:30px">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Agent ID</th>
                                                            <th scope="col">Company Name</th>
                                                            <th scope="col">Owner Name</th>
                                                            <th scope="col">DOT</th>
                                                            <th scope="col">Mobile no.</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Hauls</th>
                                                            <th scope="col">Truck VIN</th>
                                                            <th scope="col">Trailer VIN</th>
                                                            <th scope="col">Driver's Name</th>
                                                            <th scope="col">LN</th>
                                                            <th scope="col">DOB</th>
                                                            <th scope="col">Issued state</th>
                                                            <th scope="col">LIability</th>
                                                            <th scope="col">Cargo</th>
                                                            <th scope="col">Physical damage</th>
                                                            <th scope="col">Agent Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($datas))
                                                            @php $a = 0; @endphp
                                                            @foreach ($datas as $data)
                                                                @php $a++; @endphp
                                                                <tr>
                                                                    <th scope="row">{{ $a }}</th>
                                                                    <td>{{ $data->agent_id }}</td>
                                                                    <td>{{ $data->company_name }}</td>
                                                                    <td>{{ $data->owner }}</td>
                                                                    <td>{{ $data->DOT }}</td>
                                                                    <td>{{ $data->phone }}</td>
                                                                    <td>{{ $data->email }}</td>
                                                                    <td>{{ $data->Hauls }}</td>
                                                                    <td>{{ $data->Truck_VIN }}</td>
                                                                    <td>{{ $data->Trailer_VIN }}</td>
                                                                    <td>{{ $data->Driver_Name }}</td>
                                                                    <td>{{ $data->LN }}</td>
                                                                    <td>{{ $data->DOB }}</td>
                                                                    <td>{{ $data->Issued_state }}</td>
                                                                    <td>{{ $data->LIability }}</td>
                                                                    <td>{{ $data->Cargo }}</td>
                                                                    <td>{{ $data->Physical_damage }}</td>
                                                                    <td>{{ $data->Agent_Name }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{$datas->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- end row -->
                        </div>

                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('.dCnf').click(function(e) {
                            e.preventDefault();
                            var mydata = $(this).attr('mydata');
                            $('#cnfbox' + mydata).show();
                        });

                        $('.cans').click(function(e) {
                            e.preventDefault();
                            var mydata = $(this).attr('mydatas');
                            $('#cnfbox' + mydata).hide();
                        });
                    });
                </script>
            </div>
        </div>
    @endsection
