@extends('admin.common.app')

@section('main')
<style>
/* ===== BOOTSTRAP GUTTER FIX ===== */
.main-zoom-wrapper {
    padding: 15px;
}

/* Bootstrap negative margins fix */
.main-zoom-wrapper .row {
    margin-left: 0 !important;
    margin-right: 0 !important;
}

/* Extra padding remove from columns */
.main-zoom-wrapper [class*="col-"] {
    padding-left: 8px;
    padding-right: 8px;
}

/* Desktop - sidebar spacing */
@media (min-width: 992px) {
    .main-zoom-wrapper {
        margin-left: 220px;
    }
}

/* Tablet & Mobile */
@media (max-width: 991px) {
    .main-zoom-wrapper {
        margin-left: 0;
    }
}

/* Mobile spacing */
@media (max-width: 576px) {
    .zoom-card {
        margin-bottom: 15px;
    }
}

/* Card styling */
.zoom-card {
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: 0.3s;
    border: none;
}

.zoom-card:hover {
    transform: translateY(-5px);
}

.zoom-icon {
    font-size: 28px;
    margin-bottom: 8px;
}
</style>

<style>
/* ----- RESPONSIVE FIX ----- */
.main-zoom-wrapper {
    padding: 15px;
}

/* Desktop */
@media (min-width: 992px) {
    .main-zoom-wrapper {
        margin-left: 220px;
    }
}

/* Tablet */
@media (max-width: 991px) {
    .main-zoom-wrapper {
        margin-left: 0;
    }
}

/* Mobile */
@media (max-width: 576px) {
    .zoom-card {
        margin-bottom: 15px;
    }
}

/* Card styling */
.zoom-card {
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    transition: 0.3s;
    border: none;
}

.zoom-card:hover {
    transform: translateY(-5px);
}

.zoom-icon {
    font-size: 28px;
    margin-bottom: 8px;
}
</style>

<div class="main-zoom-wrapper">
    <div class="row">
        <div class="col-12">

            <div class="card mt-3 zoom-card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">🎥 Zoom Management</h5>
                    <button class="btn btn-primary btn-sm">+ New Meeting</button>
                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <!-- Meetings -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="card p-4 zoom-card h-100">
                                <div class="zoom-icon text-primary">📅</div>
                                <h6>Zoom Meetings</h6>
                                <p class="text-muted">Manage and track all scheduled meetings.</p>
                                <a href="#" class="btn btn-outline-primary btn-sm w-100">
                                    View Meetings
                                </a>
                            </div>
                        </div>

                        <!-- Create Zoom ID -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="card p-4 zoom-card h-100">
                                <div class="zoom-icon text-success">🆔</div>
                                <h6>Create Zoom ID</h6>

                                <form>
                                    <div class="mb-2">
                                        <label class="form-label">Meeting Title</label>
                                        <input type="text" class="form-control" placeholder="Team Discussion">
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <label class="form-label">Date</label>
                                            <input type="date" class="form-control">
                                        </div>

                                        <div class="col-6 mb-2">
                                            <label class="form-label">Time</label>
                                            <input type="time" class="form-control">
                                        </div>
                                    </div>

                                    <button class="btn btn-success btn-sm w-100">
                                        Generate Meeting ID
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Recordings -->
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                            <div class="card p-4 zoom-card h-100">
                                <div class="zoom-icon text-warning">🎬</div>
                                <h6>Recordings</h6>
                                <p class="text-muted">Access past meeting recordings.</p>

                                <ul class="list-group mb-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Team Meeting
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Download</a>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Client Call
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Download</a>
                                    </li>
                                </ul>

                                <a href="#" class="btn btn-warning btn-sm w-100">
                                    View All Recordings
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
