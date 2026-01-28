

@extends('Agent.common.app')
@section('main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
     /* ==============================
   🌈 GLOBAL DASHBOARD THEME
================================ */
:root {
  --primary: #2563eb;
  --success: #16a34a;
  --warning: #f59e0b;
  --danger: #dc2626;
  --dark: #1f2937;
  --muted: #6b7280;
  --card-bg: #ffffff;
  --border: #e5e7eb;
}

body {
  background: #f5f7fb;
  font-family: "Inter", sans-serif;
}

/* ==============================
   🕒 TIME ZONE CARDS
================================ */
.row-cols-1 .card {
  background: var(--card-bg);
  border-radius: 14px;
  border: none;
  box-shadow: 0 6px 18px rgba(0,0,0,.08);
  transition: .3s ease;
}

.row-cols-1 .card:hover {
  transform: translateY(-6px);
}

.card-body {
  text-align: center;
}

.card-body h4 {
  font-weight: 700;
}

/* ==============================
   📊 METRIC DASHBOARD CARDS
================================ */
.dashboard-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 22px;
  margin-top: 20px;
}

.dash-card {
  background: var(--card-bg);
  border-radius: 18px;
  padding: 22px;
  box-shadow: 0 10px 28px rgba(0,0,0,.08);
  position: relative;
  overflow: hidden;
  transition: .35s ease;
  text-align: center;
}

.dash-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 18px 40px rgba(0,0,0,.14);
}

/* LEFT COLOR STRIP */
.dash-card::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 6px;
  height: 100%;
}

.total::before { background: #2563eb; }
.pipeline::before { background: #16a34a; }
.live::before { background: #f59e0b; }
.loss::before { background: #dc2626; }

/* ICON */
.dash-card .icon {
  width: 56px;
  height: 56px;
  margin: 0 auto 12px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 26px;
}

.total .icon { background:#e0e7ff; color:#2563eb; }
.pipeline .icon { background:#dcfce7; color:#16a34a; }
.live .icon { background:#fef3c7; color:#f59e0b; }
.loss .icon { background:#fee2e2; color:#dc2626; }

.dash-card h6 {
  font-size: 14px;
  font-weight: 600;
  color: var(--muted);
  margin-bottom: 6px;
}

.dash-card h4,
.dash-card h3 {
  font-size: 28px;
  font-weight: 800;
  color: var(--dark);
}

/* ==============================
   🎧 LIVE TRANSFER SPLIT
================================ */
.dash-card .d-flex > div h4 {
  font-size: 24px;
  font-weight: 800;
}

/* ==============================
   🎯 GOAL SECTION
================================ */
.goal-graph-wrapper {
  display: flex;
  gap: 24px;
  margin-top: 30px;
  
}

.agent-goal-box {
  background: rgba(255,255,255,.9);
  backdrop-filter: blur(10px);
  border-radius: 22px;
  padding: 20px;
  width: 95%;
  box-shadow: 0 16px 40px rgba(0,0,0,.12);

  margin: 0 auto; /* 👈 center */
}


.goal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 18px;
}

.goal-header h5 {
  font-weight: 800;
  font-size: 18px;
}

.goal-pill {
  background: linear-gradient(135deg,#2563eb,#7c3aed);
  color: #fff;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 12px;
  font-weight: 600;
}

.goal-body {
  display: flex;
  gap: 26px;
  align-items: center;
}

/* ==============================
   🔵 CIRCLE PROGRESS
================================ */
.circle-progress {
  position: relative;
  width: 170px;
  height: 170px;
}

.bg-circle {
  fill: none;
  stroke: #e5e7eb;
  stroke-width: 14;
}

.progress-circle {
  fill: none;
  stroke-width: 14;
  stroke-dasharray: 452;
  transform: rotate(-90deg);
  transform-origin: 50% 50%;
  transition: 1.2s ease;
}

.circle-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  text-align: center;
}

.circle-text h3 {
  font-size: 32px;
  font-weight: 900;
}

/* ==============================
   📈 STATS
================================ */
.goal-stats {
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 14px;
}

.stat-card {
  background: #fff;
  border-radius: 16px;
  padding: 14px;
  text-align: center;
  box-shadow: 0 8px 18px rgba(0,0,0,.08);
}

.stat-card strong {
  font-size: 20px;
  font-weight: 800;
}

/* ==============================
   📱 RESPONSIVE
================================ */
@media(max-width:992px){
  .goal-graph-wrapper {
    flex-direction: column;
  }
  .agent-goal-box {
    width: 100%;
  }
}

@media(max-width:768px){
  .dashboard-cards {
    grid-template-columns: 1fr;
  }
  .goal-stats {
    grid-template-columns: 1fr;
  }
}

    </style>
    <style>
      .goal-ultra {
    background: linear-gradient(135deg, #ffffff, #f8fafc);
    border-radius: 20px;
    padding: 26px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
}

.goal-ultra::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 20px;
    padding: 1px;
    background: linear-gradient(135deg, #22c55e, #3b82f6, #a855f7);
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
}

.goal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.goal-header h5 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
}

.goal-header small {
    color: #64748b;
    font-size: 13px;
}

.goal-pill {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
}

.goal-body {
    display: flex;
    gap: 40px;
    align-items: center;
}

/* 🔥 MAIN FIX */
.circle-progress {
    position: relative;
    width: 170px;
    height: 170px;
    flex-shrink: 0;
}

/* SVG */
.bg-circle {
    fill: none;
    stroke: #e5e7eb;
    stroke-width: 14;
}

.progress-circle {
    fill: none;
    stroke-width: 14;
    stroke-linecap: round;
    stroke-dasharray: 452;
    transition: stroke-dashoffset 0.6s ease;
}

/* % TEXT FIX */
.circle-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    width: 100%;
}

.circle-text h3 {
    font-size: 36px;
    font-weight: 800;
    margin: 0;
    line-height: 1;
}

.circle-text p {
    margin-top: 6px;
    font-size: 14px;
    color: #64748b;
}

.goal-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    flex: 1;
}

.stat-card {
    background: #ffffff;
    border-radius: 16px;
    padding: 18px;
    text-align: center;
    box-shadow: 0 12px 25px rgba(0,0,0,0.06);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-6px);
}

.stat-card i {
    font-size: 22px;
    margin-bottom: 6px;
    color: #6366f1;
}

.stat-card span {
    font-size: 13px;
    color: #64748b;
}

.stat-card strong {
    display: block;
    font-size: 24px;
    font-weight: 800;
    margin-top: 4px;
}

.stat-card.success i { color: #22c55e; }
.stat-card.danger i { color: #ef4444; }

@media (max-width: 768px) {
    .goal-body {
        flex-direction: column;
        text-align: center;
    }

    .goal-stats {
        grid-template-columns: 1fr;
        width: 100%;
    }
}
.goal-insights-wrapper {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 14px;
    margin-top: 22px;
    padding-top: 18px;
    border-top: 1px dashed #e5e7eb;
}

.goal-insight-card {
    background: #f9fafb;
    border-radius: 14px;
    padding: 12px 10px;
    text-align: center;
    box-shadow: 0 6px 14px rgba(0,0,0,.06);
}

.goal-insight-card span {
    display: block;
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 4px;
}

.goal-insight-card strong {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
}

/* highlights */
.goal-insight-card.highlight {
    background: #ecfdf5;
    color: #065f46;
}

.goal-insight-card.warning {
    background: #fff7ed;
    color: #9a3412;
}



    </style>
   
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
           
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4" style="border-color: orangered !important;">
                        <div class="card-body">
                            @php
                                use Carbon\Carbon;
                                $current = Carbon::now('America/Los_Angeles'); // Pacific Time Zone
                                $curtime = $current->format('g:i A');
                                $curdate = $current->format('l, F j');
                            @endphp
                            <div style="text-align: center">
                                <p class="mb-0 text-secondary">Pacific Time</p>
                                <h4 class="my-1" style="color:orangered">{{ $curtime }}</h4>
                                <p class="mb-0 font-13">{{ $curdate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-success">
                        @php
                            $current1 = Carbon::now('America/Denver'); // Mountain Time Zone
                            $curtime1 = $current1->format('g:i A');
                            $curdate1 = $current1->format('l, F j');
                        @endphp
                        <div class="card-body">
                            <div style="text-align: center">
                                <p class="mb-0 text-secondary">Mountain Time</p>
                                <h4 class="my-1 text-success">{{ $curtime1 }}</h4>
                                <p class="mb-0 font-13">{{ $curdate1 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            @php
                                $current2 = Carbon::now('America/Chicago'); // Central Time Zone
                                $curtime2 = $current2->format('g:i A');
                                $curdate2 = $current2->format('l, F j');
                            @endphp
                            <div style="text-align: center">
                                <p class="mb-0 text-secondary">Central Time</p>
                                <h4 class="my-1 text-warning">{{ $curtime2 }}</h4>
                                <p class="mb-0 font-13">{{ $curdate2 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-4 border-danger">
                        <div class="card-body">
                            @php
                                $current3 = Carbon::now('America/New_York'); // Eastern Time Zone
                                $curtime3 = $current3->format('g:i A');
                                $curdate3 = $current3->format('l, F j');
                            @endphp

                            <div style="text-align: center">
                                <p class="mb-0 text-secondary">Eastern Time</p>
                                <h4 class="my-1 text-danger">{{ $curtime3 }}</h4>
                                <p class="mb-0 font-13">{{ $curdate3 }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->
  
<div class="dashboard-cards">

 <div class="dash-card total">
  <div class="icon"><i class="fa-solid fa-file-lines"></i></div>
  <h6>Total Interested Forms</h6>
  <h4>{{ $intrested_call }}</h4>
</div>

<div class="dash-card pipeline">
  <div class="icon"><i class="fa-solid fa-diagram-project"></i></div>
  <h6>Pipeline</h6>
  <h4>{{ $pipeline_call }}</h4>
</div>


<div class="dash-card live">
    <div class="icon">
        <i class="fa-solid fa-headset"></i>
    </div>

    <h6>Live Transfer</h6>

    <div class="d-flex justify-content-center mt-3">
    <div class="text-center me-5">
        <small class="text-success fw-bold">Success</small>
        <h4>{{ $liveTransferSuccess }}</h4>
    </div>

    <div class="text-center">
        <small class="text-danger fw-bold">Failed</small>
        <h4>{{ $liveTransferPending }}</h4>
    </div>
</div>

</div>


<div class="dash-card loss">
    <div class="icon">
        <i class="fa-solid fa-folder-open"></i>
    </div>

    <h6>Loss Runs </h6>

    <div class="d-flex justify-content-center gap-5 mt-2">
        <div class="text-center">
            <small class="fw-bold">Required</small>
            <h3 class="mb-0">{{ $lossRunsRequired }}</h3>
        </div>

        <div class="text-center">
            <small class="fw-bold">Not Required</small>
            <h3 class="mb-0">{{ $lossRunsNotRequired }}</h3>
        </div>
    </div>
</div>



</div>

</div>
<div class="goal-graph-wrapper">
  <div class="agent-goal-box goal-ultra">

    <div class="goal-header">
      <div class="title">
        <h5>🎯 Monthly Performance</h5>
        <small>
          {{ $agentGoal ? \Carbon\Carbon::parse($agentGoal->target_month)->format('F Y') : 'No Target Set' }}
        </small>
      </div>
      <div class="goal-pill">Goal Tracker</div>
    </div>

    <div class="goal-body">

      <div class="circle-progress glow">
        <svg width="170" height="170" viewBox="0 0 170 170">
          <defs>
            <linearGradient id="ultraGradient" x1="1" y1="0" x2="0" y2="1">
              <stop offset="0%" stop-color="#22c55e"/>
              <stop offset="50%" stop-color="#3b82f6"/>
              <stop offset="100%" stop-color="#a855f7"/>
            </linearGradient>
          </defs>

          <circle cx="85" cy="85" r="72" class="bg-circle"/>
          <circle cx="85" cy="85" r="72" class="progress-circle"
            style="stroke-dashoffset: {{ 452 - (452 * ($goalPercent ?? 0) / 100) }};
                   stroke:url(#ultraGradient);" />
        </svg>

        <div class="circle-text">
          <h3>{{ $goalPercent ?? 0 }}%</h3>
          <p>Completed</p>
        </div>
      </div>

      <div class="goal-stats">
        <div class="stat-card">
          <i class="lni lni-target"></i>
          <span>Target</span>
          <strong>{{ (int)$targetValue }}</strong>
        </div>

        <div class="stat-card success">
          <i class="lni lni-checkmark-circle"></i>
          <span>Achieved</span>
          <strong>{{ $achievedLeads }}</strong>
        </div>

        <div class="stat-card danger">
          <i class="lni lni-warning"></i>
          <span>Remaining</span>
          <strong>{{ (int)$remainingLeads }}</strong>
        </div>

      </div>
      

    </div>
   <div class="goal-insights-wrapper">

  <div class="goal-insight-card">
    <span>Total Days</span>
    <strong>31</strong>
  </div>

  <div class="goal-insight-card">
    <span>Today</span>
    <strong>28 Jan</strong>
  </div>

  <div class="goal-insight-card highlight">
    <span>Days Reached</span>
    <strong>28</strong>
  </div>

  <div class="goal-insight-card warning">
    <span>Required Pace</span>
    <strong>3 / day</strong>
  </div>

</div>


  </div>
</div>




<div style="text-align:center;">
    <img src="{{ asset('Agent/assets/images/StateCoverage-2.jpeg') }}" 
         alt="State Coverage Map" 
         style="width:80%;">
</div>





        </div>
    </div>





    
  



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($teamLabels);
const totalForms = @json($teamTotalForms);
const pipeline = @json($teamPipeline);
const lossRuns = @json($teamLossRuns);

const ctx = document.getElementById('dashboardChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [
      {
        label: 'Total Forms',
        data: totalForms,
        backgroundColor: '#4e73df',
        borderRadius: 6
      },
      {
        label: 'Pipeline',
        data: pipeline,
        backgroundColor: '#1cc88a',
        borderRadius: 6
      },
      {
        label: 'Loss Runs',
        data: lossRuns,
        backgroundColor: '#e74a3b',
        borderRadius: 6
      }
    ]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true,
        title: { display: true, text: "Count" }
      },
      x: {
        title: { display: true, text: "Team Members" }
      }
    }
  }
});
</script>



    <script>
        var dialLines = document.getElementsByClassName('diallines');
        var clockEl = document.getElementsByClassName('clock')[0];

        for (var i = 1; i < 60; i++) {
            clockEl.innerHTML += "<div class='diallines'></div>";
            dialLines[i].style.transform = "rotate(" + 6 * i + "deg)";
        }

        function clock() {
            var weekday = [
                    "Sunday",
                    "Monday",
                    "Tuesday",
                    "Wednesday",
                    "Thursday",
                    "Friday",
                    "Saturday"
                ],
                d = new Date();
            h = d.getHours(),
                m = d.getMinutes(),
                s = d.getSeconds(),
                date = d.getDate(),
                month = d.getMonth() + 1,
                year = d.getFullYear(),

                hDeg = h * 30 + m * (360 / 720),
                mDeg = m * 6 + s * (360 / 3600),
                sDeg = s * 6,

                hEl = document.querySelector('.hour-hand'),
                mEl = document.querySelector('.minute-hand'),
                sEl = document.querySelector('.second-hand'),
                dateEl = document.querySelector('.date'),
                dayEl = document.querySelector('.day');

            var day = weekday[d.getDay()];

            if (month < 9) {
                month = "0" + month;
            }

            hEl.style.transform = "rotate(" + hDeg + "deg)";
            mEl.style.transform = "rotate(" + mDeg + "deg)";
            sEl.style.transform = "rotate(" + sDeg + "deg)";
            dateEl.innerHTML = date + "/" + month + "/" + year;
            dayEl.innerHTML = day;
        }

        setInterval("clock()", 100);
    </script>
    <script>
        var dialLines = document.getElementsByClassName('diallines1');
        var clockEl = document.getElementsByClassName('clock1')[0];

        for (var i = 1; i < 60; i++) {
            clockEl.innerHTML += "<div class='diallines1'></div>";
            dialLines[i].style.transform = "rotate(" + 6 * i + "deg)";
        }

        function clock1() {
            var weekday = [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ];

            // Create a new Date object
            var d = new Date();

            // Convert to America/New_York timezone
            var nyTime = new Date(d.toLocaleString("en-US", {
                timeZone: "America/New_York"
            }));

            // Extract hours, minutes, seconds, date, month, and year
            var h = nyTime.getHours(),
                m = nyTime.getMinutes(),
                s = nyTime.getSeconds(),
                date = nyTime.getDate(),
                month = nyTime.getMonth() + 1,
                year = nyTime.getFullYear();

            var hDeg = h * 30 + m * (360 / 720),
                mDeg = m * 6 + s * (360 / 3600),
                sDeg = s * 6;

            var hEl = document.querySelector('.hour-hand1'),
                mEl = document.querySelector('.minute-hand1'),
                sEl = document.querySelector('.second-hand1'),
                dateEl = document.querySelector('.date1'),
                dayEl = document.querySelector('.day1');

            var day = weekday[nyTime.getDay()];

            if (month < 9) {
                month = "0" + month;
            }

            hEl.style.transform = "rotate(" + hDeg + "deg)";
            mEl.style.transform = "rotate(" + mDeg + "deg)";
            sEl.style.transform = "rotate(" + sDeg + "deg)";
            dateEl.innerHTML = date + "/" + month + "/" + year;
            dayEl.innerHTML = day;
        }

        setInterval(clock1, 1000); // Execute clock function every second
    </script>
    <script>
        var dialLines = document.getElementsByClassName('diallines2');
        var clockEl = document.getElementsByClassName('clock2')[0];

        for (var i = 1; i < 60; i++) {
            clockEl.innerHTML += "<div class='diallines2'></div>";
            dialLines[i].style.transform = "rotate(" + 6 * i + "deg)";
        }

        function clock2() {
            var weekday = [
                "Sunday",
                "Monday",
                "Tuesday",
                "Wednesday",
                "Thursday",
                "Friday",
                "Saturday"
            ]; Monthly Goal Target

            // Create a new Date object
            var d = new Date();

            // Convert to America/New_York timezone
            var nyTime = new Date(d.toLocaleString("en-US", {
                timeZone: "America/New_York"
            }));

            // Extract hours, minutes, seconds, date, month, and year
            var h = nyTime.getHours(),
                m = nyTime.getMinutes(),
                s = nyTime.getSeconds(),
                date = nyTime.getDate(),
                month = nyTime.getMonth() + 1,
                year = nyTime.getFullYear();

            var hDeg = h * 30 + m * (360 / 720),
                mDeg = m * 6 + s * (360 / 3600),
                sDeg = s * 6;

            var hEl = document.querySelector('.hour-hand2'),
                mEl = document.querySelector('.minute-hand2'),
                sEl = document.querySelector('.second-hand2'),
                dateEl = document.querySelector('.date2'),
                dayEl = document.querySelector('.day2');

            var day = weekday[nyTime.getDay()];

            if (month < 9) {
                month = "0" + month;
            }

            hEl.style.transform = "rotate(" + hDeg + "deg)";
            mEl.style.transform = "rotate(" + mDeg + "deg)";
            sEl.style.transform = "rotate(" + sDeg + "deg)";
            dateEl.innerHTML = date + "/" + month + "/" + year;
            dayEl.innerHTML = day;
        }

        setInterval(clock2, 1000); // Execute clock function every second
    </script>
    <script>
        // Define JavaScript variable with the data
        var formData = {
            totalForms: {{ $total_forms }},
            pipelineCall: {{ $pipeline_call }},
            intrestedCall: {{ $intrested_call }},
            won: {{ $total_call }},

            month_forms: {{ $month_forms }},
            month_pipeline: {{ $month_pipeline }},
            month_intrested: {{ $month_intrested }},
            month_won: {{ $totalmonth_call }}
        };
    </script>
    <script>
  let target = {{ $targetValue ?? 0 }};
  let achieved = {{ $achievedLeads ?? 0 }};
  let remaining = target - achieved;
  let percent = target > 0 ? Math.round((achieved / target) * 100) : 0;

  document.getElementById("goalPercent").innerText = percent + "%";
  document.getElementById("targetVal").innerText = target;
  document.getElementById("achievedVal").innerText = achieved;
  document.getElementById("remainingVal").innerText = remaining;

  let circumference = 440;

  let steps = [
    document.querySelector(".step-1"),
    document.querySelector(".step-2"),
    document.querySelector(".step-3"),
    document.querySelector(".step-4")
  ];

  // Reset all
  steps.forEach(s => s.style.strokeDashoffset = circumference);

  // Fill according to percentage
  if (percent > 0) {
    let offset = circumference - (circumference * percent) / 100;
    steps[Math.min(Math.floor(percent / 25), 3)].style.strokeDashoffset = offset;
  }
</script>

    
@endsection
