<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthStoreRequest;
use App\Models\SecurityQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(AuthLoginRequest $request)
    {
        $credentials1 = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $credentials2 = [
            'contact' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials1) || Auth::attempt($credentials2)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home.index'));
        }

        return back()
            ->withInput()
            ->withErrors([
                'credentials' => 'Incorrect email address or password.',
            ]);
    }

    public function create()
    {
        return view('auth.create')
            ->with('securityQuestions', SecurityQuestion::inRandomOrder()->get());
    }

    public function store(AuthStoreRequest $request)
    {
        $user = User::create(array_merge($request->validated(), [
            'role' => 3,
            'firstname' => ucwords($request->firstname),
            'lastname' => ucwords($request->lastname),
            'contact' => '09' . $request->contact,
            'password' => bcrypt($request->password),
        ]));

        if ($user) {
            return redirect()->route('auth.index')
                ->with('storeSuccess', 'Account created successfully.');
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('home.index');
    }
}
