<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        switch (auth()->user()->role) {
            case  1:
                return view('admin.dashboard.index')
                    ->with('user', auth()->user());
                break;
            case  2:
                return view('staff.dashboard.index')
                    ->with('user', auth()->user());
                break;
            case  3:
                $user = User::find(auth()->user()->id);
                $user->load(['pets', 'reservations', 'securityQuestion']);
                return view('client.dashboard.index')
                    ->with('user', $user);
                break;
        }
    }
}
