<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'nim'      => 'required|string|unique:users,nim',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'nim'      => $request->nim,
            'password' => Hash::make($request->password),
            'role'     => 1, // Misal 1 = student
        ]);

        return back()->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
