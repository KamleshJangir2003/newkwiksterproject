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
                                <h4>Active Breaks</h4>
                                
                            </div>
                            <div class="table-responsive">
                                <div class="form-group row">
                                    <div class="form-group" style="width:100%; margin-left:30px">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col">S.No.</th>
                                                    <th scope="col">Agent Name</th>
                                                    <th scope="col">Completed</th>
                                                    <th scope="col">Active Break</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($datas->isNotEmpty())
                                                    @php $a = 0;   @endphp
                                                    @foreach ($datas as $data)
                                                        @php
                                                            $a++;
                                                            $currentDateUS = Carbon\Carbon::now(
                                                                'America/New_York',
                                                            )->toDateString();
                                                            $user = App\Models\User::where(
                                                                'id',
                                                                $data->agent_id,
                                                            )->first();
                                                        @endphp
                                                        <tr>
                                                            <th scope="row">{{ $a }}</th>
                                                            <td>{{ $user->name }}</td>
                                                            @php
                                                                $breaks = App\Models\Break_detail::where('status', 1)
                                                                    ->where('agent_id', $data->agent_id)
                                                                    ->whereDate('created_at', $currentDateUS) // Filter by current date
                                                                    ->get();
                                                            @endphp
                                                            <td>
                                                                @foreach ($breaks as $break)
                                                                    @php
                                                                        $name_break = App\adminmodel\Breaks::where(
                                                                            'id',
                                                                            $break->break_id,
                                                                        )->first();
                                                                    @endphp
                                                                    {{ $name_break->name }}({{ $name_break->duration }}) =>
                                                                    {{ number_format($break->time_use, 2) }}
                                                                    <br>
                                                                @endforeach
                                                            </td>
                                                            <td>

                                                                @php
                                                                    $run_break = App\adminmodel\Breaks::where(
                                                                        'id',
                                                                        $data->break_id,
                                                                    )->first();

                                                                    $currentTimeUS = Carbon\Carbon::now('America/New_York');

                                                                    // Convert the created_at timestamp to the US timezone
                                                                    $createdAtUS = Carbon\Carbon::parse(
                                                                        $data->created_at,
                                                                    )->timezone('America/New_York');

                                                                    // Calculate the difference in minutes
                                                                    $minuteDifference = $createdAtUS->diffInMinutes(
                                                                        $currentTimeUS,
                                                                    );
                                                                @endphp
                                                                {{ $run_break->name }}({{ $run_break->duration }}) =>
                                                                {{ $minuteDifference }} min
                                                                <br>

                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger">On Break</button>
                                                            </td>
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
                                                            <p>No Active Breaks found</p>
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
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
    </div>
    </div>
@endsection
