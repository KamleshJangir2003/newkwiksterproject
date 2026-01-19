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
                    <form method="get">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm-6">
                                <h5 style="margin-bottom: 10px">same day load Forms</h5>
                            </div>
                            {{-- <div class="col-sm-4">
                                <div class="search-box">
                                    <input type="text" name="dot" class="form-control search"
                                        placeholder="Search DOT" value="{{ isset($_GET['dot']) ? $_GET['dot'] : '' }}">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" class=" btn-success" style="margin-right:5px"><i
                                        class="ti-search"></i></button>
                                <button type="button" class=" btn-danger"
                                    onclick="window.location.href='{{ route('view_load_forms') }}'"><i
                                        class="fa-solid fa-circle-xmark"></i>clear</button>
                            </div> --}}

                        </div>
                    </form>
                    <div class="page-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <div class="form-group row">
                                        <div class="form-group" style="width:100%; margin-left:30px">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr style="background-color:#0098b6;color:white">
                                                        <th scope="col">S.no.</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">phone</th>
                                                        <th scope="col">email</th>
                                                        <th scope="col">Agent</th>
                                                        <th scope="col">Date</th>
                                                      
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($datas->isNotEmpty())
                                                        @foreach ($datas as $data)
                                                        
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{  $data->name1 ?? 0 }} <a
                                                                    href="{{ route('view_sameday_pdfs', $data->id) }}"
                                                                    target="_blank">
                                                                    <button>PDF</button>
                                                                </a></td>
                                                            <td>{{ $data->name1 ?? 0 }}</td>
                                                            <td>{{ $data->name2 ?? 0 }}</td>
                                                            <td>{{ $data->name3 ?? 0 }}</td>
                                                            <td>{{ $data->created_at ? $data->created_at->format('d-m-Y') : '0' }}</td>
                                                            <td>
                                                                <div class="btn-group" id="btns<?php echo $data->id; ?>">
                                                                    <a href="javascript:();" class="dCnf"
                                                                        mydata="<?php echo $data->id; ?>" data-toggle="tooltip"
                                                                        data-placement="top" title="Delete"><i
                                                                            class="ti-trash" style="font-size:20px"></i></a>
                                                                </div>
                                                                <div style="display:none" id="cnfbox<?php echo $data->id; ?>">
                                                                    <p> Are you sure ..?</p>
                                                                    <a href="{{ route('delete_load_forms', base64_encode($data->id)) }}"
                                                                        class="btn btn-danger">Yes</a>
                                                                    <a href="javascript:();" class="cans btn btn-default"
                                                                        mydatas="<?php echo $data->id; ?>">No</a>
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
    <script>
        $(document).ready(function() {
            $('textarea[name="comment"]').on('change', function() {
                var comment = $(this).val();
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ route('comment_load_forms') }}', // Replace with your actual URL
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Include CSRF token for security
                        id: id,
                        comment: comment
                    },
                    success: function(response) {
                        alert('Comment updated successfully!');
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while updating the comment.');
                    }
                });
            });
        });
    </script>
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
