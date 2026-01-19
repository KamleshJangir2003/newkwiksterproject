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

        </div>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <form method="get">
                            <div class="row g-4 align-items-center">
                                <div class="col-sm-6">
                                    <h5 style="margin-bottom: 10px">Day End Reports</h5>
                                </div>
                                <div class="col-sm-4">
                                    <div class="search-box">
                                        <input type="date" name="date" class="form-control search" placeholder="Search for..." value="{{ isset($_GET['date']) ? $_GET['date'] : '' }}">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class=" btn-success" style="margin-right:5px"><i class="ti-search"></i></button> 
                                <button type="button"  class=" btn-danger" onclick="window.location.href='{{route('view_submint_report')}}'"><i class="fa-solid fa-circle-xmark"></i>clear</button>
                                </div>
                                
                            </div>
                                </form>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <div class="form-group row">
                                        <div class="form-group" style="width:100%; margin-left:30px">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr style="background-color:#0098b6;color:white">
                                                        <th scope="col">S.no.</th>
                                                        <th scope="col">Agent Name</th>
                                                        <th scope="col">Intrested</th>
                                                        <th scope="col">Pipelines</th>
                                                        <th scope="col">Call Connected</th>
                                                        <th scope="col">Voice Mail</th>
                                                        <th scope="col">Total calls</th>
                                                        <th scope="col">Intrested/m</th>
                                                        <th scope="col">Pipelines/m</th>
                                                        <th scope="col">Call Connected/m</th>
                                                        <th scope="col">Voice Mail/m</th>
                                                        <th scope="col">Total calls/m</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($datas->isNotEmpty())
                                                        @php $a = 0;   @endphp
                                                        @foreach ($datas as $data)
                                                            @php $a++; @endphp
                                                            <tr>
                                                                <th scope="row">{{ $a }}</th>
                                                                @php
                                                                    $userdetails = App\adminmodel\Users_detailsModal::where('ajent_id',$data->id)->first();
                                                                    if(!empty($userdetails->alise_name)){
                                                                        $name = $userdetails->alise_name;
                                                                    }else{
                                                                        $name = "Name Not Found";
                                                                    }
                                                                   
                                                                    if(isset($_GET['date']) ){
                                                                        $date = Carbon\Carbon::parse($_GET['date']);
                                                                        $currentDate = $date->toDateString();
                                                                    }else{
                                                                        $currentDate = Carbon\Carbon::today()->toDateString();
                                                                    }
                                                                    $perday = App\Models\dayendreport::where('user_id',$data->id)->whereDate('created_at', $currentDate)->first();

                                                                    $currentMonth = Carbon\Carbon::now()->month;
                                                                    $currentYear = Carbon\Carbon::now()->year;

                                                                    $perMonth = App\Models\dayendreport::where('user_id', $data->id)
                                                                                     ->whereMonth('created_at', $currentMonth)
                                                                                     ->whereYear('created_at', $currentYear)
                                                                                     ->get();
                                                                     $Intrestedm = 0;
                                                                     $Pipelinesm = 0;
                                                                     $connectedm = 0;
                                                                     $voicem = 0;
                                                                     $totalm = 0;
                                                                     foreach($perMonth as $item){
                                                                        $Intrestedm+=$item->intrested;
                                                                        $Pipelinesm+=$item->pipeline;
                                                                        $connectedm+=$item->call_connect;
                                                                        $voicem+=$item->voicemail;
                                                                        $totalm+=$item->total_call;
                                                                     }
                                                         
                                                                @endphp
                                                                <td>{{ $name }}</td>
                                                                <td>{{ $perday->intrested ?? 0 }}</td>
                                                                <td>{{ $perday->pipeline ?? 0 }}</td>
                                                                <td>{{ $perday->call_connect ?? 0 }}</td>
                                                                <td>{{ $perday->voicemail ?? 0 }}</td>
                                                                <td>{{ $perday->total_call ?? 0 }}</td>
                                                                <td>{{ $Intrestedm }}</td>
                                                                <td>{{ $Pipelinesm }}</td>
                                                                <td>{{ $connectedm }}</td>
                                                                <td>{{ $voicem }}</td>
                                                                <td>{{ $totalm }}</td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="12"
                                                                style="text-align: center; vertical-align: middle;">
                                                                <!-- Content to be centered -->
                                                                <div style="display: inline-block;">
                                                                    <!-- Ensure inline-block display -->
                                                                    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
                                                                    <lottie-player
                                                                        src="https://lottie.host/461c3ab8-f91d-4dd3-9695-9f8c28b25030/TU3aEfjPmx.json"
                                                                        background="#FFFFFF" speed="1"
                                                                        style="width: 100px; height: 100px; display: block; margin: 0 auto;"
                                                                        loop autoplay direction="1"
                                                                        mode="normal"></lottie-player>
                                                                </div>
                                                                <p>No Data found</p>
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
    </div>
    </div>
@endsection
