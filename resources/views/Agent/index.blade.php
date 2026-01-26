

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
  </div>
</div>



<style>
    .goal-graph-wrapper{
  padding: 20px 24px;
}

 .goal-ultra{
  background:rgba(255,255,255,0.85);
  backdrop-filter:blur(12px);
  border-radius:22px;
  padding:20px;
  box-shadow:
    0 20px 40px rgba(0,0,0,0.12),
    inset 0 1px 0 rgba(255,255,255,0.6);
}

.goal-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px;
}

.goal-header h5{
  margin:0;
  font-weight:800;
  font-size:18px;
}

.goal-header small{
  color:#6b7280;
  font-size:13px;
}

.goal-pill{
  background:linear-gradient(135deg,#6366f1,#a855f7);
  color:#fff;
  padding:6px 14px;
  border-radius:20px;
  font-size:12px;
  font-weight:600;
}

.goal-body{
  display:flex;
  gap:28px;
  align-items:center;
}

.circle-progress{
  position:relative;
  width:170px;
  height:170px;
}

.glow{
  filter:drop-shadow(0 0 18px rgba(99,102,241,0.45));
}

.bg-circle{
  fill:none;
  stroke:#e5e7eb;
  stroke-width:14;
}

.progress-circle{
  fill:none;
  stroke-width:14;
  stroke-dasharray:452;
  transform:rotate(-90deg);
  transform-origin:50% 50%;
  transition:1.2s cubic-bezier(.4,0,.2,1);
}

.circle-text{
  position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
  text-align:center;
}

.circle-text h3{
  font-size:30px;
  font-weight:900;
  margin:0;
}

.circle-text p{
  font-size:13px;
  color:#6b7280;
  margin:0;
}

.goal-stats{
  flex:1;
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:14px;
}

.stat-card{
  background:#fff;
  border-radius:16px;
  padding:14px;
  text-align:center;
  box-shadow:0 6px 18px rgba(0,0,0,.08);
  transition:.25s ease;
}

.stat-card:hover{
  transform:translateY(-4px);
}

.stat-card i{
  font-size:20px;
  margin-bottom:6px;
  display:block;
  color:#6366f1;
}

.stat-card span{
  font-size:12px;
  color:#6b7280;
}

.stat-card strong{
  display:block;
  font-size:20px;
  margin-top:4px;
}

.stat-card.success i{ color:#22c55e; }
.stat-card.danger i{ color:#ef4444; }

/* Mobile */
@media(max-width:768px){
  .goal-body{
    flex-direction:column;
  }
  .goal-stats{
    grid-template-columns:1fr;
    width:100%;
  }
}

/* FIX stats overflow issue */
.goal-stats{
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
}

/* each stat card responsive */
.stat-card{
  flex: 1 1 100px;
  min-width: 90px;
}

/* safety – card ke bahar kuch na nikle */
.goal-ultra{
  overflow: hidden;
}


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
