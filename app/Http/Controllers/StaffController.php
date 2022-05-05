<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffStoreRequest;
use App\Models\SecurityQuestion;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffs = User::where('role', 2)->get();
        return view('admin.staffs.index')
            ->with('user', auth()->user())
            ->with('staffs', $staffs);
    }

    public function create()
    {
        return view('admin.staffs.create')
            ->with('user', auth()->user())
            ->with('securityQuestions', SecurityQuestion::inRandomOrder()->get());
    }

    public function store(StaffStoreRequest $request)
    {
        User::create(array_merge($request->validated(), [
            'role' => 2,
            'firstname' => ucwords($request->firstname),
            'lastname' => ucwords($request->lastname),
            'contact' => '09' . $request->contact,
            'password' => bcrypt($request->password),
        ]));
        return redirect()->route('staffs.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('staffs.index');
    }
}
