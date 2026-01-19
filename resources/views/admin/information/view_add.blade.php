@extends('admin.common.app')
@section('main')
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            {{-- <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add credentials</h5>

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
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" id="leadsList">
                                        <div class="card-header border-0">
                                            <form action="{{ route('store_information') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ session('admin_id') }}">
                                                <div class="row g-4 align-items-center">
                                                    <div class="col-sm-3">
                                                        <div class="search-box">
                                                            <select class="form-control" name="agent_id" required>
                                                                <option value="all">All</option>
                                                                @foreach ($users as $user)
                                                                    <option value="{{ $user->id }}">{{ $user->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="search-box">
                                                            <textarea name="message" class="form-control search" placeholder="Enter your message"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="search-box">
                                                            <input type="date" name="duration"
                                                                class="form-control search" placeholder="Enter password"
                                                                required>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
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
                                                            <th scope="col">Agent Name</th>
                                                            <th scope="col">Message</th>
                                                            <th scope="col">Expire Date</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @if(!empty($datas))
                                                      @foreach ( $datas as $data )
                                                      @php
                                                          $userrr = App\Models\User::where('id',$data->agent_id)->first();
                                                      @endphp
                                                        <tr>
                                                            <th scope="row">{{ $loop->iteration }}</th>
                                                            <td>{{$userrr->name ?? "All"}}</td>
                                                            <td>{{$data->text}}</td>
                                                            <td>{{$data->duration}}</td>
                                                            @if ($data->status == 1)
                                                            <td>
                                                                <a
                                                                    href="{{ route('Updateinformation', ['active', base64_encode($data->id)]) }}">
                                                                    <div
                                                                        class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3">
                                                                        <i class='bx bxs-circle me-1'></i>Active
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <a
                                                                    href="{{ route('Updateinformation', ['inactive', base64_encode($data->id)]) }}">
                                                                    <div
                                                                        class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3">
                                                                        <i class='bx bxs-circle me-1'></i>Inactive
                                                                    </div>
                                                                </a>
                                                            </td>
                                                        @endif
                                                        </tr>
                                                        @endforeach
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
