@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Overview of employee operations and security posture')

@section('content')
    <div class="card-grid">
        <div class="card"><div class="muted">Total Employees</div><h2>{{ $employeeCount }}</h2></div>
        <div class="card"><div class="muted">Present Employees</div><h2>{{ $presentToday }}</h2></div>
        <div class="card"><div class="muted">On Leave</div><h2>{{ $openLeaves }}</h2></div>
        <div class="card"><div class="muted">Security Events</div><h2>{{ $recentSecurityEvents->count() }}</h2></div>
    </div>

    <div class="split">
        <div class="panel">
            <h3>Recent Security Events</h3>
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Severity</th>
                        <th>Description</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentSecurityEvents as $event)
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

        <div class="panel">
            <h3 style="margin-top:0;">Today's Stats</h3>
            <p class="muted">From SecureStaff</p>
            @php
                $score = $employeeCount > 0 ? (int) round(($presentToday / max(1, $employeeCount)) * 100) : 0;
            @endphp
            <div class="ring" style="--score: {{ $score }};">
                <div class="ring-value">{{ $score }}%</div>
            </div>
            <p class="muted" style="text-align:center; margin-bottom:0;">Present today</p>
        </div>
    </div>
@endsection
