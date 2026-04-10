@extends('layouts.app')

@section('page-title', 'Payroll Summary')
@section('page-subtitle', 'Monthly gross pay, deductions, and net pay')

@section('content')
    <div class="panel">
        <table>
            <thead>
                <tr><th>Month</th><th>Gross Pay</th><th>Deductions</th><th>Net Pay</th></tr>
            </thead>
            <tbody>
                @foreach($entries as $entry)
                    <tr>
                        <td>{{ $entry->month }}</td>
                        <td>{{ number_format($entry->gross_pay, 2) }}</td>
                        <td>{{ number_format($entry->deductions, 2) }}</td>
                        <td>{{ number_format($entry->net_pay, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
