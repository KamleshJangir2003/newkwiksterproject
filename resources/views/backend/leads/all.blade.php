@extends('backend.common.layout')
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
            margin-top:10px;
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
@endsection
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">All Leads</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">All Leads</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <form action="{{route('admin.fwd.data')}}" method="post">
        @csrf
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
                                    <select id="stateFilter" class="px-3">
                                    <option value="">All States</option>
                                         @foreach ($datas as $data)
                                    <option value="{{ $data->business_state }}">{{ $data->business_state }}</option>
                                    @endforeach
   
                                    </select>
                                    <button class="btn btn-soft-danger" id="remove-actions" data-bs-toggle="modal"
                                        href="#deleteRecordModal"><i class="ri-delete-bin-2-line"></i></button>
                                        <a class="btn btn-soft-danger" href="{{route('delete.all.import.leads')}}" onclick="return confirm('Are you sure, You want to Delete all data click OK.')">Delete All</a>
                                    <button type="button" class="btn btn-info" data-bs-toggle="offcanvas"
                                        href="#offcanvasExample" id="forwardButton"><i
                                            class="ri-filter-3-line align-bottom me-1"></i>
                                        Forward</button>
                                         <a class="btn btn-danger" href="{{url('/delete/duplicate/entry')}}" onclick="return confirm('Are you sure ?');" data-bs-toggle="tooltip"
                                          title="Delete Duplicate Entry."><i class="ri-delete-bin-fill align-bottom me-1"></i>Duplicate</a>
                                         <a class="btn btn-warning" href="{{url('admin/delete/dnd/entry')}}" onclick="return confirm('Are you sure ?');" data-bs-toggle="tooltip"
                                          title="Delete DND Entry."><i class="ri-delete-bin-fill align-bottom me-1"></i>DND</a>
                                    <button type="button" class="btn btn-success add-btn" id="create-btn"
                                        data-bs-toggle="modal" data-bs-target="#importleads"><i
                                            class="ri-add-line align-bottom me-1"></i> Import Leads</button>
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
                                                    <input class="form-check-input data-checkbox" type="checkbox"
                                                        id="checkAll" value="option">
                                                </div>
                                            </th>

                                            <th class="sort" data-sort="name">S.No.</th>
                                            <th class="sort" data-sort="name">Company Name</th>
                                            <th class="sort" data-sort="phone">Phone</th>
                                            <th class="sort" data-sort="company_name">Company Rep1</th>
                                            <th class="sort" data-sort="location">Business Address</th>
                                            <th class="sort" data-sort="name">Business City</th>
                                            <th class="sort" data-sort="name">Business State</th>
                                            <th class="sort" data-sort="name">Business Zip</th>
                                            <th class="sort" data-sort="name">Dot</th>
                                            <th class="sort" data-sort="name">Mc/Docket</th>
                                            <th class="sort" data-sort="date">Created Date</th>
                                            <th class="sort" data-sort="action">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="list form-check-all">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($datas as $data)
                                            <tr @if ($data->is_dnd) class="bg-warning" @endif>
                                                <th scope="row">
                                                    <div class="form-check">
                                                        <input class="form-check-input data-checkbox" type="checkbox"
                                                            name="data_id[]" value="{{ $data->id }}">
                                                    </div>
                                                </th>
                                                <td class="id" style="display:none;"><a href="javascript:void(0);"
                                                        class="fw-medium link-primary">#VZ2101</a></td>
                                                <td>
                                                    @php
                                                        echo $i;
                                                        $i++;
                                                    @endphp
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-grow-1 ms-2 name">{{ $data->company_name }}</div>
                                                    </div>
                                                </td>
                                                <td class="phone">{{ $data->phone }}</td>
                                                <td class="company_name">{{ $data->company_rep1 }}</td>
                                                <td class="location">{{ $data->business_address }}</td>
                                                <td class="location">{{ $data->business_city }}</td>
                                                <td class="location" data-state="{{ $data->business_state }}">{{ $data->business_state }}</td>
                                                <td class="phone">{{ $data->business_zip }}</td>
                                                <td class="phone">{{ $data->dot }}</td>
                                                <td class="phone">{{ $data->mc_docket }}</td>
                                                {{-- <td class="tags">
                                            <span class="badge bg-primary-subtle text-primary">Lead</span>
                                            <span class="badge bg-primary-subtle text-primary">Partner</span>
                                        </td> --}}
                                                <td class="date">
                                                    {{ \Carbon\Carbon::parse($data->created_at)->format('d M, Y') }}
                                                </td>
                                                <td>
                                                    <ul class="list-inline hstack gap-2 mb-0">
                                                        <li class="list-inline-item" data-bs-toggle="tooltip"
                                                            data-bs-trigger="hover" data-bs-placement="top"
                                                            title="Delete">
                                                            <a class="remove-item-btn" data-bs-toggle="modal"
                                                                href="#deleteRecordModal">
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
                            <div class="d-flex justify-content-end mt-3 d-none">
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
<div class="pagination">
    {{ $datas->links() }}
</div>
                        <!-- Modal -->
                        <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1"
                            aria-labelledby="deleteRecordLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="btn-close"></button>
                                    </div>
                                    <div class="modal-body p-5 text-center">
                                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                            colors="primary:#405189,secondary:#f06548"
                                            style="width:90px;height:90px"></lord-icon>
                                        <div class="mt-4 text-center">
                                            <h4 class="fs-semibold">You are about to delete a lead ?</h4>
                                            <p class="text-muted fs-14 mb-4 pt-1">Deleting your lead will
                                                remove all of your information from our database.</p>
                                            <div class="hstack gap-2 justify-content-center remove">

                                                <button class="btn btn-link link-success fw-medium text-decoration-none"
                                                    id="deleteRecord-close" data-bs-dismiss="modal"><i
                                                        class="ri-close-line me-1 align-middle"></i>
                                                    Close</button>
                                                <button class="btn btn-danger" id="delete-record">Yes,
                                                    Delete It!!</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end modal -->


                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                            aria-labelledby="offcanvasExampleLabel">
                            <div class="offcanvas-header bg-light">
                                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Leads Forward</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <!--end offcanvas-header-->

                            <div class="offcanvas-body">
                                <div class="mb-4">
                                    <label for="status-select"
                                        class="form-label text-muted text-uppercase fw-semibold mb-3">Managers</label>
                                    <div class="row g-2">
                                        @foreach ($managers as $manager)
                                            <div class="col-lg-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="mng_id[]"
                                                        value="{{ $manager->id }}">
                                                    <label class="form-check-label"
                                                        for="inlineCheckbox1">{{ $manager->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--end offcanvas-body-->
                            <div class="offcanvas-footer border-top p-3 text-center hstack gap-2">
                                <button class="btn btn-light w-100" type="reset">Clear</button>
                                <button type="submit" class="btn btn-primary w-100"><i class='bx bx-paper-plane'></i>
                                    Send</button>
                            </div>
                            <!--end offcanvas-footer-->

                        </div>
                        <!--end offcanvas-->

                    </div>
                </div>

            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#forwardButton').hide();

            $('.data-checkbox').on('change', function() {

                var atLeastOneChecked = $('.data-checkbox:checked').length > 0;

                if (atLeastOneChecked) {
                    $('#forwardButton').show();
                } else {
                    $('#forwardButton').hide();
                }
            });
            $('.selectAll').on('change', function() {

                var atLeastOneChecked = $('.data-checkbox:checked').length > 0;


                if (atLeastOneChecked) {
                    $('#forwardButton').show();
                } else {
                    $('#forwardButton').hide();
                }
            });
        });

        $(document).ready(function() {
            var baseUrl = "{{ asset('') }}";
            $('#showEditModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var userId = button.data('user-id'); // Extract user ID from data attribute

                // Make an AJAX request to fetch user data based on the user ID
                $.ajax({
                    url: '/admin/get/team/' + userId,
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
        $(document).ready(function() {
            // When the image icon is clicked, trigger the file input
            $('#image-input-label').click(function() {
                $('#image-input').click();
            });

            // When a file is selected, update the displayed image
            $('#image-input').change(function() {
                readURL(this); // Call a function to display the selected image
            });

            // Function to display the selected image
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#img').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
    <script>
    $(document).ready(function() {
        // Event handler for state filter change
        $('#stateFilter').on('change', function() {
            var selectedState = $(this).val().trim().toLowerCase(); // Trim and convert to lowercase for case-insensitive comparison
            $('#customerTable tbody tr').each(function() {
                var rowState = $(this).find('.location').data('state').trim(); // Get row state and convert to lowercase
                if (selectedState === '' || rowState === selectedState) {
                    $(this).show(); // Show row if it matches selected state or if no state is selected
                } else {
                    $(this).hide(); // Hide row if it doesn't match selected state
                }
            });
        });
    });
</script>
@endsection
