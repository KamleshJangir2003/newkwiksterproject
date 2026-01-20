@extends('Agent.common.app')

@section('main')
<h2>Live Transfer</h2>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@foreach($transfers as $transfer)
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">{{ $transfer->lead->company_name ?? 'N/A' }}</h5>
        <p class="card-text">Phone: {{ $transfer->lead->phone ?? 'N/A' }}</p>
        <form action="{{ route('agent.live_transfer.respond') }}" method="POST">
            @csrf
            <input type="hidden" name="transfer_id" value="{{ $transfer->id }}">
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea name="remarks" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
            <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
        </form>
    </div>
</div>
@endforeach
@endsection