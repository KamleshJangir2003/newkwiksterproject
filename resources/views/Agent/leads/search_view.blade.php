@extends('Agent.layouts.app')

@section('style')
<link rel="stylesheet" href="{{ asset('Agent/assets/css/search-leads.css') }}">
@endsection

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Search Leads</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Leads</a></li>
                            <li class="breadcrumb-item active">Search</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Search Leads</h4>
                    </div>
                    <div class="card-body">
                        <!-- Search Form -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="input-group search-input-group">
                                    <input type="text" class="form-control" id="searchInput" 
                                           placeholder="Search by company name, phone, email, DOT, MC..." 
                                           value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="button" id="searchBtn">
                                        <i class="ri-search-line"></i> Search
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-secondary" type="button" id="clearBtn">
                                    <i class="ri-refresh-line"></i> Clear
                                </button>
                            </div>
                        </div>

                        <!-- Search Results -->
                        <div id="searchResults" class="search-results-container">
                            @if(isset($leads) && $leads->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Company Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>DOT</th>
                                                <th>MC</th>
                                                <th>Status</th>
                                                <th>Owner</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($leads as $lead)
                                                <tr>
                                                    <td>{{ $lead->company_name ?? 'N/A' }}</td>
                                                    <td>{{ $lead->phone ?? 'N/A' }}</td>
                                                    <td>{{ $lead->email ?? 'N/A' }}</td>
                                                    <td>{{ $lead->dot ?? 'N/A' }}</td>
                                                    <td>{{ $lead->mc_docket ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $lead->form_status == 'Intrested' ? 'success' : ($lead->form_status == 'Pipeline' ? 'warning' : 'secondary') }}">
                                                            {{ $lead->form_status ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($lead->click_id)
                                                            @php
                                                                $owner = \App\Models\User::find($lead->click_id);
                                                            @endphp
                                                            {{ $owner->name ?? 'Unknown' }}
                                                        @else
                                                            <span class="text-muted">Unassigned</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($lead->click_id == session('agent_id'))
                                                            <!-- Owner can edit -->
                                                            <button class="btn btn-sm btn-primary" onclick="viewLead({{ $lead->id }}, true)">
                                                                <i class="ri-edit-line"></i> Edit
                                                            </button>
                                                        @else
                                                            <!-- Other agents can only view -->
                                                            <button class="btn btn-sm btn-info" onclick="viewLead({{ $lead->id }}, false)">
                                                                <i class="ri-eye-line"></i> View Only
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                @if(method_exists($leads, 'links'))
                                    <div class="d-flex justify-content-center">
                                        {{ $leads->appends(request()->query())->links() }}
                                    </div>
                                @endif
                            @elseif(request('search'))
                                <div class="text-center py-4">
                                    <div class="avatar-sm mx-auto mb-4">
                                        <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-20">
                                            <i class="ri-search-line"></i>
                                        </div>
                                    </div>
                                    <h5 class="mt-2">No Results Found</h5>
                                    <p class="text-muted">No leads found matching your search criteria.</p>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <div class="avatar-sm mx-auto mb-4">
                                        <div class="avatar-title bg-secondary-subtle text-secondary rounded-circle fs-20">
                                            <i class="ri-search-2-line"></i>
                                        </div>
                                    </div>
                                    <h5 class="mt-2">Start Searching</h5>
                                    <p class="text-muted">Enter search terms above to find leads.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lead View/Edit Modal -->
<div class="modal fade" id="leadModal" tabindex="-1" aria-labelledby="leadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leadModalLabel">Lead Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="leadModalBody">
                <!-- Lead details will be loaded here -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    // Search functionality
    $('#searchBtn').click(function() {
        performSearch();
    });

    $('#searchInput').keypress(function(e) {
        if (e.which == 13) {
            performSearch();
        }
    });

    $('#clearBtn').click(function() {
        $('#searchInput').val('');
        window.location.href = '{{ route("agent_search_leads") }}';
    });

    function performSearch() {
        const searchTerm = $('#searchInput').val().trim();
        if (searchTerm.length < 2) {
            alert('Please enter at least 2 characters to search');
            return;
        }

        window.location.href = '{{ route("agent_search_leads") }}?search=' + encodeURIComponent(searchTerm);
    }
});

function viewLead(leadId, canEdit) {
    $.ajax({
        url: '{{ route("agent_get_lead_details", ":id") }}'.replace(':id', leadId),
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const lead = response.lead;
                const isOwner = lead.click_id == {{ session('agent_id') }};
                
                let modalTitle = canEdit ? 'Edit Lead' : 'View Lead (Read Only)';
                $('#leadModalLabel').text(modalTitle);
                
                let modalBody = generateLeadForm(lead, canEdit && isOwner);
                $('#leadModalBody').html(modalBody);
                
                if (!canEdit || !isOwner) {
                    // Disable all form inputs for non-owners
                    $('#leadModalBody input, #leadModalBody select, #leadModalBody textarea').prop('disabled', true);
                    $('#leadModalBody .btn-primary').hide();
                    
                    // Show read-only message
                    $('#leadModalBody').prepend(`
                        <div class="alert alert-info">
                            <i class="ri-information-line"></i> 
                            This lead belongs to another agent. You can only view the details.
                        </div>
                    `);
                }
                
                $('#leadModal').modal('show');
            } else {
                alert('Error loading lead details: ' + response.message);
            }
        },
        error: function() {
            alert('Error loading lead details. Please try again.');
        }
    });
}

function generateLeadForm(lead, canEdit) {
    return `
        <form id="leadForm" ${canEdit ? 'onsubmit="updateLead(event)"' : ''}>
            <input type="hidden" name="lead_id" value="${lead.id}">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" class="form-control" name="company_name" value="${lead.company_name || ''}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone" value="${lead.phone || ''}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="${lead.email || ''}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">DOT Number</label>
                        <input type="text" class="form-control" name="dot" value="${lead.dot || ''}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">MC Number</label>
                        <input type="text" class="form-control" name="mc_docket" value="${lead.mc_docket || ''}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="form_status">
                            <option value="Intrested" ${lead.form_status == 'Intrested' ? 'selected' : ''}>Interested</option>
                            <option value="Pipeline" ${lead.form_status == 'Pipeline' ? 'selected' : ''}>Pipeline</option>
                            <option value="Voice Mail" ${lead.form_status == 'Voice Mail' ? 'selected' : ''}>Voice Mail</option>
                            <option value="Not Interested" ${lead.form_status == 'Not Interested' ? 'selected' : ''}>Not Interested</option>
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label">Comment</label>
                        <textarea class="form-control" name="comment" rows="3">${lead.comment || ''}</textarea>
                    </div>
                </div>
            </div>
            
            ${canEdit ? `
                <div class="text-end">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Lead</button>
                </div>
            ` : ''}
        </form>
    `;
}

function updateLead(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    
    $.ajax({
        url: '{{ route("agent_update_search_lead") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                alert('Lead updated successfully!');
                $('#leadModal').modal('hide');
                location.reload();
            } else {
                alert('Error updating lead: ' + response.message);
            }
        },
        error: function() {
            alert('Error updating lead. Please try again.');
        }
    });
}
</script>
@endsection