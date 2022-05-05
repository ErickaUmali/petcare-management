<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(User $user, UserUpdateRequest $request)
    {
        $user->profile = $request->file('profile')->store('public/profiles/user');
        $user->save();
        return redirect()->route('dashboard.index');
    }
}
