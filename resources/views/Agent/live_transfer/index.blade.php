@extends('Agent.common.app')
<style>
.lead-card{
    background:#fff;
    border-radius:14px;
    border-left:5px solid #dc3545; /* Failed = red */
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    padding:16px;
    transition:all .25s ease;
    height:100%;
}

.lead-card:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 28px rgba(0,0,0,0.15);
}

.lead-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

.lead-header h6{
    margin:0;
    font-size:16px;
    font-weight:600;
}

.lead-badge{
    background:#dc3545;
    color:#fff;
    font-size:12px;
    padding:4px 10px;
    border-radius:20px;
}

.lead-body p{
    margin:4px 0;
    font-size:14px;
    color:#6c757d;
}

.lead-body i{
    margin-right:6px;
    color:#0d6efd;
}

.lead-footer{
    display:flex;
    gap:10px;
    margin-top:14px;
}

.lead-footer button{
    flex:1;
}
</style>
<style>
    .company-name{
    max-width: 180px;   /* apne UI ke hisaab se adjust kar lo */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin: 0;
}

</style>


@section('main')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                   <h5>Live Transfer Leads</h5>
                </div>
            </div>
            <div class="table-responsive">
               <div class="row" id="leadsContainer">
    @foreach($transfers as $transfer)
       <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
    <div class="lead-card">

        <!-- HEADER -->
        <div class="lead-header">
            <h6>{{ $transfer->company_name ?? 'N/A' }}</h6>
            <span class="lead-badge">Failed</span>
        </div>

        <!-- BODY -->
       <div class="lead-body">
   <p>
    <i class="bx bx-user"></i>
    <strong>Rep:</strong>
    <a href="#" 
       class="text-primary fw-semibold"
       data-id="{{ $transfer->id }}"
       data-company="{{ $transfer->company_name }}"
       data-phone="{{ $transfer->phone }}"
       data-email="{{ $transfer->email }}"
       data-rep="{{ $transfer->company_rep1 }}"
       data-address="{{ $transfer->business_address }}"
       data-city="{{ $transfer->business_city }}"
       data-state="{{ $transfer->business_state }}"
       data-zip="{{ $transfer->business_zip }}"
       data-dot="{{ $transfer->dot }}"
       data-mc="{{ $transfer->mc_docket }}"
       onclick="openModal(this)">
        {{ $transfer->company_rep1 ?? 'N/A' }}
    </a>
</p>


    <p>
        <i class="bx bx-phone"></i>
        {{ $transfer->phone ?? 'N/A' }}
    </p>

    <p>
        <i class="bx bx-envelope"></i>
        {{ $transfer->email ?? 'N/A' }}
    </p>

    <p>
        <i class="bx bx-calendar"></i>
        {{ $transfer->date ?? 'N/A' }}
    </p>
</div>


        <!-- FOOTER -->
        <div class="lead-footer">
    <button 
        class="btn btn-outline-primary btn-sm"
        onclick="viewLead(
            '{{ $transfer->id }}',
            '{{ addslashes($transfer->comment ?? 'No reason provided') }}'
        )">
        View
    </button>

    <button 
        class="btn btn-success btn-sm"
        onclick="resubmitTransfer({{ $transfer->id }})">
        Re-submit
    </button>
</div>
<style>
    .btn-success{
    background-color: #198754 !important;
    border-color: #198754 !important;
    color: #fff !important;
}

</style>


    </div>
</div>

    @endforeach
</div>

            </div>
        </div>
    </div>
</div>

<!-- Re-submit Modal -->
<div class="modal fade" id="resubmitModal" tabindex="-1" aria-labelledby="resubmitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resubmitModalLabel">Re-submit Live Transfer</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>


            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="resubmitReason" class="form-label">Reason for Re-submission <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="resubmitReason" rows="4" placeholder="Please explain why you are re-submitting this form..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <button type="button" class="btn btn-success" onclick="submitResubmit()">Re-submit</button>
            </div>
        </div>
    </div>
</div>



 {{-- modal start --}}
                <div class="modal fade" id="exampleFullScreenModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog" style="max-width: 100%; margin: 30px;">
                        <div class="modal-content">
                            <div class="modal-header border-bottom">
                                <h4>Lead</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                            </div>
                            <div class="modal-body" style="padding:40px">
                                <form action="{{ route('intrested_check') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="data_id" value="" id="data_id">
                                    <input type="hidden" name="forword_id" value="" id="forword_id">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row border-end ">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="firstNameinput" class="form-label">Company Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter company name"
                                                            id="company_name" name="company_name">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="lastNameinput" class="form-label">Phone <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter phone number"
                                                            id="phone" name="phone">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="email" class="form-label">Email </label>
                                                        <input type="email" class="form-control" placeholder="example@gmail.com"
                                                            id="email" name="email">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="compnayNameinput" class="form-label">Company Rep1 <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter company rep..."
                                                            id="company_rep1" name="company_rep1">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="emailidInput" class="form-label">Business Address <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter business address" id="business_address"
                                                            name="business_address">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="address1ControlTextarea" class="form-label">Business City <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter business city"
                                                            id="business_city" name="business_city">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Business State <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter business state"
                                                            id="business_state" name="business_state">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Business ZIP <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter business zip"
                                                            id="business_zip" name="business_zip">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">DOT <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter DOT"
                                                            id="dot" name="dot" required="">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">MC/Docket <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter MC"
                                                            id="mc_docket" name="mc_docket">
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-12 mb-3">
                                                    <h5>Commodities</h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Building Materials - Machinery" id="building_machinery">
                                                            <label for="citynameInput" class="form-label"> Building Materials -
                                                                Machinery</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Building Materials" id="buildingmaterials">
                                                            <label for="citynameInput" class="form-label"> Building Materials</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Dry Freight - Amazon" id="Dry-Freight-Amazon">
                                                            <label for="citynameInput" class="form-label"> Dry Freight -
                                                                Amazon</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Dry Freight" id="Dry-Freight">
                                                            <label for="citynameInput" class="form-label"> Dry Freight</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Reefer with seafood or flowers" id="Reefer_with_seafood_or_flowers">
                                                            <label for="citynameInput" class="form-label"> Reefer with seafood or
                                                                flowers</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Refrigerated Goods" id="Refrigerated_Goods">
                                                            <label for="citynameInput" class="form-label"> Refrigerated Goods</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Reefer with flowers" id="Reefer_with_flowers">
                                                            <label for="citynameInput" class="form-label"> Reefer with flowers</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Fracking Sand" id="Fracking-Sand">
                                                            <label for="citynameInput" class="form-label"> Fracking Sand</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Hazard" id="Hazard">
                                                            <label for="citynameInput" class="form-label"> Hazard</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Containerized Freight" id="Containerized-Freight">
                                                            <label for="citynameInput" class="form-label"> Containerized
                                                                Freight</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Sand &amp; Gravel" id="SandGravel">
                                                            <label for="citynameInput" class="form-label"> Sand &amp; Gravel</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Auto 100%" id="100">
                                                            <label for="citynameInput" class="form-label"> Auto 100%</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="checkbox" class="form-check-input" name="commodities[]"
                                                                value="Hauls Oversized/Overweight" id="HaulsOversizedOverweight">
                                                            <label for="citynameInput" class="form-label"> Hauls
                                                                Oversized/Overweight</label>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <!-- Vehicle & Driver Information -->
                                                <div class="col-12">
                                                    <div class="mb-3">
                                                        <label for="ForminputState" class="form-label">Unit Owned <span
                                                                class="text-danger">*</span></label>
                                                        <select id="unit_owned2" class="form-control" name="unit_owned">
                                                            <option value="1" selected>1</option>
                                                            <option value="2">2</option>
                                                            <option value="3">3</option>
                                                            <option value="4">4</option>
                                                            <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">VIN <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter VIN"
                                                            id="vin" name="vin">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver Name <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter driver name"
                                                            id="driver_name" name="driver_name">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver DOB <span
                                                                class="text-danger">*</span></label>
                                                        <input type="date" class="form-control" placeholder="mm/dd/yyyy"
                                                            id="driver_dob" name="driver_dob">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter driver license"
                                                            id="driver_license" name="driver_license">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Driver License State <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" placeholder="Enter driver license state"
                                                            id="driver_license_state" name="driver_license_state">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Year</label>
                                                        <input type="number" class="form-control" placeholder="YYYY"
                                                            id="vehicle_year" name="vehicle_year">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Vehicle Make</label>
                                                        <input type="text" class="form-control" placeholder="Enter Vehicle make..."
                                                            id="vehicle_make" name="vehicle_make">
                                                    </div>
                                                </div><!--end col-->
                                                
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Stated Value</label>
                                                        <input type="text" class="form-control" placeholder="Enter stated value"
                                                            id="stated_value" name="stated_value">
                                                    </div>
                                                </div><!--end col-->
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="row text-center">
                                                <div class="col-12">
                                                    <img src="{{ asset('assets/images/phonetics.png') }}" alt=""
                                                        height="400" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="row mt-4">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="ForminputState" class="form-label">Status<span
                                                                class="text-danger">*</span></label>
                                                        <select id="form_status2" class="form-control" name="form_status"
                                                            required="">
                                                            <option value="Intrested">Intrested</option>
                                                            <option value="Pipeline">Pipeline</option>
                                                        </select>
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-6">
    <div class="pt-0">
        <label class="form-label">Mode</label>

        <select name="contact_mode"
                class="form-select lock-contact-mode"
                disabled>
            <option value="">Select Mode</option>
            <option value="Call" selected>Voice</option>
            <option value="Email">Email</option>
        </select>
    </div>
</div>

                                               <!-- Good / Bad Form -->
<div class="col-6">
    <div class="mb-3">
        <label class="form-check-label">
            <input type="checkbox" name="redmark" id="coverwell" value="2"
                   class="form-check-input"
                   onclick="toggleCheckbox('coverwell', 'redmark')">
            Good Form
        </label>
    </div>
</div>

<div class="col-6">
    <div class="mb-3">
        <label class="form-check-label">
            <input type="checkbox" name="redmark" id="redmark" value="1"
                   class="form-check-input"
                   onclick="toggleCheckbox('redmark', 'coverwell')">
            Bad Form
        </label>
    </div>
</div>

<!-- ✅ LOSS RUNS ADDED HERE -->
<div class="col-6">
    <div class="mb-3">
        <label class="form-label">
            Loss Runs <span class="text-danger">*</span>
        </label>

        <select name="loss_runs" class="form-select">
          
            <option value="yes" {{ old('loss_runs') == 'yes' ? 'selected' : '' }}>Yes</option>
            <option value="no" {{ old('loss_runs') == 'no' ? 'selected' : '' }}>No</option>
        </select>

        <!-- Validation Error -->
        @error('loss_runs')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
    </div>
</div>
<div class="col-6">
    <div class="mb-3">
        <label class="form-label fw-semibold">
            Live Transfer <span class="text-danger">*</span>
        </label>

        <select name="live_transfer" class="form-select shadow-sm">
            <option value="yes" {{ old('live_transfer', 'yes') == 'yes' ? 'selected' : '' }}>
                Yes
            </option>
            <option value="no" {{ old('live_transfer') == 'no' ? 'selected' : '' }}>
                No
            </option>
        </select>

        <!-- Validation Error -->
        @error('live_transfer')
            <small class="text-danger d-block mt-1">{{ $message }}</small>
        @enderror
    </div>
</div>

                                                 <div class="col-12" >
                                                    <div class="mb-3">
                                                        <label for="citynameInput" class="form-label">Comment </label>
                                                        <textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Write a Coment...."
                                                            required=""></textarea>
                                                    </div>
                                                </div><!--end col-->
                                               
                                                <div class="col-lg-12">
                                                    <div class="text-end">
                                                        <div class="mt-4">
                                                            <div class="hstack gap-2 justify-content-center">
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-link link-danger fw-medium"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="ri-close-line me-1 align-middle"></i>
                                                                    Close</a>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
                                        </div>
                                    </div><!--end row-->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- jQuery FIRST -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Document ready, jQuery loaded:', typeof $ !== 'undefined');
    console.log('Bootstrap loaded:', typeof bootstrap !== 'undefined');
    
    // Modal close functionality
    $('.close, [data-dismiss="modal"]').click(function() {
        $('#viewLeadModal').modal('hide');
        $('#resubmitModal').modal('hide');
    });
});

let currentLeadId = null;
let searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('.lead-card').forEach(card => {
            card.style.display = card.innerText.toLowerCase().includes(value)
                ? 'block'
                : 'none';
        });
    });
}

function viewLead(id, reason) {
    let displayText = 'No reason provided';
    
    try {
        const comments = JSON.parse(reason);
        if (Array.isArray(comments) && comments.length > 0) {
            const lastComment = comments[comments.length - 1];
            displayText = lastComment.comment || 'No reason provided';
        }
    } catch (e) {
        displayText = reason || 'No reason provided';
    }
    
    document.getElementById('adminReason').textContent = displayText;
    $('#viewLeadModal').modal('show');
}

function resubmitTransfer(id) {
    currentLeadId = id;
    document.getElementById('resubmitReason').value = '';
    $('#resubmitModal').modal('show');
}

function submitResubmit() {
    const reason = document.getElementById('resubmitReason').value.trim();
    
    if (!reason) {
        alert('Please enter a reason for re-submission');
        return;
    }
    
    $.ajax({
        url: '{{ route("agent.resubmit.transfer") }}',
        method: 'POST',
        data: {
            lead_id: currentLeadId,
            reason: reason,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                $('#resubmitModal').modal('hide');
                alert('Form re-submitted successfully!');
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('Error re-submitting form: ' + error);
        }
    });
}

function openModal(element) {
    // Get data from attributes
    const id = element.getAttribute('data-id');
    const company = element.getAttribute('data-company');
    const phone = element.getAttribute('data-phone');
    const email = element.getAttribute('data-email');
    const rep = element.getAttribute('data-rep');
    const address = element.getAttribute('data-address');
    const city = element.getAttribute('data-city');
    const state = element.getAttribute('data-state');
    const zip = element.getAttribute('data-zip');
    const dot = element.getAttribute('data-dot');
    const mc = element.getAttribute('data-mc');
    
    // Set form values
    document.getElementById('data_id').value = id;
    document.getElementById('forword_id').value = id;
    document.getElementById('company_name').value = company || '';
    document.getElementById('phone').value = phone || '';
    document.getElementById('email').value = email || '';
    document.getElementById('company_rep1').value = rep || '';
    document.getElementById('business_address').value = address || '';
    document.getElementById('business_city').value = city || '';
    document.getElementById('business_state').value = state || '';
    document.getElementById('business_zip').value = zip || '';
    document.getElementById('dot').value = dot || '';
    document.getElementById('mc_docket').value = mc || '';
    
    // Show modal
    $('#exampleFullScreenModal').modal('show');
}

function openLeadForm(id, transfer) {
    alert('Function called with ID: ' + id);
    console.log('Opening form for ID:', id);
    console.log('Transfer data:', transfer);
    
    // Set form values
    document.getElementById('data_id').value = id;
    document.getElementById('forword_id').value = id;

    document.getElementById('company_name').value = transfer.company_name || '';
    document.getElementById('phone').value = transfer.phone || '';
    document.getElementById('email').value = transfer.email || '';
    document.getElementById('company_rep1').value = transfer.company_rep1 || '';
    document.getElementById('business_address').value = transfer.business_address || '';
    document.getElementById('business_city').value = transfer.business_city || '';
    document.getElementById('business_state').value = transfer.business_state || '';
    document.getElementById('business_zip').value = transfer.business_zip || '';
    document.getElementById('dot').value = transfer.dot || '';
    document.getElementById('mc_docket').value = transfer.mc_docket || '';

    // Show modal
    $('#exampleFullScreenModal').modal('show');
}
</script>



<!-- View Lead Modal -->
<div class="modal fade" id="viewLeadModal" tabindex="-1" aria-labelledby="viewLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewLeadModalLabel">Admin Rejection Reason</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Reason for Rejection:</label>
                    <div class="alert alert-warning" id="adminReason">
                        <!-- Admin reason will be displayed here -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

            </div>
        </div>
    </div>
</div>



@endsection