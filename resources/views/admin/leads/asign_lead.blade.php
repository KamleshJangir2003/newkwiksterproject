@extends('admin.common.app')
@section('main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    .select-card {
        margin-right: 10px;
        cursor: pointer;
    }
    .card {
        cursor: pointer;
        border: 1px solid #ddd;
        transition: box-shadow 0.3s ease;
    }
    .card.selected {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
    }
    .card-footer {
        display: none;
    }
    .card-footer.active {
        display: block;
    }
    .header-delete-btn {
        display: none;
        margin-bottom: 10px;
    }
    .header-delete-btn.active {
        display: block;
    }
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    /* Empty state styles */
    .empty-state {
        text-align: center;
        padding: 40px 0;
        margin: 50px auto;
        max-width: 500px;
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .empty-state-icon {
        font-size: 80px;
        color: #6c757d;
        margin-bottom: 20px;
    }
    .empty-state-title {
        font-size: 24px;
        color: #343a40;
        margin-bottom: 10px;
    }
    .empty-state-message {
        font-size: 16px;
        color: #6c757d;
        margin-bottom: 20px;
    }
    .empty-state-action {
        margin-top: 20px;
    }
</style>
<style>
    /* Add this to your CSS */
    .empty-state-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 60vh;
        padding: 2rem;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    
    .empty-state {
        text-align: center;
        max-width: 500px;
        padding: 2.5rem;
    }
    
    .empty-state-icon {
        margin-bottom: 1.5rem;
        animation: float 6s ease-in-out infinite;
    }
    
    .empty-state-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #2d3436;
        margin-bottom: 1rem;
    }
    
    .empty-state-message {
        font-size: 1.1rem;
        color: #636e72;
        line-height: 1.6;
        margin-bottom: 2rem;
    }
    
    .empty-state-actions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .btn-gradient {
        background: linear-gradient(135deg, #0098b6 0%, #a29bfe 100%);
        border: none;
        color: white;
        box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
        transition: all 0.3s ease;
    }
    
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 92, 231, 0.4);
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    /* Animation classes */
    .animate__animated {
        animation-duration: 1s;
        animation-fill-mode: both;
    }
    
    .animate__fadeIn {
        animation-name: fadeIn;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header"></div>
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <!-- show success and error messages -->
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <!-- End show success and error messages -->
                    
                    <div class="action-buttons">
                        <h4>Assigned Leads</h4>
                        <div>
                            <!-- User Filter Dropdown -->
                            <div class="btn-group mr-2">
                                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Filter by User
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('assigned_leads') }}">All Users</a>
                                    @foreach($users as $user)
                                    @php
                                        $alise =App\adminmodel\Users_detailsModal::where('ajent_id',$user->id)->select('alise_name')->first();
                                    @endphp
                                       <a class="dropdown-item" href="{{ route('assigned_leads', ['user_id' => $user->id]) }}">
   {{ $user->name }}({{ optional($alise)->alise_name ?? 'N/A' }})
</a>

                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- Delete Selected Form -->
                            <form id="delete-form" method="POST" action="{{ route('bluck_delete_assign') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="selected_ids" id="selected-ids" value="">
                                <button type="button" class="btn btn-danger" id="delete-selected-btn" style="display: none">Delete Selected</button>
                            </form>
                            
                            <!-- Select All Button -->
                            <button type="button" class="btn btn-info ml-2" id="select-all-btn">Select All</button>
                        </div>
                    </div>
                    
                  @if($datas && $datas->count() > 0)
                        <div class="row">
                            @foreach($datas as $data)
                                @php
                                    $data_id = json_decode($data->data_id);
                                    $ids = explode(',', $data_id[0]);
                                    $total = count($ids);
                                    $user = App\Models\User::whereNull('deleted_at')
                                        ->where('id', $data->agent_id)
                                        ->first();
                                        $alise =App\adminmodel\Users_detailsModal::where('ajent_id',$user->id)->select('alise_name')->first();
                                @endphp
                                <div class="col-xl-3 col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-block" onclick="toggleCardSelection(this)">
                                            <div class="row align-items-center">
                                                <div class="col-8">
                                                    <input type="checkbox" class="select-card" data-id="{{ $data->id }}">
                                                    <h5 class="text-c-purple m-b-10">{{ $total }} Data To</h5>
                                                    <h6 class="text-muted m-b-1">
                                                        <span class="badge badge-dark" style="padding: 5px; font-size:12px; font-weight:50">
                                                            {{ $user->name ?? 'Unknown' }} ({{ $alise->alise_name ?? 'Unknown' }})
                                                        </span>
                                                    </h6>
                                                    <h6 class="text-muted m-b-0">Date: {{ $data->created_at->format('Y-m-d H:i') }}</h6>
                                                </div>
                                                <div class="col-4 text-right">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="fill:green; width: 30px; height: 30px;">
                                                        <path d="M190.5 68.8L225.3 128H224 152c-22.1 0-40-17.9-40-40s17.9-40 40-40h2.2c14.9 0 28.8 7.9 36.3 20.8zM64 88c0 14.4 3.5 28 9.6 40H32c-17.7 0-32 14.3-32 32v64c0 17.7 14.3 32 32 32H480c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H438.4c6.1-12 9.6-25.6 9.6-40c0-48.6-39.4-88-88-88h-2.2c-31.9 0-61.5 16.9-77.7 44.4L256 85.5l-24.1-41C215.7 16.9 186.1 0 154.2 0H152C103.4 0 64 39.4 64 88zm336 0c0 22.1-17.9 40-40 40H288h-1.3l34.8-59.2C329.1 55.9 342.9 48 357.8 48H360c22.1 0 40 17.9 40 40zM32 288V464c0 26.5 21.5 48 48 48H224V288H32zM288 512H432c26.5 0 48-21.5 48-48V288H288V512z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-c-purple">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        onclick="window.location.href='{{ route('assigned_leads_view', ['assign' => base64_encode($data->id)]) }}'">
                                                        View Data
                                                    </button>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button class="btn btn-danger btn-sm"
                                                        onclick="window.location.href='{{ route('assigned_leads_delete', [base64_encode($data->id)]) }}'">
                                                        <i class="ti-trash"></i> All
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                       <div class="empty-state-container">
    <div class="empty-state animate__animated animate__fadeIn">
        <div class="empty-state-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="#0098b6" viewBox="0 0 24 24">
                <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>
            </svg>
        </div>
        <h3 class="empty-state-title">No Leads Assigned Yet</h3>
        <p class="empty-state-message">Your lead inbox is currently empty. When new leads are assigned to you, they'll appear here.</p>
        
        <div class="empty-state-actions">
            <a href="#" class="btn btn-primary btn-lg btn-gradient">
                <i class="fas fa-layer-group"></i>Return to Tab View
            </a>
        </div>
    </div>
</div>
                    @endif
                </div>
                <!-- Page-body end -->
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedIds = [];
        const deleteForm = document.getElementById('delete-form');
        const selectedIdsInput = document.getElementById('selected-ids');
        const deleteBtn = document.getElementById('delete-selected-btn');
        const selectAllBtn = document.getElementById('select-all-btn');
        
        // Initialize card footers to be hidden
        document.querySelectorAll('.card-footer').forEach(footer => {
            footer.style.display = 'none';
        });
        
        // Handle card click (anywhere on the card except the checkbox)
        function handleCardClick(cardBlock, event) {
            // Don't do anything if the click was on the checkbox
            if (event.target.classList.contains('select-card')) {
                return;
            }
            
            const card = cardBlock.closest('.card');
            const checkbox = card.querySelector('.select-card');
            const footer = card.querySelector('.card-footer');
            
            // Toggle footer visibility
            if (footer.style.display === 'none') {
                footer.style.display = 'block';
            } else {
                footer.style.display = 'none';
            }
            
            // Don't toggle checkbox when clicking on footer buttons
            if (!event.target.closest('.card-footer')) {
                checkbox.checked = !checkbox.checked;
                
                // Update card appearance and selectedIds
                if (checkbox.checked) {
                    card.classList.add('selected');
                    if (!selectedIds.includes(checkbox.dataset.id)) {
                        selectedIds.push(checkbox.dataset.id);
                    }
                } else {
                    card.classList.remove('selected');
                    selectedIds = selectedIds.filter(id => id !== checkbox.dataset.id);
                }
                
                // Update hidden input and delete button visibility
                selectedIdsInput.value = selectedIds.join(',');
                deleteBtn.style.display = selectedIds.length > 0 ? 'inline-block' : 'none';
                
                // Update Select All button text if needed
                updateSelectAllButton();
            }
        }
        
        // Update Select All button text
        function updateSelectAllButton() {
            const totalCheckboxes = document.querySelectorAll('.select-card').length;
            if (selectedIds.length === totalCheckboxes) {
                selectAllBtn.textContent = 'Deselect All';
            } else {
                selectAllBtn.textContent = 'Select All';
            }
        }
        
        // Attach click handlers to all card blocks
        document.querySelectorAll('.card-block').forEach(cardBlock => {
            cardBlock.addEventListener('click', function(event) {
                handleCardClick(this, event);
            });
        });
        
        // Select All functionality
        selectAllBtn.addEventListener('click', function() {
            const checkboxes = document.querySelectorAll('.select-card');
            let allChecked = true;
            
            // Check if all are already selected
            checkboxes.forEach(checkbox => {
                if (!checkbox.checked) allChecked = false;
            });
            
            // Toggle all checkboxes
            checkboxes.forEach(checkbox => {
                const card = checkbox.closest('.card');
                const footer = card.querySelector('.card-footer');
                
                checkbox.checked = !allChecked;
                if (checkbox.checked) {
                    card.classList.add('selected');
                    footer.style.display = 'block';
                    if (!selectedIds.includes(checkbox.dataset.id)) {
                        selectedIds.push(checkbox.dataset.id);
                    }
                } else {
                    card.classList.remove('selected');
                    footer.style.display = 'none';
                    selectedIds = selectedIds.filter(id => id !== checkbox.dataset.id);
                }
            });
            
            // Update button text and hidden input
            selectAllBtn.textContent = allChecked ? 'Select All' : 'Deselect All';
            selectedIdsInput.value = selectedIds.join(',');
            deleteBtn.style.display = !allChecked && selectedIds.length > 0 ? 'inline-block' : 'none';
        });
        
        // Delete Selected functionality
        deleteBtn.addEventListener('click', function() {
            if (selectedIds.length === 0) {
                alert('Please select at least one item to delete.');
                return;
            }
            
            if (confirm('Are you sure you want to delete the selected items?')) {
                deleteForm.submit();
            }
        });
        
        // Individual checkbox change handler
        document.querySelectorAll('.select-card').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const card = this.closest('.card');
                const footer = card.querySelector('.card-footer');
                
                if (this.checked) {
                    card.classList.add('selected');
                    footer.style.display = 'block';
                    if (!selectedIds.includes(this.dataset.id)) {
                        selectedIds.push(this.dataset.id);
                    }
                } else {
                    card.classList.remove('selected');
                    footer.style.display = 'none';
                    selectedIds = selectedIds.filter(id => id !== this.dataset.id);
                }
                
                // Update hidden input and button visibility
                selectedIdsInput.value = selectedIds.join(',');
                deleteBtn.style.display = selectedIds.length > 0 ? 'inline-block' : 'none';
                updateSelectAllButton();
            });
        });
    });
</script>
@endsection