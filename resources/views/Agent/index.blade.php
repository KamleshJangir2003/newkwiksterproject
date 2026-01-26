

@extends('Agent.common.app')
@section('main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
     /* ============================================
   🎨 COMPLETE MODERN DASHBOARD CSS
   ============================================ */

/* --- Time Zone Cards --- */
.row-cols-1 .card {
    background: #ffffff;
    border: none !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.row-cols-1 .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.row-cols-1 .card .card-body {
    padding: 20px;
}

/* Border colors with gradient effect */
.card.radius-10::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    z-index: 1;
}

/* --- Dashboard Metric Cards --- */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    /* margin: 25px 0; */
}

.dash-card {
    background: #ffffff;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    text-align: left;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.dash-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

/* Left border accent */
.dash-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    transition: width 0.3s ease;
}

.dash-card:hover::before {
    width: 6px;
}

/* Border colors matching time zones */
.dash-card.total::before { 
    background: linear-gradient(180deg, #ff4500, #ff6347);
}
.dash-card.pipeline::before { 
    background: linear-gradient(180deg, #28a745, #20c997);
}
.dash-card.live::before { 
    background: linear-gradient(180deg, #ffc107, #fd7e14);
}
.dash-card.loss::before { 
    background: linear-gradient(180deg, #dc3545, #e74c3c);
}

/* Subtle gradient backgrounds */
.dash-card.total {
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
}
.dash-card.pipeline {
    background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
}
.dash-card.live {
    background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
}
.dash-card.loss {
    background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
}

/* Icon styling */
.dash-card .icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 12px;
    transition: transform 0.3s ease;
}

.dash-card:hover .icon {
    transform: scale(1.1) rotate(5deg);
}

.dash-card.total .icon {
    background: linear-gradient(135deg, #fff5f5, #ffe5e5);
    color: #ff4500;
}
.dash-card.pipeline .icon {
    background: linear-gradient(135deg, #f0fff4, #d4f4dd);
    color: #28a745;
}
.dash-card.live .icon {
    background: linear-gradient(135deg, #fffbf0, #ffeaa7);
    color: #ffc107;
}
.dash-card.loss .icon {
    background: linear-gradient(135deg, #fff5f5, #ffe5e5);
    color: #dc3545;
}

.dash-card h6 {
    margin: 8px 0;
    font-weight: 600;
    color: #555;
    font-size: 14px;
}

.dash-card h4 {
    margin: 0;
    font-weight: 700;
    font-size: 28px;
    color: #2c3e50;
}

/* --- Goal & Graph Wrapper --- */
.goal-graph-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 25px;
    margin-top: 25px;
}

/* --- Monthly Goal Box --- */
.agent-goal-box {
    background: #ffffff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    width: 35%;
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.agent-goal-box:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.agent-goal-box::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px 0 0 16px;
}

.goal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f0f0;
}

.goal-header h5 {
    margin: 0;
    font-weight: 700;
    color: #2c3e50;
    font-size: 16px;
}

.month {
    font-size: 13px;
    color: #7f8c8d;
    font-weight: 600;
    background: #f8f9fa;
    padding: 4px 12px;
    border-radius: 20px;
}

/* Circle Progress */
.goal-body {
    display: flex;
    align-items: center;
    gap: 25px;
}

.circle-progress {
    position: relative;
    width: 160px;
    height: 160px;
}

.bg-circle {
    fill: none;
    stroke: #f0f0f0;
    stroke-width: 12;
}

.progress-circle {
    fill: none;
    stroke-width: 12;
    stroke-dasharray: 440;
    stroke-dashoffset: 440;
    transform: rotate(-90deg);
    transform-origin: 50% 50%;
    transition: stroke-dashoffset 1.5s cubic-bezier(0.4, 0, 0.2, 1);
    stroke-linecap: round;
}

/* Multi-color progress */
.step-1 { stroke: #dc3545; }
.step-2 { stroke: #fd7e14; }
.step-3 { stroke: #ffc107; }
.step-4 { stroke: #28a745; }

.circle-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.circle-text h3 {
    margin: 0;
    font-size: 32px;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.circle-text p {
    margin: 4px 0 0;
    font-size: 13px;
    color: #7f8c8d;
    font-weight: 600;
}

/* Goal Stats */
.goal-stats {
    flex: 1;
}

.goal-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    border-bottom: 1px solid #f0f0f0;
}

.goal-row:last-child {
    border-bottom: none;
}

.goal-row span {
    font-size: 14px;
    color: #7f8c8d;
    font-weight: 500;
}

.goal-row strong {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
}

.goal-row .achieved {
    color: #28a745;
}

.goal-row .remaining {
    color: #dc3545;
}

/* --- Graph Box --- */
.graph-box {
    background: #ffffff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    width: 65%;
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.graph-box:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.graph-box h5 {
    margin: 0 0 20px;
    font-weight: 700;
    color: #2c3e50;
    font-size: 16px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f0f0f0;
}

.graph-box canvas {
    width: 100% !important;
    height: auto !important;
}

/* --- Responsive Design --- */
@media (max-width: 1200px) {
    .dashboard-cards {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .goal-graph-wrapper {
        flex-direction: column;
    }
    
    .agent-goal-box,
    .graph-box {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
}

/* --- Smooth Animations --- */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dash-card,
.agent-goal-box,
.graph-box {
    animation: fadeInUp 0.6s ease-out;
}

.dash-card:nth-child(1) { animation-delay: 0.1s; }
.dash-card:nth-child(2) { animation-delay: 0.2s; }
.dash-card:nth-child(3) { animation-delay: 0.3s; }
.dash-card:nth-child(4) { animation-delay: 0.4s; }




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
  <h4>{{ $total_all_forms }}</h4>
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

    <h6>Loss Runs Required</h6>

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
<div style="text-align:center;">
    <img src="{{ asset('Agent/assets/images/StateCoverage-1.png') }}" 
         alt="State Coverage Map" 
         style="width:80%;">
</div>





        </div>
    </div>





    
  <div class="goal-graph-wrapper">

 <div class="agent-goal-box goal-circle-style">
  <div class="goal-header">
    <h5>🎯 Monthly Goal Target</h5>
    <span class="month">
      {{ $agentGoal ? \Carbon\Carbon::parse($agentGoal->target_month)->format('F Y') : 'No Target Set' }}
    </span>
  </div>

  <div class="goal-body">
    <div class="circle-progress">
      <svg width="160" height="160" viewBox="0 0 160 160">
        <circle cx="80" cy="80" r="70" class="bg-circle"/>

        <circle cx="80" cy="80" r="70" class="progress-circle step-1"/>
        <circle cx="80" cy="80" r="70" class="progress-circle step-2"/>
        <circle cx="80" cy="80" r="70" class="progress-circle step-3"/>
        <circle cx="80" cy="80" r="70" class="progress-circle step-4"/>
      </svg>

      <div class="circle-text">
        <h3 id="goalPercent">{{ $goalPercent ?? 0 }}%</h3>
        <p>Completed</p>
      </div>
    </div>

    <div class="goal-stats">
  <div class="goal-row">
    <span>Target</span>
    <strong id="targetVal">{{ (int) $targetValue }}</strong>
  </div>

  <div class="goal-row">
    <span>Achieved</span>
    <strong class="achieved" id="achievedVal">{{ $achievedLeads }}</strong>
  </div>

  <div class="goal-row">
    <span>Remaining</span>
    <strong class="remaining" id="remainingVal">{{ (int) $remainingLeads }}</strong>
  </div>
</div>

  </div>
</div>

</div>
<style>
    
</style>
<style>
   .agent-goal-box.goal-circle-style {
  background: #ffffff;
  border-radius: 16px;
  padding: 16px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.08);
}

.goal-circle-style .goal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
}

.goal-body {
  display: flex;
  align-items: center;
  gap: 20px;
}

/* ---- CIRCLE BASE ---- */
.circle-progress {
  position: relative;
  width: 160px;
  height: 160px;
}

.bg-circle {
  fill: none;
  stroke: #e6e6e6;
  stroke-width: 10;
}

/* Common for all progress circles */
.progress-circle {
  fill: none;
  stroke-width: 10;
  stroke-dasharray: 440;
  stroke-dashoffset: 440;
  transform: rotate(-90deg);
  transform-origin: 50% 50%;
  transition: 1s ease-in-out;
}

/* ---- 4 COLOR STEPS ---- */
.step-1 { stroke: #ef4444; } /* Red */
.step-2 { stroke: #f97316; } /* Orange */
.step-3 { stroke: #3b82f6; } /* Blue */
.step-4 { stroke: #16a34a; } /* Green */

/* Center text */
.circle-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
}

.circle-text h3 {
  margin: 0;
  font-size: 26px;
  font-weight: 700;
}

/* ---- STATS ---- */
.goal-stats {
  flex: 1;
}

.goal-row {
  display: flex;
  justify-content: space-between;
  padding: 6px 0;
  border-bottom: 1px solid #eee;
}

.achieved { color: #16a34a; }
.remaining { color: #dc2626; }

</style>
<style>
    .dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.dash-card {
    display: flex;
    flex-direction: column;
    align-items: center;     /* horizontal center */
    justify-content: center; /* vertical center */
    text-align: center;
    padding: 20px;
    border-radius: 12px;
}

.dash-card .icon {
    font-size: 28px;
    margin-bottom: 10px;
}

</style>
<style>
    .goal-graph-wrapper{
  display: flex;
  align-items: flex-start;
  gap: 20px;
  margin-top: 20px;
}

/* Monthly Goal Box */
.agent-goal-box{
  background:#ffffff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.08);
  width: 35%;        /* control size */
  position: relative;
  height: 320px;
}

/* Graph Box */
.graph-box{
  background:#ffffff;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.08);
  width: 65%;        /* control size */
}

/* Make graph fit box */
.graph-box canvas{
  width: 100% !important;
  height: auto !important;
}

</style>

    <style>
   .graph-box{

  margin-left: 25px;
  background:#ffffff;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.08);

  width: 75%;        /* 👉 Aap change kar sakte ho */
  max-width: 900px;  /* graph box limit */
  min-width: 400px;  /* minimum size */

  height: auto;      /* graph ke according adjust */
  
}




        .dashboard-cards{
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.dash-card{
  background: #ffffff;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.08);
  text-align: left;
  /* min-height: 150px; */
  position: relative;
}

.dash-card h6{
  margin: 10px 0 5px;
  font-weight: 600;
  color: #555;
}

.dash-card h2{
  margin: 0;
  font-weight: 700;
}

.icon{
  width: 35px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  
  font-size: 22px;
}

/* Different colors for each card */
.total .icon{ background:#e6f2ff; }
.pipeline .icon{ background:#e6fff2; }
.live .icon{ background:#fff2e6; }
.loss .icon{ background:#ffe6e6; }



    </style>
    <style>
        .dash-card{
  position: relative;
  overflow: hidden;
}

/* 2px color line on left */
.dash-card::before{
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  width: 4px;
  height: 100%;
}

/* Colors for each card */
.total::before{ background:#ff4500; }
.pipeline::before{ background:#2ecc71; }
.live::before{ background:#f39c12; }
.loss::before{ background:#e74c3c; }

    </style>
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
