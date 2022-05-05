@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/reservations/pending.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Pending Reservations
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <header>
                <div>
                    <p>Pending Reservations</p>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Filter
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('reservations.pending') }}" method="GET" class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Filter Reservations</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <label>Filter by year</label>
                                        <div>
                                            <select class="form-select form-select-sm" name="year">
                                                @foreach ($years as $year)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endforeach
                                            </select>
                                            <input class="form-check-input" type="checkbox" checked name="year_checked"
                                                value="true">
                                        </div>
                                    </div>
                                    <div>
                                        <label>Filter by month</label>
                                        <div>
                                            <select class="form-select form-select-sm" name="month">
                                                @foreach ($months as $index => $month)
                                                    <option value="{{ $index + 1 }}">{{ $month }}</option>
                                                @endforeach
                                            </select>
                                            <input class="form-check-input" type="checkbox" checked name="month_checked"
                                                value="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form action="{{ route('reservations.pending.print') }}" method="POST" class="button-container">
                    @csrf
                    <button type="submit" class="button">Print Records</button>
                </form>
            </header>
            <div class="mt-3 row d-flex justify-content-end">
                <div class="col-4">
                    <form action="" method="GET" class="input-group">
                        <span class="input-group-text">Sort by</span>
                        <select class="form-select" name="sort_by">
                            <option value="latest">Latest</option>
                            <option value="earliest" {{ $earliest ? 'selected' : '' }}>Earliest</option>
                        </select>
                        <button class="btn btn-outline-primary px-4" type="submit">Sort</button>
                    </form>
                </div>
            </div>
            <section>
                <div class="header">
                    <span>Owner</span>
                    <span>Pet</span>
                    <span>Species</span>
                    <span>Date</span>
                    <span>Time</span>
                </div>
                @forelse ($reservations as $reservation)
                    <a href="{{ route('reservations.show', $reservation->id) }}" class="details">
                        @if ($reservation->user->profile)
                            <span class="image">
                                <span class="img"
                                    style="background-image: url('{{ asset(str_replace('public/', 'storage/', $reservation->user->profile)) }}')"></span>
                            </span>
                        @else
                            <span class="image">
                                <span class="img"
                                    style="background-image: url('{{ asset('images/user-solid.svg') }}')"></span>
                            </span>
                        @endif
                        <span>{{ $reservation->user->firstname }} {{ $reservation->user->lastname }}</span>
                        <span>{{ $reservation->pet->name }}</span>
                        <span>{{ ucwords(explode('/', $reservation->pet->species->name)[0]) }}/{{ ucwords(explode('/', $reservation->pet->species->name)[1]) }}</span>
                        <span>{{ \Carbon\Carbon::parse($reservation->date)->toFormattedDateString() }}</span>
                        <span>{{ \Illuminate\Support\Str::remove('', $reservation->time) }}</span>
                    </a>
                @empty
                    <div class="empty">There are currently no pending reservations.</div>
                @endforelse
            </section>
        </main>
    </div>
@endsection
