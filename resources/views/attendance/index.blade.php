@extends('layouts.app')

@section('page-title', 'Attendance')
@section('page-subtitle', 'Clock-in logs and attendance summaries')

@section('content')
    <div style="display:flex; gap:12px; margin-bottom:16px;">
        <form method="POST" action="{{ route('attendance.clock-in') }}">@csrf<button class="btn">Clock In</button></form>
        <form method="POST" action="{{ route('attendance.clock-out') }}">@csrf<button class="btn">Clock Out</button></form>
    </div>

    <div class="panel">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Clock In</th>
                    <th>Clock Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        <td>{{ $record->work_date }}</td>
                        <td>{{ $record->clock_in_at }}</td>
                        <td>{{ $record->clock_out_at }}</td>
                        <td>{{ ucfirst($record->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
