<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SetupController extends Controller
{
    public function show()
    {
        return view('setup');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'min:3', 'max:30', 'regex:/^[a-zA-Z0-9_-]+$/'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'status'   => 'approved',
            'is_admin' => true,
        ]);

        return redirect('/login')->with('success', 'Admin account created. Please login.');
    }
}
