<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorStoreRequest;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        return view('admin.doctors.index')
            ->with('user', auth()->user())
            ->with('doctors', Doctor::all());
    }

    public function store(DoctorStoreRequest $request)
    {
        Doctor::create($request->validated());
        return redirect()->route('doctors.index');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index');
    }
}
