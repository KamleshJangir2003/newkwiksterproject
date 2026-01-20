@extends('Agent.common.app')
@section('main')
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <!-- <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-5">
                <div class="breadcrumb-title pe-3">Incoming Leads</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manager Forwarded Leads</li>
                        </ol>
                    </nav>
                </div>
            </div> -->
            <!--end breadcrumb-->

            <div class="container">
                @if (!empty($leads) && count($leads) > 0)
                    <div class="row g-4">
                        @foreach ($leads as $lead)
                            @php
                                $data_id = json_decode($lead->data_id);
                                $ids = explode(',', $data_id[0] ?? '');
                                $total = count($ids);

                                $lead_ids_array = $ids;

                                // Define state → timezone map
                                $stateTimezones = [
                                    'CA' => 'Pacific Time',
                                    'OR' => 'Pacific Time',
                                    'WA' => 'Pacific Time',
                                    'NV' => 'Pacific Time',
                                    'MT' => 'Mountain Time',
                                    'CO' => 'Mountain Time',
                                    'NM' => 'Mountain Time',
                                    'UT' => 'Mountain Time',
                                    'WY' => 'Mountain Time',
                                    'AZ' => 'Mountain Time',
                                    'ID' => 'Mountain Time',
                                    'TX' => 'Central Time',
                                    'AL' => 'Central Time',
                                    'AR' => 'Central Time',
                                    'IL' => 'Central Time',
                                    'IA' => 'Central Time',
                                    'KS' => 'Central Time',
                                    'LA' => 'Central Time',
                                    'MN' => 'Central Time',
                                    'MS' => 'Central Time',
                                    'MO' => 'Central Time',
                                    'NE' => 'Central Time',
                                    'ND' => 'Central Time',
                                    'OK' => 'Central Time',
                                    'SD' => 'Central Time',
                                    'TN' => 'Central Time',
                                    'WI' => 'Central Time',
                                    'CT' => 'Eastern Time',
                                    'DE' => 'Eastern Time',
                                    'FL' => 'Eastern Time',
                                    'GA' => 'Eastern Time',
                                    'IN' => 'Eastern Time',
                                    'KY' => 'Eastern Time',
                                    'ME' => 'Eastern Time',
                                    'MD' => 'Eastern Time',
                                    'MA' => 'Eastern Time',
                                    'MI' => 'Eastern Time',
                                    'NH' => 'Eastern Time',
                                    'NJ' => 'Eastern Time',
                                    'NY' => 'Eastern Time',
                                    'NC' => 'Eastern Time',
                                    'OH' => 'Eastern Time',
                                    'PA' => 'Eastern Time',
                                    'RI' => 'Eastern Time',
                                    'SC' => 'Eastern Time',
                                    'VT' => 'Eastern Time',
                                    'VA' => 'Eastern Time',
                                    'WV' => 'Eastern Time',
                                    'DC' => 'Eastern Time',
                                ];

                                // Fetch all lead ExcelData
                                $datasexcel = App\Models\ExcelData::whereIn('id', $lead_ids_array)->get();

                                // Count timezones
                                $timezoneCounts = [
                                    'Pacific Time' => 0,
                                    'Mountain Time' => 0,
                                    'Central Time' => 0,
                                    'Eastern Time' => 0,
                                ];

                                // For sending timezone-specific data
                                $timezoneDataIds = [
                                    'Pacific Time' => [],
                                    'Mountain Time' => [],
                                    'Central Time' => [],
                                    'Eastern Time' => [],
                                ];

                                foreach ($datasexcel as $data) {
                                    $state = $data->business_state;
                                    $timezone = 'Pacific Time'; // Default if state is empty or unknown

                                    if (!empty($state) && isset($stateTimezones[$state])) {
                                        $timezone = $stateTimezones[$state];
                                    }

                                    $timezoneCounts[$timezone]++;
                                    $timezoneDataIds[$timezone][] = $data->id;
                                }

                                // Encode each timezone's data IDs
                                $encodedTimezones = [];
                                foreach ($timezoneDataIds as $tz => $ids) {
                                    $encodedTimezones[$tz] = base64_encode(json_encode($ids));
                                }
                            @endphp

                            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="card lead-card border-0">
                                    <div class="card-header bg-gradient-1 text-white border-bottom-0 position-relative">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-white text-dark">NEW LEADS</span>
                                            <span class="lead-count display-5 fw-bold">{{ $total }}</span>
                                        </div>
                                        <div class="position-absolute top-0 end-0 mt-3 me-3">
                                            {{-- <i class='bx bxs-bar-chart-alt-2 fs-2 opacity-25'></i> --}}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h6 class="mb-0 text-uppercase text-muted small">Received</h6>
                                                <h5 class="mb-0">{{ $lead->created_at->diffForHumans() }}</h5>
                                            </div>
                                            <div class="bg-light-primary p-2 rounded">
                                                <i class='bx bxs-bar-chart-alt-2 text-primary fs-4'></i>
                                            </div>
                                        </div>
                                        <div class="progress mb-2" style="height: 8px;">
                                            <div class="progress-bar bg-gradient-1" role="progressbar" style="width: 100%"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p class="text-muted small mb-0">
                                            <i class="bx bx-time-five me-1"></i>
                                            {{ $lead->created_at->format('M d, Y h:i A') }}
                                        </p>
                                    </div>

                                    <div class="card-footer bg-transparent border-top-0 pt-0">
                                        <button type="button" class="btn btn-dark w-100 view-leads-btn"
                                            data-bs-toggle="collapse" data-bs-target="#timezoneOptions{{ $lead->id }}"
                                            aria-expanded="false" aria-controls="timezoneOptions{{ $lead->id }}"
                                            onclick="toggleTimeButtons('{{ base64_encode($lead->id) }}')">
                                            <i class="bx bx-show me-1"></i> View Leads
                                        </button>

                                        <div class="collapse mt-3" id="timezoneOptions{{ $lead->id }}">
                                            <div class="d-grid gap-2" id="timezoneOptions{{ $lead->id }}">
                                                <button id="btn-eastern-{{ base64_encode($lead->id) }}"
                                                    class="btn btn-timezone eastern-timezone"
                                                    onclick="redirectToTimezoneRoute('{{ base64_encode($lead->id) }}', 'Eastern Time')">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">EASTERN</span>
                                                        <span class="time"></span>
                                                        <span
                                                            class="badge bg-white text-dark fs-6">{{ $timezoneCounts['Eastern Time'] }}</span>
                                                    </div>
                                                </button>

                                                <button id="btn-central-{{ base64_encode($lead->id) }}"
                                                    class="btn btn-timezone central-timezone"
                                                    onclick="redirectToTimezoneRoute('{{ base64_encode($lead->id) }}', 'Central Time')">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">CENTRAL</span>
                                                        <span class="time"></span>
                                                        <span
                                                            class="badge bg-white text-dark fs-6">{{ $timezoneCounts['Central Time'] }}</span>
                                                    </div>
                                                </button>

                                                <button id="btn-mountain-{{ base64_encode($lead->id) }}"
                                                    class="btn btn-timezone mountain-timezone"
                                                    onclick="redirectToTimezoneRoute('{{ base64_encode($lead->id) }}', 'Mountain Time')">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">MOUNTAIN</span>
                                                        <span class="time"></span>
                                                        <span
                                                            class="badge bg-white text-dark fs-6">{{ $timezoneCounts['Mountain Time'] }}</span>
                                                    </div>
                                                </button>

                                                <button id="btn-pacific-{{ base64_encode($lead->id) }}"
                                                    class="btn btn-timezone pacific-timezone"
                                                    onclick="redirectToTimezoneRoute('{{ base64_encode($lead->id) }}', 'Pacific Time')">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="fw-bold">PACIFIC</span>
                                                        <span class="time"></span>
                                                        <span
                                                            class="badge bg-white text-dark fs-6">{{ $timezoneCounts['Pacific Time'] }}</span>
                                                    </div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon bg-gradient-1">
                            <i class='bx bx-cloud-upload '></i>
                        </div>
                        <h3 class="mt-4">No Leads Available</h3>
                        <p class="lead text-muted">When your manager forwards you leads, they will appear here.</p>
                        <button class="btn btn-dark px-4 py-2 rounded-pill" onclick="location.reload()">
                            <i class='bx bx-refresh me-1'></i> Refresh
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Color Variables */
        :root {
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #5ee7df 0%, #b490ca 100%);
            --gradient-4: linear-gradient(135deg, #c471f5 0%, #fa71cd 100%);
        }

        /* Card styling */
        .lead-card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            /* height: 100%; */
            display: flex;
            flex-direction: column;
        }

        .lead-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .card-header.bg-gradient-1 {
            background: var(--gradient-1);
            /* padding: 1.5rem; */
            position: relative;
        }

        .lead-count {
            font-size: 2.5rem;
            line-height: 1;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Timezone buttons */
        .btn-timezone {
            color: white;
            text-align: left;
            transition: all 0.2s ease;
            border: none;
            /* padding: 1rem; */
            border-radius: 8px;
            margin-bottom: 0.5rem;
            position: relative;
            overflow: hidden;
            border-left: 4px solid rgba(255, 255, 255, 0.5);
        }

        .btn-timezone:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .eastern-timezone {
            background: var(--gradient-1);
        }

        .central-timezone {
            background: var(--gradient-2);
        }

        .mountain-timezone {
            background: var(--gradient-3);
        }

        .pacific-timezone {
            background: var(--gradient-4);
        }

        /* View leads button */
        .view-leads-btn {
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 0.75rem;
            border-radius: 8px;
        }

        .view-leads-btn[aria-expanded="true"] {
            background: #2c3e50;
            color: white;
        }

        .view-leads-btn i {
            transition: transform 0.3s ease;
        }

        .view-leads-btn[aria-expanded="true"] i {
            transform: rotate(180deg);
        }

        /* Progress bar */
        .progress {
            border-radius: 100px;
            background: rgba(0, 0, 0, 0.05);
        }

        .progress-bar {
            border-radius: 100px;
        }

        /* Empty state styling */
        .empty-state {
            text-align: center;
            padding: 3rem;
            background: #f8f9fa;
            border-radius: 12px;
            margin: 2rem 0;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 2.5rem;
        }

        .empty-state h3 {
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .empty-state .lead {
            color: #7f8c8d;
            margin-bottom: 1.5rem;
        }

        /* Badge styling */
        .badge {
            font-weight: 600;
            padding: 0.35em 0.75em;
            letter-spacing: 0.5px;
            border-radius: 100px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .lead-count {
                font-size: 2rem;
            }

            .card-header.bg-gradient-1 {
                padding: 1.25rem;
            }
        }
    </style>

    <script>
        // Initialize time displays when collapse is shown
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.view-leads-btn').forEach(button => {
                button.addEventListener('click', function() {
                    // Update button icon/text
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.innerHTML = isExpanded ?
                        '<i class="bx bx-show me-1"></i> View Leads' :
                        '<i class="bx bx-hide me-1"></i> Hide Options';
                });
            });
        });

        function redirectToTimezoneRoute(leadId, timezone) {
            var url = '{{ route('viewDataTimezone', ['timezone' => '__timezone__', 'id' => '__id__']) }}';
            url = url.replace("__timezone__", timezone).replace("__id__", leadId);
            window.location.href = url;
        }

        function toggleTimeButtons(dataId) {
            // Define the timezones
            const timeZones = {
                eastern: 'America/New_York',
                central: 'America/Chicago',
                mountain: 'America/Denver',
                pacific: 'America/Los_Angeles',
            };

            // Loop through each timezone and update the time
            for (const [zone, location] of Object.entries(timeZones)) {
                const button = document.getElementById(`btn-${zone}-${dataId}`);
                if (button) {
                    const now = new Date().toLocaleTimeString("en-US", {
                        timeZone: location,
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });
                    button.querySelector('.time').textContent = now;
                }
            }
        }
    </script>
@endsection
