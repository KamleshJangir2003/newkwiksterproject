@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add Holidays</h5>

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
            </div>
        </div>
        <div class="pcoded-inner-content">
            <!-- Main-body start -->
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            
                                <div class="col-lg-12">
                                    <div class="card" id="leadsList">
                                        <div class="card-header border-0">
                                            <form action="{{ route('store_holidays') }}" method="post">
                                                @csrf
                                                <div class="row g-4 align-items-center">

                                                    <div class="col-sm-4">
                                                        <div class="search-box">
                                                            <input type="text" name="name"
                                                                class="form-control search" placeholder="Enter Name"
                                                                required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="search-box">
                                                            <input type="date" name="date" class="form-control search"
                                                                placeholder="Date" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="search-box">
                                                            <input type="submit" class="btn btn-primary w-100"
                                                                placeholder="Save">

                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">

                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">S.No.</th>
                                                            <th scope="col">Holiday Name</th>
                                                            <th scope="col">Date</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if (!empty($holidays))
                                                            @php $a = 0; @endphp
                                                            @foreach ($holidays as $data)
                                                                @php $a++; @endphp
                                                                <tr>
                                                                    <th scope="row">{{ $a }}</th>
                                                                    <td>{{ $data->name }}</td>
                                                                    <td>{{ $data->date }}</td>
                                                                    <td><button class="red-button"
                                                                            onclick="window.location.href='{{ route('delete_holidays', base64_encode($data->id)) }}'">Delete</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{ $holidays->links() }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <!--end col-->
                        </div>
                        <!--end row-->

                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
    </div>
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
