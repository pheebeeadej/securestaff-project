@extends('layouts.app')

@section('page-title', 'Leave Requests')
@section('page-subtitle', 'Submit and monitor time-off requests')

@section('content')
    <div class="panel" style="margin-bottom:20px;">
        <form method="POST" action="{{ route('leave.store') }}">
            @csrf
            <div class="form-group"><label>Start date</label><input class="form-control" type="date" name="start_date" required></div>
            <div class="form-group"><label>End date</label><input class="form-control" type="date" name="end_date" required></div>
            <div class="form-group"><label>Reason</label><textarea class="form-control" name="reason" rows="4" required></textarea></div>
            <button class="btn">Submit Request</button>
        </form>
    </div>

    <div class="panel">
        <table>
            <thead>
                <tr><th>From</th><th>To</th><th>Reason</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->start_date }}</td>
                        <td>{{ $request->end_date }}</td>
                        <td>{{ $request->reason }}</td>
                        <td>{{ ucfirst($request->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
