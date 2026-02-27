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
            ->leftJoin('duspy as d', 'o.id_posyandu', '=', 'd.id_posyandu')
            ->select([
                'o.id_operator',
                'o.nama',
                'o.username',
                'o.role',
                'o.email',
                'o.no_hp',
                'd.nama_posyandu',
            ])
            ->when($q, function ($query) use ($q) {
                $query->where('o.nama', 'like', "%{$q}%")
                      ->orWhere('o.username', 'like', "%{$q}%")
                      ->orWhere('d.nama_posyandu', 'like', "%{$q}%");
            })
            ->orderBy('o.nama')
            ->paginate(15)
            ->withQueryString();

        return Inertia::render('operator/Index', [
            'data' => $data,
            'filter' => ['q' => $q]
        ]);
    }

    public function create()
    {
        return Inertia::render('operator/Create', [
            'posyandu' => DB::table('duspy')
                ->select('id_posyandu', 'nama_posyandu')
                ->orderBy('nama_posyandu')
                ->get(),

            'kecamatan' => DB::table('kcmtn')
                ->select('id_kec', 'nama_kec')
                ->orderBy('nama_kec')
                ->get(),

            'kelurahan' => DB::table('klrhn')
                ->select('id_kel', 'nama_kel', 'id_kec')
                ->orderBy('nama_kel')
                ->get(),
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
            'alamat'      => 'nullable|string',
            'kcmtn'       => 'nullable|integer|exists:kcmtn,id_kec',
            'klrhn'       => 'nullable|integer|exists:klrhn,id_kel',
        ]);

        DB::table('operator')->insert([
            'nama'        => $request->nama,
            'username'    => $request->username,
            'password'    => bcrypt($request->password),
            'role'        => $request->role,
            'id_posyandu' => $request->id_posyandu,
            'email'       => $request->email,
            'no_hp'       => $request->no_hp,
            'alamat'      => $request->alamat,
            'kcmtn'       => $request->kcmtn,
            'klrhn'       => $request->klrhn,
        ]);

        return redirect('/operator')->with('success', 'Operator berhasil ditambahkan');
    }

    public function show($id)
        {
            $row = DB::table('operator as o')
                ->leftJoin('duspy as d', 'o.id_posyandu', '=', 'd.id_posyandu')
                ->leftJoin('kcmtn as k', 'o.kcmtn', '=', 'k.id_kec')
                ->leftJoin('klrhn as l', 'o.klrhn', '=', 'l.id_kel')
                ->select(
                    'o.*',
                    'd.nama_posyandu',
                    'k.nama_kec',
                    'l.nama_kel'
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

        return Inertia::render('operator/Edit', [
            'row' => $row,

            'posyandu' => DB::table('duspy')
                ->select('id_posyandu', 'nama_posyandu')
                ->orderBy('nama_posyandu')
                ->get(),

            'kecamatan' => DB::table('kcmtn')
                ->select('id_kec', 'nama_kec')
                ->orderBy('nama_kec')
                ->get(),

            'kelurahan' => DB::table('klrhn')
                ->select('id_kel', 'nama_kel', 'id_kec')
                ->orderBy('nama_kel')
                ->get(),
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
            'alamat'      => 'nullable|string',
            'kcmtn'       => 'nullable|integer|exists:kcmtn,id_kec',
            'klrhn'       => 'nullable|integer|exists:klrhn,id_kel',
        ]);

        $data = [
            'nama'        => $request->nama,
            'username'    => $request->username,
            'role'        => $request->role,
            'id_posyandu' => $request->id_posyandu,
            'email'       => $request->email,
            'no_hp'       => $request->no_hp,
            'alamat'      => $request->alamat,
            'kcmtn'       => $request->kcmtn,
            'klrhn'       => $request->klrhn,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        DB::table('operator')
            ->where('id_operator', $id)
            ->update($data);

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