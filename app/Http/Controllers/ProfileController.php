<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return Inertia::render('profile/Show', [
            'user' => $request->user(),
        ]);
    }

    public function edit(Request $request)
    {
        return Inertia::render('profile/Edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'nama' => 'required|string|max:150',
            'email' => [
            'required',
            'email',
            Rule::unique('operator', 'email')
                ->ignore($user->id_operator, 'id_operator'),
            ],
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->nama = $validated['nama'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect('/profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
}