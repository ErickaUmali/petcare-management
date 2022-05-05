@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/reservations/index.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Add Pet
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <h1>My Reservations</h1>
            <section>
                <div>
                    <span>Pet</span>
                    <span>Appointment</span>
                    <span>Doctor</span>
                    <span>Date</span>
                    <span>Status</span>
                </div>
                @forelse ($reservations as $reservation)
                    <a href="{{ route('reservations.show', $reservation->id) }}">
                        @if ($reservation->pet->profile)
                            <span class="image"
                                style="background-image: url('{{ asset(str_replace('public/', 'storage/', $reservation->pet->profile)) }}')"></span>
                        @else
                            <span class="image"></span>
                        @endif
                        <span>{{ ucwords($reservation->pet->name) }}</span>
                        <span>{{ ucwords($reservation->appointment->name) }}</span>
                        <span>{{ ucwords($reservation->doctor->name) }}</span>
                        <span>{{ \Carbon\Carbon::parse($reservation->date)->toFormattedDateString() }}</span>
                        @if ($reservation->status == 0)
                            <span>Pending</span>
                        @elseif ($reservation->status == 1)
                            <span>Completed</span>
                        @elseif ($reservation->status == 2)
                            <span>Cancelled</span>
                        @elseif ($reservation->status == 3)
                            <span>Did not arrive</span>
                        @endif
                    </a>
                @empty
                    <p class="p-2 text-center">You currently have no reservations.</p>
                @endforelse
            </section>
        </main>
    </div>
@endsection
