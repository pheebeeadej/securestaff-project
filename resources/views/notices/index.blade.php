@extends('layouts.app')

@section('page-title', 'Notices')
@section('page-subtitle', 'Published organizational notices and alerts')

@section('content')
    @foreach($notices as $notice)
        <div class="panel" style="margin-bottom:16px;">
            <h3>{{ $notice->title }}</h3>
            <p class="muted">{{ $notice->published_at }}</p>
            <p>{{ $notice->body }}</p>
        </div>
    @endforeach
@endsection
