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
<style>
    .clickable-cell {
    cursor: pointer;
}
    </style>
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
        </div>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            <div class="col-lg-12">
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
                                <div class="card" id="leadsList">
                                    <div class="card-header border-0">
                                        <form method="get">
                                        <div class="row g-4 align-items-center">
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="text" name="search_input" class="form-control search" placeholder="Search for..." value="{{ isset($_GET['search_input']) ? $_GET['search_input'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="text" name="row_pegi" class="form-control search" placeholder="Select rows" value="{{ isset($_GET['row_pegi']) ? $_GET['row_pegi'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    @php
                                                    $users = App\Models\User::where('is_active',1)->where('status',1)->get();
                                                    @endphp
                                                    <select name="agent" class="form-control search">
                                                        <option value="">search Agent</option>
                                                        @foreach($users as $user)
                                                        @php
                                                            $userDetails = App\adminmodel\Users_detailsModal::where('ajent_id', $user->id)->first();
                                                            $name = !empty($userDetails) ? $userDetails->alise_name : $user->name;
                                                        @endphp
                                                        <option value="{{ $user->id }}" {{ isset($_GET['agent']) && $_GET['agent'] == $user->id ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="date" name="date1" class="form-control search" placeholder="Search for..." value="{{ isset($_GET['date1']) ? $_GET['date1'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <p style="margin-bottom:0px">To</p>
                                            <div class="col-sm-2">
                                                <div class="search-box">
                                                    <input type="date" name="date2" class="form-control search" placeholder="Search for..." value="{{ isset($_GET['date2']) ? $_GET['date2'] : '' }}">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                            <button type="submit" class=" btn-success" style="margin-right:5px"><i class="ti-search"></i></button> 
                                            <button type="button"  class=" btn-danger" onclick="window.location.href='{{route('newinterstedleads')}}'"><i class="fa-solid fa-circle-xmark"></i>clear</button>
                                               
                                            </form>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="form-group row">
                                            <div class="form-group" style="width:100%; margin-left:30px">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">S.No.</th>
                                                            <th scope="col">Agent Name</th>
                                                            <th scope="col">Company Name</th>
                                                            <th scope="col">Phone</th>
                                                            <th scope="col">Email</th>
                                                            <th scope="col">Trucks</th>
                                                            <th scope="col">Drivers</th>
                                                            <th scope="col">Comment</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($datas->isNotEmpty())
                                                            @php $a = 0;   @endphp
                                                            @foreach ($datas as $data)
                                                                @php $a++; @endphp
                                                                <tr>
                                                                    <th scope="row">
                                                                        {{ $a }}
                                                                    </th>
                                                                    <th>
                                                                         @php
                                                                        $user = App\adminmodel\Users_detailsModal::where('ajent_id',$data->agent_id)->first();
                                                                        if(!empty($user)){
                                                                            $name = $user->alise_name;
                                                                        }
                                                                        else{
                                                                            $name =  $data->agent_id;
                                                                        }
                                                                        @endphp
                                                                        {{$name}}
                                                                    </th>
                                                                    <td>{{ $data->company_name }}</td>
                                                                    <td>{{ $data->phone }}</td>
                                                                    <td>{{ $data->email }}</td>
                                                                    <td>{{ $data->trucks }}</td>
                                                                    <td>{{ $data->drivers }}</td>
                                                                    <td>{{ $data->Comment }}</td>
                                                                    <td>{{ $data->updated_at }}</td>

                                                                    @if ($data->status == 1)
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#119711;color:white; padding: 2px 15px;border: none;">
                                                                                <i class='bx bxs-circle me-1'></i>NEW
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_emailintre_status', [base64_encode($data->id), base64_encode('good')]) }}">Good Form
                                                                                    </a>
                                                                                    <a class="dropdown-item"
                                                                                    href="{{ route('update_emailintre_status', [base64_encode($data->id), base64_encode('bad')]) }}">Bad Form
                                                                                    </a>
                                                                            </div>
                                                                        </td>
                                                                    @elseif($data->status == 2)
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#119711;color:white; padding: 2px 15px;border: none;">
                                                                                <i class='bx bxs-circle me-1'></i>Good Form
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_emailintre_status', [base64_encode($data->id), base64_encode('good')]) }}">Good Form
                                                                                    </a>
                                                                                    <a class="dropdown-item"
                                                                                    href="{{ route('update_emailintre_status', [base64_encode($data->id), base64_encode('bad')]) }}">Bad Form
                                                                                    </a>
                                                                            </div>
                                                                        </td>
                                                                        @else
                                                                        <td>
                                                                            <button class="custom-button"
                                                                                id="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true" aria-expanded="false"
                                                                                style="background-color:#ff0000;color:white; padding: 2px 15px;border: none;">
                                                                                <i class='bx bxs-circle me-1'></i>Bad Form
                                                                            </button>
                                                                            <div class="dropdown-menu"
                                                                                aria-labelledby="dropdownMenuButton">
                                                                                <a class="dropdown-item"
                                                                                    href="{{ route('update_emailintre_status', [base64_encode($data->id), base64_encode('good')]) }}">Good Form
                                                                                    </a>
                                                                                    <a class="dropdown-item"
                                                                                    href="{{ route('update_emailintre_status', [base64_encode($data->id), base64_encode('bad')]) }}">Bad Form
                                                                                    </a>
                                                                            </div>
                                                                        </td>

                                                                    @endif
                                                                  
                                                                    <td>
                                                                        <div class="btn-group"
                                                                            id="btns<?php echo $a; ?>">
                                                                            <a href="javascript:();" class="dCnf"
                                                                                mydata="<?php echo $a; ?>"
                                                                                data-toggle="tooltip" data-placement="top"
                                                                                title="Delete"><i class="ti-trash"
                                                                                    style="font-size:20px"></i></a>
                                                                        </div>
                                                                        <div style="display:none"
                                                                            id="cnfbox<?php echo $a; ?>">
                                                                            <p> Are you sure ..?</p>
                                                                            <a href="{{ route('delete_emailintre', base64_encode($data->id)) }}"
                                                                                class="btn btn-danger">Yes</a>
                                                                            <a href="javascript:();"
                                                                                class="cans btn btn-default"
                                                                                mydatas="<?php echo $a; ?>">No</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                             @endforeach
                                                         @else
                                                         <tr>
                                                            <td colspan="12" style="text-align: center; vertical-align: middle;">
                                                                <!-- Content to be centered -->
                                                                <div style="display: inline-block;"> <!-- Ensure inline-block display -->
                                                                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                                    <lottie-player src="https://lottie.host/461c3ab8-f91d-4dd3-9695-9f8c28b25030/TU3aEfjPmx.json" background="#FFFFFF" speed="1" style="width: 100px; height: 100px; display: block; margin: 0 auto;" loop autoplay direction="1" mode="normal"></lottie-player>
                                                                </div>
                                                                <p>No leads found</p>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        
                                                    </tbody>
                                                </table>
                                                {{ $datas->links() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end col-->
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>

            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
@endsection
