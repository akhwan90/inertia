<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PemeriksaanKategori;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;

class PemeriksaanKategoriController extends Controller
{
    //
    public function index() {
        $pemeriksaanKategoris = PemeriksaanKategori::paginate(50);

        return Inertia::render('Admin/PemeriksaanKategori/Index', compact(
            'pemeriksaanKategoris'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        PemeriksaanKategori::create([
            'nama' => $validated['nama'],
        ]);

        return redirect()->route('admin.pemeriksaankategori.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        
        $user->update($validated);

        return redirect()->route('admin.pemeriksaankategori.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.pemeriksaankategori.index')->with('success', 'Data berhasil dihapus!');
    }
}
