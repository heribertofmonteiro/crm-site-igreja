<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class UsernameRecoveryController extends Controller
{
    /**
     * Display the username recovery form.
     */
    public function showRecoverForm()
    {
        return view('auth.recover-username');
    }

    /**
     * Handle a username recovery request.
     */
    public function sendRecoveryLink(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        // Find user by name and email
        $user = User::where('name', 'like', '%' . $request->name . '%')
                    ->where('email', $request->email)
                    ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'name' => ['Os dados informados não correspondem a nenhum usuário cadastrado.'],
            ]);
        }

        // Return success with user info (in a real app, send an email)
        return response()->json([
            'status' => 'Um lembrete de usuário foi enviado para seu e-mail.',
            'user' => [
                'email' => $user->email,
                'created_at' => $user->created_at,
            ],
        ]);
    }
}
