@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/reservations/show.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Reservation Details
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <header>
                <span>Reservation Details</span>
                <form action="{{ route('reservations.print', $reservation->id) }}" method="POST" class="button-container">
                    @csrf
                    <button type="submit" class="button">Print Slip</button>
                </form>
            </header>
            <section>
                @if ($reservation->pet->profile)
                    <div class="image">
                        <span class="img"
                            style="background-image: url('{{ asset(str_replace('public/', 'storage/', $reservation->pet->profile)) }}')">
                        </span>
                    </div>
                @else
                    <div class="image">
                        <span>No Profile</span>
                    </div>
                @endif
                <div class="details">
                    <p>{{ $reservation->pet->name }}</p>
                    <span>Species:
                        {{ ucwords(explode('/', $reservation->pet->species->name)[0]) }}/{{ ucwords(explode('/', $reservation->pet->species->name)[1]) }}</span>


                    @if (str_contains($reservation->pet->breed->name, '/'))
                        <span>Breed:
                            {{ ucwords(strtolower(explode('/', $reservation->pet->breed->name)[0])) }}/{{ ucwords(strtolower(explode('/', $reservation->pet->breed->name)[1])) }}</span>
                    @else
                        <span>Breed: {{ ucwords(strtolower($reservation->pet->breed->name)) }}</span>
                    @endif
                    <span>Appointment: {{ $reservation->appointment->name }}</span>
                    <span>Doctor: {{ $reservation->doctor->name }}</span>
                    <span>Date: {{ \Carbon\Carbon::parse($reservation->date)->toFormattedDateString() }}</span>
                    <span>Time: {{ $reservation->time }}</span>
                    @if ($reservation->status == 0)
                        <span>Status: Pending</span>
                    @elseif ($reservation->status == 1)
                        <span>Status: Completed</span>
                    @elseif ($reservation->status == 2)
                        <span>Status: Cancelled</span>
                    @elseif ($reservation->status == 3)
                        <span>Status: Did not arrive</span>
                    @endif
                    <span>Reference: {{ $reservation->reference }}</span>
                </div>
            </section>
        </main>
    </div>
@endsection
