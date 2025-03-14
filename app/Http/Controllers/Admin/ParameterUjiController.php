<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ParameterUji;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Hash;

class ParameterUjiController extends Controller
{
    //
    public function index() {
        $parameterUjis = ParameterUji::paginate(50);

        return Inertia::render('Admin/ParameterUji/Index', compact(
            'parameterUjis'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan'=>'nullable',
            'kadar_maksimum_operator'=>'nullable',
            'kadar_maksimum_value'=>'nullable',
            'metode_uji'=>'nullable',
        ]);

        ParameterUji::create([
            'nama' => $validated['nama'],
            'satuan' => $validated['satuan'],
            'kadar_maksimum_operator' => $validated['kadar_maksimum_operator'],
            'kadar_maksimum_value' => $validated['kadar_maksimum_value'],
            'metode_uji' => $validated['metode_uji'],
        ]);

        return redirect()->route('admin.parameteruji.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'satuan' => 'nullable',
            'kadar_maksimum_operator' => 'nullable',
            'kadar_maksimum_value' => 'nullable',
            'metode_uji' => 'nullable',
        ]);
        
        $user->update($validated);

        return redirect()->route('admin.parameteruji.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.parameteruji.index')->with('success', 'Data berhasil dihapus!');
    }
}
