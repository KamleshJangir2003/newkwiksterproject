

@extends('Agent.common.app')
@section('main')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .agent-goal-box{
  background:#ffffff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.08);
  max-width: 420px;
  height: ;
  position: relative;
  margin-left: 25px;
}

/* Left 2px strip (same as your cards) */
.agent-goal-box::before{
  content:"";
  position:absolute;
  left:0;
  top:0;
  width:2px;
  height:100%;
  background:#1f6bff;
}

.goal-header{
  display:flex;
  justify-content: space-between;
  align-items:center;
  margin-bottom: 12px;
}

.month{
  font-size: 13px;
  color:#777;
}

.goal-row{
  display:flex;
  justify-content: space-between;
  margin: 6px 0;
}

.achieved{ color:#2ecc71; }
.remaining{ color:#e74c3c; }

/* Progress bar */
.progress-wrapper{
  margin-top: 12px;
}

.progress-bar{
  width:100%;
  height:8px;
  background:#eee;
  border-radius: 10px;
  overflow:hidden;
}

.progress-fill{
  height:100%;
  background:#1f6bff;
  border-radius:10px;
}

.progress-text{
  text-align:right;
  font-size: 12px;
  margin-top:4px;
}

    </style>
    <style>
 .dash-card{
  padding: 20px;
  border-radius: 16px;
  color: #333;
  text-align: center;
  position: relative;
  overflow: hidden;
}

/* Top-left soft shine */
.dash-card::before{
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(255,255,255,0.9), rgba(255,255,255,0));
  opacity: 0.6;
  z-index: 1;
}

/* Bottom-right soft shadow (inner depth) */
.dash-card::after{
  content: "";
  position: absolute;
  inset: 0;
  background: radial-gradient(circle at bottom right, rgba(0,0,0,0.12), rgba(0,0,0,0));
  opacity: 0.5;
  z-index: 1;
}

/* Content ko upar lane ke liye */
.dash-card *{
  position: relative;
  z-index: 2;
}

/* Your base gradients (same as before) */
.dash-card.total{
  background: linear-gradient(135deg, #e2e7fa, #bac9d4);
}

.dash-card.pipeline{
  background: linear-gradient(135deg, #cce4ef, #f6e9e5);
}

.dash-card.live{
  background: linear-gradient(135deg, #9dd5db, #ddeef0);
}

.dash-card.loss{
  background: linear-gradient(135deg, #b9e6f6, #bcb9a5);
}

/* Icon center */
.dash-card .icon{
  display: flex;
  justify-content: center;
  margin-bottom: 8px;
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
  <h4>{{ $total_all_forms }}</h4>
</div>

<div class="dash-card pipeline">
  <div class="icon"><i class="fa-solid fa-diagram-project"></i></div>
  <h6>Pipeline</h6>
  <h4>{{ $pipeline_call }}</h4>
</div>


<div class="dash-card live">
  <div class="icon"><i class="fa-solid fa-headset"></i></div>
  <h6>Live Transfer Pending</h6>
  <h4>188</h4>
</div>

<div class="dash-card loss">
  <div class="icon"><i class="fa-solid fa-folder-open"></i></div>
  <h6>Loss Runs Pending</h6>
  <h4>09</h4>
</div>


</div>

</div>





        </div>
    </div>
  <div class="goal-graph-wrapper">

 <div class="agent-goal-box goal-circle-style">
  <div class="goal-header">
    <h5>🎯 Monthly Goal Target</h5>
    <span class="month">
      {{ $latestGoal ? \Carbon\Carbon::parse($latestGoal->target_month)->format('F Y') : 'N/A' }}
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




  <!-- Graph Box -->
  <div class="graph-box">
    <h5>📊 Performance Overview</h5>
    <canvas id="dashboardChart"></canvas>
  </div>

</div>
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

  width: 40%;        /* 👉 Aap change kar sakte ho */
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
    <!-- <script>
  let target = 500;
  let achieved = 320;
  let remaining = target - achieved;
  let percent = Math.round((achieved / target) * 100);

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
</script> -->

    
@endsection
