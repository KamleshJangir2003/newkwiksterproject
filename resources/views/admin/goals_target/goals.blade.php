@extends('admin.common.app')

@section('main')

<div class="container-fluid py-4">

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="bg-white rounded-lg shadow-lg overflow-hidden">

                <div class="bg-primary p-4 text-center text-white">
                    <div class="d-flex align-items-center justify-content-center gap-2 mb-1">
                        <span class="fs-3">🎯</span>
                        <h4 class="mb-0">Monthly Goal Target</h4>
                    </div>
                    <p class="small mb-0">Set target for selected month</p>
                </div>

                <div class="p-4">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('goal.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Target Month</label>
                            <input type="month" name="target_month" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Target Value</label>
                            <input type="number" name="target_value" class="form-control" placeholder="Enter target amount" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Notes (Optional)</label>
                            <textarea rows="4" name="notes" class="form-control" placeholder="Add any notes..."></textarea>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-5">
                                💾 Save Target
                            </button>
                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>

@endsection
