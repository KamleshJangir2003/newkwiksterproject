@extends('admin.common.app')
@section('main')
    <style>
        /* Add this to your CSS */
        .empty-state-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 60vh;
            padding: 2rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .empty-state {
            text-align: center;
            max-width: 500px;
            padding: 2.5rem;
        }

        .empty-state-icon {
            margin-bottom: 1.5rem;
            animation: float 6s ease-in-out infinite;
        }

        .empty-state-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 1rem;
        }

        .empty-state-message {
            font-size: 1.1rem;
            color: #636e72;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .empty-state-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-gradient {
            background: linear-gradient(135deg, #0098b6 0%, #a29bfe 100%);
            border: none;
            color: white;
            box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4);
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Animation classes */
        .animate__animated {
            animation-duration: 1s;
            animation-fill-mode: both;
        }

        .animate__fadeIn {
            animation-name: fadeIn;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <div class="pcoded-content">
        <!-- Page-header start -->
        <div class="page-header">
            {{-- <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Tab View</h5>
                        <p class="m-b-0">Welcome to {{ config('app.site_name') }}</p>
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
                        <h4>Tab View</h4>
                            @if ($datas && $datas->count() > 0)
                        <div class="row">
                            <!-- task, page, download counter  start -->
                        
                                @foreach ($datas as $data)
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card">
                                            <div class="card-block" onclick="toggleFooter(this)">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <h4 class="text-c-purple m-b-10"> {{ $data->team->name }}</h4>
                                                        <h6 class="text-muted m-b-1">File name: {{ $data->batch }}</h6>
                                                        <h6 class="text-muted m-b-1">Data: {{ $data->total_data }}</h6>
                                                        <h6 class="text-muted m-b-0">Date: {{ $data->created_at }}</h6>
                                                    </div>
                                                    <div class="col-4 text-right">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            style="fill:green">
                                                            <!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                            <path
                                                                d="M190.5 68.8L225.3 128H224 152c-22.1 0-40-17.9-40-40s17.9-40 40-40h2.2c14.9 0 28.8 7.9 36.3 20.8zM64 88c0 14.4 3.5 28 9.6 40H32c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H480c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H438.4c6.1-12 9.6-25.6 9.6-40c0-48.6-39.4-88-88-88h-2.2c-31.9 0-61.5 16.9-77.7 44.4L256 85.5l-24.1-41C215.7 16.9 186.1 0 154.2 0H152C103.4 0 64 39.4 64 88zm336 0c0 22.1-17.9 40-40 40H288h-1.3l34.8-59.2C329.1 55.9 342.9 48 357.8 48H360c22.1 0 40 17.9 40 40zM32 288V464c0 26.5 21.5 48 48 48H224V288H32zM288 512H432c26.5 0 48-21.5 48-48V288H288V512z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-c-purple" style="display:none;">
                                                <div class=" row align-items-center">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-success"
                                                            onclick="window.location.href='{{ route('all_tab_view_data', [base64_encode($data->team->id), base64_encode($data->batch)]) }}'">View
                                                            Data</button>
                                                    </div>
                                                    <div class="col-6 ">
                                                        <button class="btn btn-danger"
                                                            onclick="window.location.href='{{ route('deleteAllbatchData', [base64_encode($data->batch)]) }}'"><i
                                                                class="ti-trash"></i>All</button>
                                                    </div>

                                                </div>
                                                <br>
                                                <!-- <div class=" row align-items-center">
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            style="text-align:center;width:100%;padding-left:0px"
                                                            onclick="window.location.href='{{ route('deleteDuplicateEntryBatch', [base64_encode($data->batch)]) }}'"><i
                                                                class="ti-trash"></i>Duplicate</button>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="button" class="btn btn-danger"
                                                            style="text-align:center;width:100%;"
                                                            onclick="window.location.href='{{ route('deleteDNDEntryBatch', [base64_encode($data->batch)]) }}'"><i
                                                                class="ti-trash" style="margin"></i>DND</button>
                                                    </div>
                                                </div> -->

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            
                            <!-- task, page, download counter  end -->
                        </div>
                        @else
                                <div class="empty-state-container">
                                    <div class="empty-state animate__animated animate__fadeIn">
                                        <div class="empty-state-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100"
                                                fill="#0098b6" viewBox="0 0 24 24">
                                                <path
                                                    d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z" />
                                            </svg>
                                        </div>
                                        <h3 class="empty-state-title">No Leads Available</h3>
                                        <p class="empty-state-message">Your lead queue is currently empty. New leads will appear here when Upload.</p>

                                        {{-- <div class="empty-state-actions">
            <a href="#" class="btn btn-primary btn-lg btn-gradient">
                <i class="fas fa-layer-group"></i>Return to Tab View
            </a>
        </div> --}}
                                    </div>
                                </div>
                            @endif
                    </div>
                    <!-- Page-body end -->
                </div>

            </div>
        </div>
        <script>
            function toggleFooter(cardBlock) {
                var footer = cardBlock.nextElementSibling; // Get the next sibling element (footer)
                if (footer.style.display === "none") {
                    footer.style.display = "block"; // Show the footer if it's hidden
                } else {
                    footer.style.display = "none"; // Hide the footer if it's visible
                }
            }
        </script>

    @endsection
