<?php

namespace App\Http\Controllers;

use App\Models\Motor;
use App\Models\JenisMotor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MotorController extends Controller
{
    public function index()
    {
        $motors = Motor::with('jenisMotor')->latest()->paginate(10);
        return view('modules.motor.index', compact('motors'));
    }

    public function create()
    {
        $jenisMotors = JenisMotor::all();
        return view('modules.motor.create', compact('jenisMotors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_motor' => 'required|unique:motors,kode_motor',
            'nama_motor' => 'required',
            'id_jenis' => 'required|exists:jenis_motors,id',
            'harga_cash' => 'required|numeric',
            'dp_minimum' => 'required|numeric',
            'stok' => 'required|integer',
            'warna' => 'required',
            'kapasitas_mesin' => 'required',
            'tahun_produksi' => 'required|integer',
            'deskripsi_motor' => 'required',
            'foto1' => 'nullable|image',
            'foto2' => 'nullable|image',
            'foto3' => 'nullable|image',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('foto1')) {
            $validated['foto1'] = $request->file('foto1')->store('motors', 'public');
        }
        if ($request->hasFile('foto2')) {
            $validated['foto2'] = $request->file('foto2')->store('motors', 'public');
        }
        if ($request->hasFile('foto3')) {
            $validated['foto3'] = $request->file('foto3')->store('motors', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        Motor::create($validated);

        return redirect()->route('motor.index')->with('success', 'Motor berhasil ditambahkan.');
    }

    public function edit(Motor $motor)
    {
        $jenisMotors = JenisMotor::all();
        return view('modules.motor.edit', compact('motor', 'jenisMotors'));
    }

    public function update(Request $request, Motor $motor)
    {
        $validated = $request->validate([
            'kode_motor' => 'required|unique:motors,kode_motor,' . $motor->id,
            'nama_motor' => 'required',
            'id_jenis' => 'required|exists:jenis_motors,id',
            'harga_cash' => 'required|numeric',
            'dp_minimum' => 'required|numeric',
            'stok' => 'required|integer',
            'warna' => 'required',
            'kapasitas_mesin' => 'required',
            'tahun_produksi' => 'required|integer',
            'deskripsi_motor' => 'required',
            'foto1' => 'nullable|image',
            'foto2' => 'nullable|image',
            'foto3' => 'nullable|image',
        ]);

        if ($request->hasFile('foto1')) {
            if ($motor->foto1) Storage::disk('public')->delete($motor->foto1);
            $validated['foto1'] = $request->file('foto1')->store('motors', 'public');
        }
        if ($request->hasFile('foto2')) {
            if ($motor->foto2) Storage::disk('public')->delete($motor->foto2);
            $validated['foto2'] = $request->file('foto2')->store('motors', 'public');
        }
        if ($request->hasFile('foto3')) {
            if ($motor->foto3) Storage::disk('public')->delete($motor->foto3);
            $validated['foto3'] = $request->file('foto3')->store('motors', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $motor->update($validated);

        return redirect()->route('motor.index')->with('success', 'Motor berhasil diperbarui.');
    }

    public function destroy(Motor $motor)
    {
        if ($motor->foto1) Storage::disk('public')->delete($motor->foto1);
        if ($motor->foto2) Storage::disk('public')->delete($motor->foto2);
        if ($motor->foto3) Storage::disk('public')->delete($motor->foto3);
        $motor->delete();
        return back()->with('success', 'Motor berhasil dihapus.');
    }
}
