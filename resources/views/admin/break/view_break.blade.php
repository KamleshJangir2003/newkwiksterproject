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
                                <h4>Breaks</h4>
                                <div class="table-responsive">
                                    <div class="form-group row">
                                        <div class="form-group" style="width:100%; margin-left:30px">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">S.No.</th>
                                                        <th scope="col">Break Name</th>
                                                        <th scope="col">Duration</th>
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
                                                                <th scope="row">{{ $a }}</th>
                                                                <td>{{ $data->name }}</td>
                                                                <td>{{ $data->duration }} Minutes</td>

                                                                @if ($data->status == 1)
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('UpdatebreakStatus', ['active', base64_encode($data->id)]) }}">
                                                                            <div
                                                                                class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                                                <i class='bx bxs-circle me-1'></i>Active
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td>
                                                                        <a
                                                                            href="{{ route('UpdatebreakStatus', ['inactive', base64_encode($data->id)]) }}">
                                                                            <div
                                                                                class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                                                <i class='bx bxs-circle me-1'></i>Inactive
                                                                            </div>
                                                                        </a>
                                                                    </td>
                                                                @endif
                                                                <td>
                                                                    <div class="btn-group" id="btns<?php echo $a; ?>">
                                                                        <a href="javascript:();" class="dCnf"
                                                                            mydata="<?php echo $a; ?>"
                                                                            data-toggle="tooltip" data-placement="top"
                                                                            title="Delete"><i class="ti-trash"
                                                                                style="font-size:20px"></i></a>
                                                                    </div>
                                                                    <div style="display:none"
                                                                        id="cnfbox<?php echo $a; ?>">
                                                                        <p> Are you sure ..?</p>
                                                                        <a href="{{ route('deletebreak', base64_encode($data->id)) }}"
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
                                                                <p>No Breaks found</p>
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
