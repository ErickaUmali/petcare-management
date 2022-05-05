@extends('templates.base')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/reservations/create.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/client/reservations/create.js') }}" defer></script>
@endsection

@section('title')
    Reserve
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <h2>Create Reservation</h2>
                <div class="pet">
                    <div>
                        <label>Choose one of your pet</label>
                        <select class="form-select form-select-sm {{ $errors->has('pet_id') ? 'border-danger' : '' }}"
                            name="pet_id">
                            @forelse ($pets as $pet)
                                <option value="{{ $pet->id }}">{{ $pet->name }}</option>
                            @empty
                                <option value="">You have no pets</option>
                            @endforelse
                        </select>
                        @error('pet_id')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div>
                    <label>Appointment Type</label>
                    <select class="form-select form-select-sm {{ $errors->has('appointment_id') ? 'border-danger' : '' }}"
                        name="appointment_id">
                        @foreach ($appointments as $appointment)
                            <option value="{{ $appointment->id }}">{{ $appointment->name }}</option>
                        @endforeach
                    </select>
                    @error('appointment_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Doctor</label>
                    <select class="form-select form-select-sm {{ $errors->has('doctor_id') ? 'border-danger' : '' }}"
                        name="doctor_id">
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Date of Appointment</label>
                    <input type="text" id="date"
                        class="form-control form-control-sm {{ $errors->has('date') ? 'border-danger' : '' }}"
                        name="date">
                    @error('date')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Time</label>
                    <select class="form-select form-select-sm {{ $errors->has('time') ? 'border-danger' : '' }}" id="time"
                        name="time">
                        <option value="">Please choose an appointment date first.</option>
                    </select>
                    @error('time')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="button-container">
                    <button type="submit" class="button">Reserve</button>
                </div>
            </form>
        </main>
    </div>
@endsection
