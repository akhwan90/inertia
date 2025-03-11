<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index() {
        $users = User::paginate(2);

        return Inertia::render('Admin/Users/Index', compact(
            'users'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'level' => 'required'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'level'=>$validated['level']
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'password' => 'nullable|min:8',
            'level' => 'required'
        ]);

        if (!$request->filled('password')) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($request->password);
        }
        

        $user->update($validated);

        // return response()->json(['message' => 'User berhasil diperbarui!']);
        // return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}
