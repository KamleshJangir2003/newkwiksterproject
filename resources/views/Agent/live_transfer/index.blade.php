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
        {{ $transfer->company_rep1 ?? 'N/A' }}
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="resubmitReason" class="form-label">Reason for Re-submission <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="resubmitReason" rows="4" placeholder="Please explain why you are re-submitting this form..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitResubmit()">Re-submit</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentLeadId = null;

// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#leadsTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

function viewLead(id, reason) {
    let displayText = 'No reason provided';
    
    try {
        // Parse JSON if it's a JSON string
        const comments = JSON.parse(reason);
        if (Array.isArray(comments) && comments.length > 0) {
            // Get the last comment's text only
            const lastComment = comments[comments.length - 1];
            displayText = lastComment.comment || 'No reason provided';
        }
    } catch (e) {
        // If not JSON, use as plain text
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
    
    console.log('Submitting resubmit for lead:', currentLeadId, 'with reason:', reason);
    
    $.ajax({
        url: '{{ route("agent.resubmit.transfer") }}',
        method: 'POST',
        data: {
            lead_id: currentLeadId,
            reason: reason,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log('Response:', response);
            if (response.success) {
                $('#resubmitModal').modal('hide');
                alert('Form re-submitted successfully!');
                location.reload();
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', xhr.responseText);
            alert('Error re-submitting form: ' + error);
        }
    });
}

// Modal close functionality
$(document).ready(function() {
    $('.close, [data-dismiss="modal"]').click(function() {
        $('#viewLeadModal').modal('hide');
        $('#resubmitModal').modal('hide');
    });
});
</script>
<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('.lead-card').forEach(card => {
        card.style.display = card.innerText.toLowerCase().includes(value)
            ? 'block'
            : 'none';
    });
});
</script>


<!-- View Lead Modal -->
<div class="modal fade" id="viewLeadModal" tabindex="-1" aria-labelledby="viewLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewLeadModalLabel">Admin Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection