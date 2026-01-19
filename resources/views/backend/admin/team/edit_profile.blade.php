@extends('backend.common.layout')
@section('content')
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="assets/images/profile-bg.jpg" alt="" class="profile-wid-img" />
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-5 pb-lg-4 profile-wrapper">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    <img src="{{ asset($user->profile) }}" alt="user-img" class="img-thumbnail rounded-circle" />
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{ $user->name }}</h3>
                    <p class="text-white text-opacity-75">{{ $user->designation }}</p>
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2"><i
                                class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{$address->address ?? ''}}</div>
                        <div>
                            <i class="ri-building-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{$address->country ?? ''}}
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>

    <div class="row">
        <!--end col-->
        <div class="col-xxl-12">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i>Personal Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#address" role="tab">
                                <i class="far fa-user"></i>Address
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#salary" role="tab">
                                <i class="far fa-envelope"></i>Salary
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                <i class="far fa-user"></i>Change Password
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control" placeholder="Enter your name"
                                                value="{{ $user->name }}" name="name">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control" placeholder="Enter your phone number"
                                                value="{{ $user->phone }}" name="name">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="emailInput" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="emailInput"
                                                placeholder="Enter your email" value="{{ $user->email }}" name="email">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="skillsInput" class="form-label">Designation</label>
                                            <select class="form-control" name="designation">
                                                <option value="Manager">Manager</option>
                                                <option value="Agent">Agent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-start">
                                            <button type="submit" class="btn btn-primary">Updates</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <div class="tab-pane " id="address" role="tabpanel">
                            <form action="{{ route('admin.store.address') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3 pb-2">
                                            <label for="exampleFormControlTextarea" class="form-label">Address</label>
                                            <textarea class="form-control" id="exampleFormControlTextarea" placeholder="Enter your Address" rows="3"
                                                name="address">{{ $address->address ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="cityInput" class="form-label">City</label>
                                            <input type="text" class="form-control" id="cityInput" placeholder="City"
                                                value="{{ $address->city ?? '' }}" name="city" />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="countryInput" class="form-label">Country</label>
                                            <input type="text" class="form-control" id="countryInput"
                                                placeholder="Country" value="{{ $address->country ?? '' }}"
                                                name="country" />
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label for="zipcodeInput" class="form-label">Zip
                                                Code</label>
                                            <input type="text" class="form-control" minlength="5" maxlength="6"
                                                id="zipcodeInput" placeholder="Enter zipcode"
                                                value="{{ $address->zip ?? ''}}" name="zip">
                                        </div>
                                    </div>
                                    <!--end col-->

                                    <div class="col-lg-12">
                                        <div class="hstack gap-2 justify-content-start">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->

                            </form>
                        </div>
                        <!--end tab-pane-->

                        <div class="tab-pane" id="salary" role="tabpanel">
                            <form action="{{ route('admin.store.salary') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">

                                <div id="newlink">
                                    <div id="1">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="jobTitle" class="form-label">Annual</label>
                                                    <input type="number" class="form-control" id="annual"
                                                        placeholder="Annual Salary" value="{{ $salary->annual ?? '' }}"
                                                        name="annual">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="companyName" class="form-label">Monthly</label>
                                                    <input type="number" class="form-control" id="monthly"
                                                        placeholder="Monthly Salary" value="{{ $salary->monthly ?? '' }}"
                                                        name="monthly">
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-start">
                                                    <button type="submit" class="btn btn-primary">Updates</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                </div>

                            </form>
                        </div>
                        <!--end tab-pane-->

                        <div class="tab-pane" id="changePassword" role="tabpanel">
                            <form action="{{route('admin.change.password')}}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$user->id}}" name="id">
                                <div class="row g-2">
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="oldpasswordInput" class="form-label">Old
                                                Password*</label>
                                            <input type="password" class="form-control" id="oldpasswordInput"
                                                placeholder="Enter current password" name="oldpassword">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="newpasswordInput" class="form-label">New
                                                Password*</label>
                                            <input type="password" class="form-control" id="newpasswordInput"
                                                placeholder="Enter new password" name="password">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4">
                                        <div>
                                            <label for="confirmpasswordInput" class="form-label">Confirm
                                                Password*</label>
                                            <input type="password" class="form-control" id="confirmpasswordInput"
                                                placeholder="Confirm password" name="cpassword">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    {{-- <div class="col-lg-12">
                                        <div class="mb-3">
                                            <a href="javascript:void(0);"
                                                class="link-primary text-decoration-underline">Forgot
                                                Password ?</a>
                                        </div>
                                    </div> --}}
                                    <!--end col-->
                                    <div class="col-lg-12">
                                        <div class="text-start">
                                            <button type="submit" class="btn btn-success">Change
                                                Password</button>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </form>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#annual').on('keyup', function() {
                let annual = parseFloat($(this).val());
                let totalMonth = (annual / 12).toFixed(2);
                $('#monthly').val(totalMonth);
            });

            $('#monthly').on('keyup', function() {
                let monthly = parseFloat($(this).val());
                let totalAnnual = (monthly * 12).toFixed(2);
                $('#annual').val(totalAnnual);
            });
        });
    </script>
@endsection
