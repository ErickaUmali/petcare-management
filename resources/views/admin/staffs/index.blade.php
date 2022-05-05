@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/staffs/index.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Staffs
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <header>
                <p>View Staffs</p>
            </header>
            <section>
                <div class="header">
                    <span>Firstname</span>
                    <span>Lastname</span>
                    <span>Contact</span>
                    <span>Action</span>
                </div>
                @forelse ($staffs as $index => $staff)
                    <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST" class="staffs">
                        @csrf
                        @method('DELETE')
                        <span>{{ $index + 1 }}</span>
                        <span>{{ ucwords($staff->firstname) }}</span>
                        <span>{{ ucwords($staff->lastname) }}</span>
                        <span>{{ $staff->contact }}</span>
                        <span>
                            <button type="submit" class="btn btn-danger">Dismiss</button>
                        </span>
                    </form>
                @empty
                    <footer>
                        There are currently no staffs.
                    </footer>
                @endforelse

            </section>
        </main>
    </div>
@endsection
