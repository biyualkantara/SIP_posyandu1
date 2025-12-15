<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'operator');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($x) use ($q) {
                $x->where('name', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return Inertia::render('operator/Index', [
            'data' => $data,
            'filter' => [
                'q' => $request->q ?? '',
                'status' => $request->status ?? '',
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('operator/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'operator',
            'status' => $validated['status'],
        ]);

        return redirect('/operator')->with('success', 'Operator berhasil ditambahkan');
    }

    public function show($id)
    {
        $row = User::where('role', 'operator')->findOrFail($id);

        return Inertia::render('operator/Show', [
            'row' => $row,
        ]);
    }

    public function edit($id)
    {
        $row = User::where('role', 'operator')->findOrFail($id);

        return Inertia::render('operator/Edit', [
            'row' => $row,
        ]);
    }

    public function update(Request $request, $id)
    {
        $row = User::where('role', 'operator')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users,email,' . $row->id,
            'password' => 'nullable|min:6',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $row->name = $validated['name'];
        $row->email = $validated['email'];
        $row->status = $validated['status'];

        if (!empty($validated['password'])) {
            $row->password = Hash::make($validated['password']);
        }

        $row->save();

        return redirect('/operator')->with('success', 'Operator berhasil diperbarui');
    }

    public function destroy($id)
    {
        User::where('role', 'operator')->findOrFail($id)->delete();
        return back()->with('success', 'Operator berhasil dihapus');
    }
}