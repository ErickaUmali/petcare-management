<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home')
            ->with('user', auth()->user())
            ->with('feedbacks', Feedback::with('user')->inRandomOrder()->limit(3)->get());
    }
}
