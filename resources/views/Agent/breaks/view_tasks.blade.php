@extends('Agent.common.app')
@section('main')
    <link href="{{ asset('Agent/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet" />
    <style>
        .red-row {
            background-color: #ff6666 !important;
        }
    </style>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tasks</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->


            <!-- show success and error messages -->
            @if (session('success'))
                <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    <div class="text-white">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!-- End show success and error messages -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Heading</th>
                                    <th scope="col">Discription</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Issue</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($datas))
                                    @php $a = 0; @endphp
                                    @foreach ($datas as $data)
                                        @php $a++; @endphp
                                        <tr>
                                            <th scope="row">{{ $a }}</th>
                                            <td>{{ $data->heading }}</td>
                                            <td><textarea>{{ $data->description }}</textarea></td>
                                            <td>{{ $data->deadline }}</td>
                                            <td>{{ $data->created_at->format('d-m-Y') }}</td>
                                            <td>
                                                @if ($data->status == 1)
                                                    <div class="btn-group">
                                                        <a href="{{ route('statu_agent_task', base64_encode($data->id)) }}">
                                                            <button type="button"
                                                                class="btn btn-warning">Pending</button>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <a href="{{ route('statu_agent_task', base64_encode($data->id)) }}"> 
                                                            <button type="button" class="btn btn-success">Completed</button>
                                                        </a>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Heading</th>
                                    <th scope="col">Discription</th>
                                    <th scope="col">Deadline</th>
                                    <th scope="col">Issue</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
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
