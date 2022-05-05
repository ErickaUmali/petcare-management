<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentStoreRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments.index')
            ->with('user', auth()->user())
            ->with('appointments', Appointment::all());
    }

    public function store(AppointmentStoreRequest $request)
    {
        Appointment::create($request->validated());
        return redirect()->route('appointments.index');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index');
    }
}
