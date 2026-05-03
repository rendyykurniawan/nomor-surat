<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use LogsActivity;

    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        return view('pengguna.index', compact('users'));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
        ]);

        $this->log(
            'Membuat Pengguna',
            'Pengguna',
            "Pengguna baru dibuat: {$user->name} ({$user->email})"
        );

        return redirect()->route('pengguna.index')->with('success', 'Akun pengguna berhasil dibuat!');
    }

    public function edit(User $user)
    {
        return view('pengguna.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $this->log(
            'Mengedit Pengguna',
            'Pengguna',
            "Pengguna diedit: {$user->name} ({$user->email})"
        );

        return redirect()->route('pengguna.index')->with('success', 'Akun pengguna berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        $nama  = $user->name;
        $email = $user->email;
        $user->delete();

        $this->log(
            'Menghapus Pengguna',
            'Pengguna',
            "Pengguna dihapus: {$nama} ({$email})"
        );

        return redirect()->route('pengguna.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}
