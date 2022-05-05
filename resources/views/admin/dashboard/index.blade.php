@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard/index.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Admin Dashboard
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
        </main>
    </div>
@endsection
