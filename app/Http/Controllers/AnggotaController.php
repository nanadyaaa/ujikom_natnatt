<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Anggota::with('role'); // eager load role
    
        if ($request->has('search') && $request->search !== null) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nm_anggota', 'like', '%' . $search . '%')
                  ->orWhere('kd_anggota', 'like', '%' . $search . '%');
            });
        }
    
        $sortOrder = $request->input('sort_kode', 'asc');
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }
    
        $query->orderBy('kd_anggota', $sortOrder);
    
        $data = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $codeData = Anggota::createCode();
    
        // ✅ Ambil semua data role
        $roles = Role::all();
    
        return view('anggota.index')->with([
            'data' => $data,
            'codeData' => $codeData,
            'roles' => $roles // ⬅️ kirim ke view
        ]);
    }
    
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // INSERT KE TABEL ANGGOTA
        $anggotaData = [
            'kd_anggota' => $request->input('kd_anggota'),
            'nm_anggota' => $request->input('nm_anggota'),
            'jk' => $request->input('jk'),
            'alamat' => $request->input('alamat'),
            'status' => $request->input('status'),
            'role_id' => $request->input('role_id'),
            'jml_pinjam' => 0,
        ];
        Anggota::create($anggotaData);
    
        // INSERT KE TABEL USER
        $userData = [
            'email' => $request->input('kd_anggota') . '@gmail.com',
            'password' => bcrypt('12345678'),
            'name' => $request->input('nm_anggota'),
            'status' => 'AKTIF',
            'role_id' => $request->input('role_id'),
        ];
        User::create($userData);
    
        return back()->with('message_insert', 'Data Sudah ditambahkan');
    }
    
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $data = [
        'nm_anggota' => $request->input('nm_anggota'),
        'jk' => $request->input('jk'),
        'alamat' => $request->input('alamat'),
        'status' => $request->input('status'),
        'role_id' => $request->input('role_id'), // ✅ tambahkan ini
    ];

    $datas = Anggota::findOrFail($id);
    $datas->update($data);

    return back()->with('message_update', 'Data Sudah diupdate');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Anggota::findOrFail($id);
        $data->delete();
        return back()->with('message_delete', 'Data Berhasil dihapus');
    }
}