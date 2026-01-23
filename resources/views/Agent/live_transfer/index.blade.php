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
                                @if($transfer->live_transfer == 'yes')
                                    <span class="badge bg-success">Success</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>{{ $transfer->date ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="viewLead({{ $transfer->id }})">View</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchValue = this.value.toLowerCase();
    const tableRows = document.querySelectorAll('#leadsTable tbody tr');
    
    tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
    });
});

function viewLead(id) {
    // You can implement view lead functionality here
    alert('View lead functionality - ID: ' + id);
}
</script>
@endsection