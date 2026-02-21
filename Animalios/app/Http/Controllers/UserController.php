<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')
            ->orderByDesc('id_usuario')
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('nombre')->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'contraseña' => ['required','string','min:4','max:45'],
            'id_rol' => ['required','integer'],
        ]);

        // ⚠️ No tocamos la BD, así que no usamos bcrypt si contraseña es VARCHAR(45)
        $data['contraseña'] = sha1($data['contraseña']);

        User::create($data);

        return redirect()->route('admin.users.index')->with('success','Usuario creado.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('nombre')->get();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'nombre' => ['required','string','max:255'],
            'email' => ['required','email','max:255'],
            'id_rol' => ['required','integer'],
            // contraseña opcional al editar
            'contraseña' => ['nullable','string','min:4','max:45'],
        ]);

        if (!empty($data['contraseña'])) {
            $data['contraseña'] = sha1($data['contraseña']);
        } else {
            unset($data['contraseña']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success','Usuario actualizado.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Evitar que un admin se elimine a sí mismo (opcional pero recomendable)
        if (Auth::user()->id_usuario === $user->id_usuario) {
            return redirect()->route('admin.users.index')->with('error','No podés darte de baja a vos mismo.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success','Usuario eliminado.');
    }
}