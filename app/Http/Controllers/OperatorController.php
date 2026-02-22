<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OperatorController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q', '');

        $data = DB::table('operator as o')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'o.id_posyandu')
            ->select([
                'o.id_operator',
                'o.nama',
                'o.username',
                'o.role',
                'o.email',
                'o.no_hp',
                'd.nama_posyandu',
            ])
            ->when($q, function ($x) use ($q) {
                $x->where('o.nama', 'like', "%{$q}%")
                  ->orWhere('o.username', 'like', "%{$q}%")
                  ->orWhere('d.nama_posyandu', 'like', "%{$q}%");
            })
            ->orderBy('o.nama')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('operator/Index', [
            'data' => $data,
            'filter' => [
                'q' => $q
            ]
        ]);
    }

    public function create()
    {
        $posyandu = DB::table('duspy')
            ->select('id_posyandu', 'nama_posyandu')
            ->orderBy('nama_posyandu')
            ->get();

        return Inertia::render('operator/Create', [
            'posyandu' => $posyandu
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:150',
            'username'    => 'required|string|max:100|unique:operator,username',
            'password'    => 'required|string|min:6',
            'role'        => 'required|in:superadmin,admin,kader',
            'id_posyandu' => 'nullable|integer|exists:duspy,id_posyandu',
            'email'       => 'nullable|email',
            'no_hp'       => 'nullable|string|max:30',
        ]);

        DB::table('operator')->insert([
            'nama'        => $request->nama,
            'username'    => $request->username,
            'password'    => bcrypt($request->password),
            'role'        => $request->role,
            'id_posyandu' => $request->id_posyandu,
            'email'       => $request->email,
            'no_hp'       => $request->no_hp,
        ]);

        return redirect('/operator')->with('success', 'Operator berhasil ditambahkan');
    }

    public function show($id)
    {
        $row = DB::table('operator as o')
            ->leftJoin('duspy as d', 'd.id_posyandu', '=', 'o.id_posyandu')
            ->select(
                'o.*',
                'd.nama_posyandu'
            )
            ->where('o.id_operator', $id)
            ->first();

        abort_if(!$row, 404);

        return Inertia::render('operator/Show', [
            'row' => $row
        ]);
    }

    public function edit($id)
    {
        $row = DB::table('operator')
            ->where('id_operator', $id)
            ->first();

        abort_if(!$row, 404);

        $posyandu = DB::table('duspy')
            ->select('id_posyandu', 'nama_posyandu')
            ->orderBy('nama_posyandu')
            ->get();

        return Inertia::render('operator/Edit', [
            'row' => $row,
            'posyandu' => $posyandu
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'        => 'required|string|max:150',
            'username'    => 'required|string|max:100|unique:operator,username,' . $id . ',id_operator',
            'role'        => 'required|in:superadmin,admin,kader',
            'id_posyandu' => 'nullable|integer|exists:duspy,id_posyandu',
            'email'       => 'nullable|email',
            'no_hp'       => 'nullable|string|max:30',
        ]);

        DB::table('operator')
            ->where('id_operator', $id)
            ->update([
                'nama'        => $request->nama,
                'username'    => $request->username,
                'role'        => $request->role,
                'id_posyandu' => $request->id_posyandu,
                'email'       => $request->email,
                'no_hp'       => $request->no_hp,
            ]);

        return redirect('/operator')->with('success', 'Operator berhasil diperbarui');
    }

    public function destroy($id)
    {
        DB::table('operator')
            ->where('id_operator', $id)
            ->delete();

        return redirect('/operator')->with('success', 'Operator berhasil dihapus');
    }
}