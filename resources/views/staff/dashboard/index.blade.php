@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/dashboard/index.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Client Dashboard
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
        </main>
    </div>
@endsection
