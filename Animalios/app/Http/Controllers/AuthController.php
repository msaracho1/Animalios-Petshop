<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'contraseña' => ['required','string'],
        ]);

        $user = User::where('email', $data['email'])
            ->where('contraseña', sha1($data['contraseña']))
            ->first();

        if (!$user) {
            return back()->with('error', 'Credenciales inválidas.');
        }

        Auth::login($user);

        // Redirección según rol
        if ($user->role?->nombre === 'admin') {
            return redirect()->route('admin.products.index');
        }

        return redirect()->route('orders.index');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'contraseña' => ['required','string','min:4','max:45'],
        ]);

        // Evitar duplicado por email
        if (User::where('email', $data['email'])->exists()) {
            return back()->with('error', 'Ese email ya está registrado.');
        }

        // Rol cliente por defecto (busca por nombre)
        $roleCliente = Role::where('nombre', 'cliente')->first();

        // Si en tu BD el rol se llama distinto (ej: "user"), cambiá acá.
        if (!$roleCliente) {
            return back()->with('error', 'No existe el rol cliente en la base.');
        }

        $user = User::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'contraseña' => sha1($data['contraseña']),
            'id_rol' => $roleCliente->id_rol,
        ]);

        Auth::login($user);

        return redirect()->route('orders.index')->with('success', 'Cuenta creada correctamente.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}