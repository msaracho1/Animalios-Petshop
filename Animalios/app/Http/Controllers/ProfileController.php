<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
        ]);

        // Si cambia el email, evitar duplicados
        $exists = \App\Models\User::where('email', $data['email'])
            ->where('id_usuario', '!=', $user->id_usuario)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Ese email ya está en uso.');
        }

        $user = Auth::userOrFail();
        $user->update($data);


        return back()->with('success', 'Perfil actualizado.');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'contraseña' => ['required','string','min:4','max:45'],
        ]);

        $user = Auth::userOrFail();
        $user-> update([
            'contraseña' => sha1($data['contraseña']),
        ]);

        return back()->with('success', 'Contraseña actualizada.');
    }
}