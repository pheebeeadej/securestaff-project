@extends('layouts.app')

@section('page-title', 'Security Dashboard')
@section('page-subtitle', 'Audit trail and password-policy analytics')

@section('content')
    <div class="card-grid">
        <div class="card"><div class="muted">Locked Users</div><h2>{{ $lockedUsers }}</h2></div>
        <div class="card"><div class="muted">Policy Violations</div><h2>{{ $policyViolations }}</h2></div>
        <div class="card"><div class="muted">Recent Events</div><h2>{{ $recentEvents->count() }}</h2></div>
        <div class="card"><div class="muted">Policy Status</div><h2>Enabled</h2></div>
    </div>

    <div class="panel">
        <table>
            <thead>
                <tr><th>Event Type</th><th>Severity</th><th>Description</th><th>Timestamp</th></tr>
            </thead>
            <tbody>
                @foreach($recentEvents as $event)
                    <tr>
                        <td>{{ $event->event_type }}</td>
                        <td>{{ ucfirst($event->severity) }}</td>
                        <td>{{ $event->description }}</td>
                        <td>{{ $event->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
