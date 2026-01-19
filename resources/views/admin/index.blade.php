@extends('admin.common.app')

@section('css')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('main')
<style>
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: stretch !important;
    }

    .d-flex.justify-content-between form {
        margin-top: 10px;
    }
}
</style>


<style>
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 15px;
}
@media (max-width: 1200px) {
    .dashboard-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .dashboard-grid { grid-template-columns: repeat(2, 1fr); }
}

.stat-card {
    border-radius: 12px;
    padding: 14px;
    color: white;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.bg-1 { background: linear-gradient(135deg, #4e73df, #224abe); }
.bg-2 { background: linear-gradient(135deg, #1cc88a, #169b6b); }
.bg-3 { background: linear-gradient(135deg, #f6c23e, #d4a219); }
.bg-4 { background: linear-gradient(135deg, #36b9cc, #2a8f9c); }
.bg-5 { background: linear-gradient(135deg, #e74a3b, #c73a2d); }
.bg-6 { background: linear-gradient(135deg, #6f42c1, #59339c); }
</style>
<style>
   .goal-btn-wrapper{
  text-align: center; /* center button */
  margin-bottom: 15px;
}

.goal-btn{
  background: #1e88e5;
  color: white;
  border: none;
  padding: 10px 10px;
  font-size: 15px;
  font-weight: 600;
  border-radius: 6px;
  cursor: pointer;
  transition: 0.3s ease;
}

.goal-btn:hover{
  background: #1565c0;

}
.stat-card{
  padding: 20px;
  border-radius: 12px;
  color: white;
  position: relative;
  overflow: hidden;
}

/* Gradient Colors */
.bg-1{
  background: linear-gradient(135deg, #3f51b5, #2196f3);

}

.bg-2{
background: linear-gradient(135deg, #6a11cb, #2575fc);

}

.bg-3{
 background: linear-gradient(135deg, #4b6cb7, #182848);

}

.bg-4{
  background: linear-gradient(135deg, #6a11cb, #2575fc);
}

.bg-5{
  background: linear-gradient(135deg, #a18cd1, #fbc2eb);
}

.bg-6{
background: linear-gradient(135deg, #4b6cb7, #182848);
}




</style>


<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<div class="page-body">

<div class="card mb-4 border-0 shadow-sm">
<div class="card-header bg-white">
<h5><i class="fas fa-chart-pie mr-2"></i>CRM Lead Dashboard</h5>
</div>

<div class="card-body">
<div class="dashboard-grid">

<div class="stat-card bg-1">
<h6>Total Clients</h6>
<h3>{{ $totalClients }}</h3>
</div>

<div class="stat-card bg-2">
<h6>Total Data in CRM</h6>
<h3>{{ $totalCrmData }}</h3>
</div>

<div class="stat-card bg-3">
<h6>Total Interested Leads</h6>
<h3>{{ $totalInterestedLeads }}</h3>
</div>

<div class="stat-card bg-4">
<h6>Total Live Leads</h6>
<h3>{{ $totalLiveLeads }}</h3>
</div>

<div class="stat-card bg-5">
<h6>Total Attempted Leads</h6>
<h3>{{ $totalAttemptedLeads }}</h3>
</div>

<div class="stat-card bg-6">
<h6>Total Rejected Leads</h6>
<h3>{{ $totalRejectedLeads }}</h3>
</div>

</div>

</div>
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5><i class="fas fa-users mr-2"></i>Employee Summary</h5>
    </div>

    <div class="card-body">
        <div class="row">

            <div class="col-md-4 mb-3">
                <div class="stat-card bg-1">
                    <h6>Total Employees</h6>
                    <h3>{{ $totalEmployees }}</h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card bg-2">
                    <h6>Total Active Employees</h6>
                    <h3>{{ $totalActiveEmployees }}</h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="stat-card bg-5">
                    <h6>Total Inactive Employees</h6>
                    <h3>{{ $totalInactiveEmployees }}</h3>
                </div>
            </div>

        </div>

        <div class="text-right mt-2">
            <small class="text-muted">Active Rate: {{ $activeRate }}%</small>
        </div>
    </div>
</div>

</div>
<section class="goals-section">
  <div class="container">

   <div class="goal-btn-wrapper">
  <button class="goal-btn">Our Goals & Achievement</button>
</div>



    <div class="goal-flow">

      <!-- TARGET -->
     <!-- TARGET -->
<div class="goal-card">
  <div class="icon-box">🎯</div>
  <h4>Target</h4>
  <div class="target-list">
    <p>
      Total Leads: 
      <strong>{{ $latestGoal->target_value ?? 0 }}</strong>
    </p>

    <p>
      Monthly Goal: 
      <strong>
        {{ $latestGoal ? \Carbon\Carbon::parse($latestGoal->target_month)->format('F Y') : 'N/A' }}
      </strong>
    </p>
  </div>
</div>


      <div class="connector">→</div>

      <!-- PROGRESS -->
      <div class="goal-card">
  <div class="icon-box">📊</div>
  <h4>Progress</h4>

  <p>
    <strong>
      {{ $completedLeads ?? 0 }} / {{ $latestGoal->target_value ?? 0 }}
    </strong> Completed
  </p>

  <div class="progress-wrap">
    <div class="progress-bar">
      <span style="width: {{ $progressPercent ?? 0 }}%"></span>
    </div>
    <small>{{ $progressPercent ?? 0 }}%</small>
  </div>
</div>


      <div class="connector">→</div>

      <!-- ACHIEVEMENT -->
      <div class="goal-card">
        <div class="icon-box">🏆</div>
        <h4>Achievement</h4>
        <p>
    <strong>
      {{ $milestonesDone }} / {{ $totalMilestones }}
    </strong> Milestones Done
  </p>
      </div>

      <div class="connector">→</div>

      <!-- LIVE TRANSFER -->
      <div class="goal-card">
        <div class="icon-box">🔄</div>
        <h4>Live Transfer</h4>
        <p>
    <strong>{{ $liveTransfers }}</strong> Leads Transferred
  </p>
      </div>

    </div>
  </div>
</section>

<style>
  body{
  font-family: 'Poppins', sans-serif;
  margin: 0;
}

.goals-section{
  /* padding: 70px 0; */
  background: linear-gradient(180deg, #eef5ff, #ffffff);
}

/* .container{
  width: 90%;
  max-width: 1200px;
  margin: auto;
} */

.section-title{
  text-align: center;
  font-size: 20px;
  color: #1f3c88;
  margin-bottom: 50px;
  font-weight: 600;
}

.goal-flow{
  display: flex;
  align-items: center;
  justify-content: space-between; /* cards equal space */
  gap: 15px;
  flex-wrap: nowrap; /* 👈 सबसे जरूरी change */
  overflow-x: auto; /* छोटे screen पर scroll आ जाएगा */
  padding-bottom: 10px;
}

/* Card */
.goal-card{
  background: white;
  padding: 20px;
  border-radius: 18px;
  width: 220px; /* थोड़ा कम किया */
  min-width: 220px; /* mobile scroll के लिए */
  text-align: center;
  box-shadow: 0 10px 22px rgba(0,0,0,0.08);
  transition: 0.3s ease;
}

.goal-card:hover{
  transform: translateY(-5px);
}

/* Icon */
.icon-box{
  width: 64px;
  height: 64px;
  margin: 0 auto 10px;
  background: #eef5ff;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 32px;
}

/* Text */
.goal-card h4{
  margin: 6px 0;
  color: #1f3c88;
}

.goal-card p{
  font-size: 14px;
  color: #555;
  margin: 4px 0;
}

/* Connector Arrow */
.connector{
  font-size: 26px;
  color: #1f3c88;
  font-weight: bold;
}

/* Progress Bar */
.progress-wrap{
  margin-top: 10px;
}

.progress-bar{
  width: 100%;
  height: 9px;
  background: #ddd;
  border-radius: 10px;
  overflow: hidden;
}

.progress-bar span{
  display: block;
  height: 100%;
  background: linear-gradient(90deg, #1f3c88, #4f7cff);
  border-radius: 10px;
}

/* Mobile */
@media (max-width: 900px){
  .goal-flow{
    flex-direction: column;
  }

  .connector{
    transform: rotate(90deg);
  }
}
.goal-flow::-webkit-scrollbar{
  height: 6px;
}

.goal-flow::-webkit-scrollbar-thumb{
  background: #1f3c88;
  border-radius: 10px;
}

</style>

<div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <!-- Tabs -->
    <ul class="nav nav-tabs m-0">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#daily">Daily Leads</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#monthly">Monthly Leads</a>
        </li>
    </ul>

    <!-- Date Search (Right Side) -->
    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center">
        <input type="date"
               name="start_date"
               value="{{ request('start_date', now()->format('Y-m-d')) }}"
               class="form-control mr-2"
               style="width: 160px;"
               required>

        <input type="date"
               name="end_date"
               value="{{ request('end_date') }}"
               class="form-control mr-2"
               style="width: 160px;">

        <!-- <button type="submit" class="btn btn-primary">
            <i class="fa fa-search"></i> Search
        </button> -->
    </form>
</div>




<div class="tab-content mt-3">

<div class="tab-pane fade show active" id="daily">
<table class="table table-bordered">
<thead>
<tr>
<th>S.N</th>
<th>Name</th>
<th>Total Assigned</th>
<th>Attempted</th>
<th>Disposition</th>
<th>Pipeline</th>
<th>Interested</th>
</tr>
</thead>
<tbody>
@foreach($rows as $i => $row)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $row['name'] }}</td>
<td>{{ $row['total_leads'] }}</td>
<td>{{ $row['calls'] }}</td>
<td>{{ $row['disposition'] }}</td>
<td>{{ $row['pipeline'] }}</td>
<td>{{ $row['interested'] }}</td>
</tr>
@endforeach

</tbody>
</table>
</div>

<div class="tab-pane fade" id="monthly">
<table class="table table-bordered">
<thead>
<tr>
<th>S.N</th>
<th>Name</th>
<th>Interested</th>
<th>Live</th>
<th>Rejected</th>
</tr>
</thead>
<tbody>
@foreach($monthlyData as $i => $row)
<tr>
<td>{{ $i+1 }}</td>
<td>{{ $row['user']->name }}</td>
<td>{{ $row['interested'] }}</td>
<td>{{ $row['live'] }}</td>
<td>{{ $row['rejected'] }}</td>
</tr>
@endforeach

</tbody>
</table>
</div>

</div>
</div>
</div>
</div>
</div>

@endsection
