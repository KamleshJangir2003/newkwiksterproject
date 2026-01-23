@extends('Agent.common.app')

@section('main')
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position-relative">
                    <input type="text" class="form-control ps-5 radius-30" placeholder="Search Live Transfer Leads" id="searchInput">
                    <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table mb-0" id="leadsTable">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Company Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Live Transfer</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transfers as $transfer)
                        <tr>
                            <td>{{ $transfer->id }}</td>
                            <td>{{ $transfer->company_name ?? 'N/A' }}</td>
                            <td>{{ $transfer->phone ?? 'N/A' }}</td>
                            <td>{{ $transfer->email ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-danger">Failed</span>
                            </td>
                            <td>{{ $transfer->date ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="viewLead('{{ $transfer->id }}', '{{ addslashes($transfer->comment ?? 'No reason provided') }}')">View</button>
                                <button class="btn btn-success btn-sm ms-1" onclick="resubmitTransfer({{ $transfer->id }})">Re-submit</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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