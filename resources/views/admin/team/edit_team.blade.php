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
                        <div class="row">

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
                                                <h4 class="mt-0 header-title">Edit Team Form</h4>
                                                <hr style="margin-bottom: 50px;background-color: darkgrey;">
                                                <form action="{{ route('edit_store', $team->id) }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" type="text"
                                                                    value="{{ old('name', $team->name ?? '') }}"
                                                                    id="name" name="name" placeholder="Enter name"
                                                                    required>

                                                            </div>
                                                            @error('name')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="email"
                                                                    value="{{ old('email', $team->email ?? '') }}"
                                                                    id="email" name="email" placeholder="Enter email"
                                                                    required autocomplete="off">

                                                            </div>
                                                            @error('email')
                                                                <div style="color:red">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="text"
                                                                    value="{{ old('phone', $team->phone ?? '') }}"
                                                                    id="phone" name="phone" placeholder="phone no."
                                                                    onkeypress="return isNumberKey(event)" maxlength="10"
                                                                    minlength="10" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <div class="form-floating">
                                                                <input class="form-control" type="text"
                                                                    value="{{ old('address', $team->address ?? '') }}"
                                                                    id="address" name="address"
                                                                    placeholder="address(Optional)">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-4 mt-2">
                                                            <select class="form-control" name="power" id="power"
                                                                value="{{ old('power') }}" required>
                                                                <option value="">Please select Type</option>
                                                                <option value="1"
                                                                    {{ $team->power == 1 ? 'selected' : '' }}>Admin
                                                                </option>
                                                                <option value="2"
                                                                    {{ $team->power == 2 ? 'selected' : '' }}>Manager
                                                                </option>
                                                                <option value="3"
                                                                    {{ $team->power == 3 ? 'selected' : '' }}>Team Leader
                                                                </option>
                                                                <option value="4"
                                                                    {{ $team->power == 4 ? 'selected' : '' }}>H.R</option>
                                                                <option value="5"
                                                                    {{ $team->power == 5 ? 'selected' : '' }}>Accountant
                                                                </option>
                                                            </select>
                                                            <div class="form-floating">
                                                                @error('power')
                                                                    <div style="color:red">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group row" style="margin-right:50px">
                                                            @php
                                                                // Clean up the string from the database
                                                                $services_string = $team->services;

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

                                                            <div class="col-sm-8 mt-3">
                                                                <label class="form-label" for="power">Services
                                                                    &nbsp;<span style="color:red;">*</span></label>

                                                                <!-- "All" checkbox -->
                                                                <div class="form-check-inline">
                                                                    <label class="form-check-label" for="check_all">
                                                                        <input type="checkbox" class="form-check-input"
                                                                             name="services[]"
                                                                            value="999"
                                                                            {{ in_array('999', $selected_services) ? 'checked' : '' }}>
                                                                        All
                                                                    </label>
                                                                </div>

                                                                <!-- Individual service checkboxes -->
                                                                @if (!empty($service_data))
                                                                    @foreach ($service_data as $service)
                                                                        @php
                                                                            $service_value = $service->id . 'v'; // Add 'v' suffix to the service ID
                                                                            $isChecked = in_array(
                                                                                $service_value,
                                                                                $selected_services,
                                                                            ); // Check if service is selected
                                                                        @endphp
                                                                        <div class="form-check-inline">
                                                                            <label class="form-check-label"
                                                                                for="{{ $service->id }}">
                                                                                <input type="checkbox"
                                                                                    class="form-check-input"
                                                                                    id="{{ $service->id }}"
                                                                                    name="services[]"
                                                                                    value="{{ $service->id }}v"
                                                                                    {{ $isChecked ? 'checked' : '' }}>
                                                                                {{-- Mark checkbox as checked if selected --}}
                                                                                {{ $service->name }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
                                                                @endif
                                                            </div>


                                                            <!-- JavaScript to handle "All" selection -->
                                                            <script>
                                                                document.getElementById('check_all').addEventListener('change', function() {
                                                                    var checkboxes = document.querySelectorAll('input[name="services[]"]');
                                                                    checkboxes.forEach(function(checkbox) {
                                                                        checkbox.checked = document.getElementById('check_all').checked;
                                                                    });
                                                                });

                                                                // Uncheck "All" if any individual checkbox is unchecked
                                                                var serviceCheckboxes = document.querySelectorAll('input[name="services[]"]');
                                                                serviceCheckboxes.forEach(function(checkbox) {
                                                                    checkbox.addEventListener('change', function() {
                                                                        if (!checkbox.checked) {
                                                                            document.getElementById('check_all').checked = false;
                                                                        }
                                                                    });
                                                                });
                                                            </script>

                                                        </div>
                                                        <input type="hidden" name="admin_id"
                                                            value="{{ session('admin_id') }}">
                                                        <div class="form-group" style="margin-left:50px">
                                                            <div class="w-100 text-center">
                                                                <button type="submit" style="margin-top: 10px;"
                                                                    class="btn btn-danger"><i class="fa fa-user"></i>
                                                                    Submit</button>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                        </div>
                    </div>
                    <!-- Page-body end -->
                </div>
                <div id="styleSelector"> </div>
            </div>
        </div>
    @endsection
