<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's account.
     */
    public function index()
    {
        $user = Auth::user();
        return view('admin.account.index', compact('user'));
    }

    /**
     * Show the form for editing the user's account.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.account.edit', compact('user'));
    }

    /**
     * Update the user's account.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only(['name', 'email']));

        return redirect()->route('account.index')->with('success', 'Conta atualizada com sucesso.');
    }
}