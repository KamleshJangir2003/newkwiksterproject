@extends('backend.common.layout')
@section('css')
    <style>
        .profile-pic {
            width: 200px;
            max-height: 200px;
            display: inline-block;
        }

        .file-upload {
            display: none;
        }

        .circle {
            border-radius: 100% !important;
            overflow: hidden;
            width: 128px;
            height: 128px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            position: absolute;
            top: 72px;
        }

        .p-image {
            position: absolute;
            top: 167px;
            right: 30px;
            color: #666666;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .p-image:hover {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .upload-button {
            font-size: 1.2em;
        }

        .upload-button:hover {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            color: #999;
        }
    </style>
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Team</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">Team</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card" id="leadsList">
                <div class="card-header border-0">

                    <div class="row g-4 align-items-center">
                        <div class="col-sm-3">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Search for...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-sm-auto ms-auto">
                            <div class="hstack gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()"><i
                                        class="ri-delete-bin-2-line"></i></button>
                                <button type="button" class="btn btn-primary add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal"><i
                                        class="ri-add-line align-bottom me-1"></i> Add Team</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="width: 50px;">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkAll"
                                                    value="option">
                                            </div>
                                        </th>

                                        <th class="sort" data-sort="name">Name</th>
                                        <th class="sort" data-sort="phone">Phone</th>
                                        <th class="sort" data-sort="company_name">Gender</th>
                                        <th class="sort" data-sort="leads_score">Email</th>
                                        <th class="sort" data-sort="location">Designation</th>
                                        <th class="sort" data-sort="date">Create Date</th>
                                        <th class="sort" data-sort="action">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @foreach ($teams as $team)
                                        <tr>
                                            <th scope="row">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="chk_child"
                                                        value="option1">
                                                </div>
                                            </th>
                                            <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                    class="fw-medium link-primary">#VZ2101</a></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img src="{{ asset($team->profile) }}" alt=""
                                                            class="avatar-xxs rounded-circle image_src object-fit-cover">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 name">{{ $team->name }}</div>
                                                </div>
                                            </td>
                                            <td class="phone">{{ $team->phone }}</td>
                                            <td class="company_name">{{ $team->gender }}</td>
                                            <td class="leads_score">{{ $team->email }}</td>
                                            <td class="location">{{ $team->designation }}</td>
                                            <td class="date">
                                                {{ \Carbon\Carbon::parse($team->created_at)->format('d M, Y') }}</td>
                                            <td>
                                                <ul class="list-inline hstack gap-2 mb-0">
                                                    <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Call">
                                                        <a href="tel:+91{{ $team->phone }}"
                                                            class="text-muted d-inline-block">
                                                            <i class="ri-phone-line fs-16"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="View">
                                                        <a href="{{ route('manager.view.profile', encrypt($team->id)) }}"><i
                                                                class="ri-eye-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-bs-toggle="tooltip"
                                                        data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                                        <a class="edit-item-btn" href="#showEditModal"
                                                            data-bs-toggle="modal" data-user-id="{{ $team->id }}"><i
                                                                class="ri-pencil-fill align-bottom text-muted"></i></a>
                                                    </li>
                                                    <li class="list-inline-item" data-toggle="tooltip"
                                                        data-trigger="hover" data-placement="top" title="Delete">
                                                        <a class="remove-item-btn" data-toggle="modal"
                                                            href="{{ route('manager.delete.team', $team->id) }}"
                                                            onclick="return confirm('Are you sure ?');">
                                                            <i class="ri-delete-bin-fill align-bottom text-muted"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="noresult" style="display: none">
                                <div class="text-center">
                                    <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop"
                                        colors="primary:#121331,secondary:#08a88a"
                                        style="width:75px;height:75px"></lord-icon>
                                    <h5 class="mt-2">Sorry! No Result Found</h5>
                                    <p class="text-muted mb-0">We've searched more than 150+ leads We
                                        did not find any leads for you search.</p>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <div class="pagination-wrap hstack gap-2">
                                <a class="page-item pagination-prev disabled" href="#">
                                    Previous
                                </a>
                                <ul class="pagination listjs-pagination mb-0"></ul>
                                <a class="page-item pagination-next" href="#">
                                    Next
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title">Add Team</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" action="{{ route('manager.store.team') }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="avatar-lg p-1 mx-auto">
                                                    <div class="avatar-title bg-light rounded-circle">
                                                        <img src="{{asset('assets/images/users/user-dummy-img.jpg')}}"
                                                           
                                                            class="avatar-md rounded-circle object-fit-cover" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label class="form-label">Image</label>
                                                    <input type="file" name="profile" class="form-control" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="leadname-field" class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Enter Name" required  />
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" name="phone" class="form-control"
                                                        placeholder="Enter phone no" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label f class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="Enter Email" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label class="form-label">Password</label>
                                                    <input type="password" name="password" class="form-control"
                                                        placeholder="Enter password" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label class="form-label">Confirm Password</label>
                                                    <input type="password" name="cpassword" class="form-control"
                                                        placeholder="Confirm password" required />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label class="form-label">Gender</label>
                                                    <input type="radio" name="gender" class="form-check-input"
                                                        required value="Male" /> Male
                                                    <input type="radio" name="gender" class="form-check-input"
                                                        required value="Female" /> Female
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label class="form-label">Designation</label>
                                                    <select name="designation" class="form-select">
                                                        <option value="">--Select--</option>
                                                        <option value="Agent">Agent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Add</button>
                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->
                    {{-- Modal 2 --}}
                    <div class="modal fade" id="showEditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title">Team</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" action="{{ route('manager.update.team') }}"
                                    enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="hidden" name="id" id="id" value="" />
                                        <div class="row g-3">
                                            <div class="col-lg-12">
                                                <div class="avatar-lg p-1 mx-auto">
                                                    <div class="avatar-title bg-light rounded-circle">
                                                        <img src="{{asset('assets/images/users/user-dummy-img.jpg')}}"
                                                            id="img"
                                                            class="avatar-md rounded-circle object-fit-cover" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label class="form-label">Image</label>
                                                    <input type="file" name="profile" class="form-control"  />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label for="leadname-field" class="form-label">Name</label>
                                                    <input type="text" name="name" class="form-control"
                                                        placeholder="Enter Name" required id="name" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label class="form-label">Phone</label>
                                                    <input type="text" name="phone" class="form-control"
                                                        placeholder="Enter phone no" required id="phone" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div>
                                                    <label f class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control"
                                                        placeholder="Enter Email" required id="email" />
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div>
                                                    <label class="form-label">Gender</label>
                                                    <input type="radio" name="gender"
                                                        class="form-check-input gender-radio" required value="Male" />
                                                    Male
                                                    <input type="radio" name="gender"
                                                        class="form-check-input gender-radio" required value="Female" />
                                                    Female
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div>
                                                    <label class="form-label">Designation</label>
                                                    <select name="designation" class="form-select" id="designation">
                                                        <option value="">--Select--</option>
                                                        <option value="Agent">Agent</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end modal-->
                </div>
                <!--end modal -->
            </div>
        </div>

    </div>
    <!--end col-->
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            var baseUrl = "{{ asset('') }}";
            $('#showEditModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var userId = button.data('user-id'); // Extract user ID from data attribute

                // Make an AJAX request to fetch user data based on the user ID
                $.ajax({
                    url: '/manager/get/team/' + userId,
                    type: 'GET',
                    success: function(data) {
                        // Update modal fields with the fetched data
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#image-input').val(''); // To clear the file input
                        $('#img').attr('src', baseUrl + data.profile);
                        $('#phone').val(data.phone);
                        $('#email').val(data.email);
                        $('.gender-radio[value="' + data.gender + '"]').prop('checked', true);
                        $('#designation').val(data.designation); // Corrected line
                    },
                    error: function(error) {
                        console.log('Error fetching user data:', error);
                    }
                });
            });

        });
    </script>
@endsection
