<aside>
    @if ($user->role == 1)
        <a href="{{ route('dashboard.index') }}" class="admin">Admin Dashboard</a>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        class="accordion-button {{ str_contains(Route::currentRouteName(), 'reservation') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                        aria-controls="collapseOne">
                        Reservations
                    </button>
                </h2>
                <div id="collapseOne"
                    class="accordion-collapse collapse {{ str_contains(Route::currentRouteName(), 'reservation') ? 'show' : '' }}"
                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <a href="{{ route('reservations.pending') }}">Pending</a>
                    <a href="{{ route('reservations.completed') }}">Completed</a>
                </div>
            </div>
        </div>
        <div class="links">
            <a href="{{ route('appointments.index') }}"
                class="{{ str_contains(Route::currentRouteName(), 'appointment') ? 'active' : '' }}">Appointments</a>
            <a href="{{ route('doctors.index') }}"
                class="{{ str_contains(Route::currentRouteName(), 'doctor') ? 'active' : '' }}">Doctors</a>
        </div>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button
                        class="accordion-button {{ str_contains(Route::currentRouteName(), 'staff') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                        Staffs
                    </button>
                </h2>
                <div id="collapseTwo"
                    class="accordion-collapse collapse {{ str_contains(Route::currentRouteName(), 'staff') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <a href="{{ route('staffs.index') }}">View</a>
                    <a href="{{ route('staffs.create') }}">Add</a>
                </div>
            </div>
        </div>
    @elseif ($user->role == 2)
        <a href="{{ route('dashboard.index') }}" class="staff">Staff Dashboard</a>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        class="accordion-button {{ str_contains(Route::currentRouteName(), 'reservation') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                        aria-controls="collapseOne">
                        Reservations
                    </button>
                </h2>
                <div id="collapseOne"
                    class="accordion-collapse collapse {{ str_contains(Route::currentRouteName(), 'reservation') ? 'show' : '' }}"
                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <a href="{{ route('reservations.pending') }}">Pending</a>
                    <a href="{{ route('reservations.completed') }}">Completed</a>
                </div>
            </div>
        </div>
    @elseif ($user->role == 3)
        <a href="{{ route('dashboard.index') }}">Client Dashboard</a>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        class="accordion-button {{ str_contains(Route::currentRouteName(), 'pets') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                        aria-controls="collapseOne">
                        Pets
                    </button>
                </h2>
                <div id="collapseOne"
                    class="accordion-collapse collapse {{ str_contains(Route::currentRouteName(), 'pets') ? 'show' : '' }}"
                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <a href="{{ route('pets.create') }}">Add</a>
                    <a href="{{ route('pets.index') }}">View</a>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button
                        class="accordion-button {{ str_contains(Route::currentRouteName(), 'reservation') ? '' : 'collapsed' }}"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                        aria-controls="collapseTwo">
                        Reservation
                    </button>
                </h2>
                <div id="collapseTwo"
                    class="accordion-collapse collapse {{ str_contains(Route::currentRouteName(), 'reservation') ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <a href="{{ route('reservations.create') }}">Create</a>
                    <a href="{{ route('reservations.index') }}">View</a>
                </div>
            </div>
        </div>
    @endif
</aside>
