@extends('admin.common.app')
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
                            <div class="page-content-wrapper">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-b-20">
                                            <div class="card-body">
                                                <!-- show success and error messages -->
                                                @if (session('success'))
                                                    <div class="alert alert-success" role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                    </div>
                                                @endif
                                                @if (session('error'))
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ session('error') }}
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                    </div>
                                                @endif
                                                <!-- End show success and error messages -->
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h4 class="mt-0 header-title">Auto Forward</h4>
                                                    @if($team->status == 1)
                                                    <button type="button" onclick="window.location.href='{{ route('changeStatusforward', $team->id) }}'" class="btn btn-success">
                                                        On
                                                    </button>
                                                    @else
                                                    <button type="button" onclick="window.location.href='{{ route('changeStatusforward', $team->id) }}'" class="btn btn-danger">
                                                        Off
                                                    </button>
                                                    @endif

                                                </div>
                                                <hr style="margin-bottom: 50px;background-color: darkgrey;">
                                                <form action="{{route('store_auto_forward')}}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        @php
                                                        // Clean up the string from the database
                                                        $services_string = $team->user_id;

                                                        // Remove square brackets and extra quotes
                                                        $cleaned_services_string = trim(
                                                            $services_string,
                                                            '[]"',
                                                        );
                                                        $cleaned_services_string = str_replace(
                                                            '"',
                                                            '',
                                                            $cleaned_services_string,
                                                        );

                                                        // Convert the cleaned string into an array
                                                        $selected_services = explode(
                                                            ',',
                                                            $cleaned_services_string,
                                                        );
                                                    @endphp
                                                        <div class="col-sm-6 mt-3">
                                                            <label class="form-label" for="power">Add Agent
                                                                &nbsp;<span style="color:red;">*</span></label>
                                                            <div class="form-check-inline">
                                                                <label class="form-check-label" for="check1">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        id="check1" name="service"
                                                                        value="999" {{ in_array('999', $selected_services) ? 'checked' : '' }}> All</label>
                                                            </div>

                                                            @if (!empty($service_data))
                                                                @foreach ($service_data as $service)
                                                                @php
                                                                $service_value = $service->id; // Add 'v' suffix to the service ID
                                                                $isChecked = in_array(
                                                                    $service_value,
                                                                    $selected_services,
                                                                ); // Check if service is selected
                                                            @endphp
                                                                    <div class="form-check-inline">
                                                                        <label class="form-check-label"
                                                                            for="<?= $service->id ?>">
                                                                            <input type="checkbox"
                                                                                class="form-check-input"
                                                                                id="<?= $service->id ?>"
                                                                                name="services[]"
                                                                                value="{{ $service->id }}"  {{ $isChecked ? 'checked' : '' }}> {{ $service->name }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="col-sm-6 mt-3">
                                                            <select id="services" name="tab_view" class="form-control">
                                                                <option>Select Tab View</option>
                                                                @if (!empty($datas))
                                                                    @foreach ($datas as $data)
                                                                        <option value="{{ $data->id }}" {{ $team->tab_view_ids == $data->id ? 'selected' : '' }}>{{ $data->batch }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>  
                                                    <div class="form-group row">
                                                        <div class="form-group" style="margin-left:50px">
                                                            <div class="w-100 text-center">
                                                                <button type="submit" style="margin-top: 10px;"
                                                                    class="btn btn-danger">
                                                                    Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>

    @endsection
