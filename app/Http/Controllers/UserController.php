<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
        public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        
        return view('users.index', compact('users'));
    }

   
    public function create()
    {
        return view('users.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:5|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

   
    public function profile()
    {
        // Menampilkan data user yang sedang login
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

   
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

        /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'old_password' => 'required_with:password', // Wajib isi jika ingin ganti password
            'password' => 'nullable|string|min:5|confirmed', 
        ]);

        // 1. Cek Password Lama jika user mengisi password baru
        if ($request->filled('password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                // Kembali ke halaman edit dengan pesan error & data input tetap tersimpan
                return back()->with('error', 'Password lama salah. Update dibatalkan.')->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        // 2. Update data biasa (Name & Username)
        $user->name = $request->name;
        $user->username = $request->username;

        // 3. Cek apakah ada perubahan data sebelum menyimpan
        if ($user->isDirty()) {
            $user->save();
            return redirect()->route('profile')->with('success', 'Profile atau Password berhasil diupdate');
        }

        // Jika tidak ada perubahan data sama sekali
        return back()->with('info', 'Tidak ada perubahan data yang disimpan.');
    }

    public function destroy(User $user)
    {
        // Cegah penghapusan user yang sedang login
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}