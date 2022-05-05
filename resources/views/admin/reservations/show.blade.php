@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reservations/show.css') }}">
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
                <div class="owner">
                    @if ($reservation->user->profile)
                        <div class="image">
                            <span class="img"
                                style="background-image: url('{{ asset(str_replace('public/', 'storage/', $reservation->user->profile)) }}')">
                            </span>
                        </div>
                    @else
                        <div class="image">
                            <span>No Profile</span>
                        </div>
                    @endif
                    <div class="details">
                        <span>{{ $reservation->user->firstname }} {{ $reservation->user->lastname }}</span>
                        <span>{{ $reservation->user->contact }}</span>
                    </div>
                </div>
                <div class="reservation">
                    <div>
                        <label>Appointment: </label>
                        <span>{{ $reservation->appointment->name }}</span>
                    </div>
                    <div>
                        <label>Doctor: </label>
                        <span>{{ $reservation->doctor->name }}</span>
                    </div>
                    <div>
                        <label>Date: </label>
                        <span>{{ $reservation->date }}</span>
                    </div>
                    <div>
                        <label>Time: </label>
                        <span>{{ $reservation->time }}</span>
                    </div>
                    <div>
                        <label>Reference: </label>
                        <span>{{ $reservation->reference }}</span>
                    </div>
                </div>
                <div class="pet">
                    <div class="details">
                        <p>{{ $reservation->pet->name }}</p>
                        <div>
                            <span>Gender: </span>
                            <span>{{ ucwords($reservation->pet->gender) }}</span>
                        </div>
                        <div>
                            <span>Birthday: </span>
                            <span>{{ \Carbon\Carbon::parse($reservation->pet->birthday)->toFormattedDateString() }}</span>
                        </div>
                        <div>
                            <span>Species: </span>
                            <span>{{ ucwords(explode('/', $reservation->pet->species->name)[0]) }}/{{ ucwords(explode('/', $reservation->pet->species->name)[1]) }}</span>
                        </div>
                        <div>
                            <span>Breed: </span>
                            @if (str_contains($reservation->pet->breed->name, '/'))
                                <span>{{ ucwords(strtolower(explode('/', $reservation->pet->breed->name)[0])) }}/{{ ucwords(strtolower(explode('/', $reservation->pet->breed->name)[1])) }}</span>
                            @else
                                <span>{{ ucwords(strtolower($reservation->pet->breed->name)) }}</span>
                            @endif
                        </div>
                    </div>
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
                </div>
            </section>
            @if ($reservation->status == 0)
                <footer>
                    <div class="d-flex gap-2">
                        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="status" value="3" hidden>
                            <button type="submit" class="btn btn-outline-danger">Did not Arrive</button>
                        </form>
                        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="status" value="2" hidden>
                            <button type="submit" class="btn btn-outline-secondary">Cancel Reservation</button>
                        </form>
                        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="text" name="status" value="1" hidden>
                            <button type="submit" class="btn btn-primary">Mark as Complete</button>
                        </form>
                    </div>
                </footer>
            @endif
        </main>
    </div>
@endsection
