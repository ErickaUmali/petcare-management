@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/doctors/index.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Doctors
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <header>
                <p>Doctors</p>
                <span>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Doctor
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <form action="{{ route('doctors.store') }}" method="POST" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Doctor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <label class="form-label">Doctor Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </span>
            </header>
            <section>
                <div class="header">
                    <span>Name</span>
                    <span>Action</span>
                </div>
                @forelse ($doctors as $index => $doctor)
                    <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="doctors">
                        @csrf
                        @method('DELETE')
                        <span>{{ $index + 1 }}</span>
                        <span>{{ $doctor->name }}</span>
                        <span>
                            <button type="submit" class="btn btn-danger">Dismiss</button>
                        </span>
                    </form>
                @empty
                    <footer>
                        There are currently no doctors.
                    </footer>
                @endforelse

            </section>
        </main>
    </div>
@endsection
