<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Kebijakan;
use App\Models\Koleksi;
use App\Models\Trskembali;
use App\Models\TrsPinjam; // Pastikan ini digunakan jika ada relasi atau logika terkait
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrsKembaliController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Trskembali::paginate(10); // pagination 10 per halaman
        $anggota = Anggota::all();
        $koleksi = Koleksi::all();

        // Pastikan ada data kebijakan sebelum mencoba mengakses propertinya
        $kebijakan = Kebijakan::first();
        $max_wkt_pjm = $kebijakan ? $kebijakan->max_wkt_pjm : null; // Tambahkan null check

        return view('transaksi.kembali.index')->with([
            'data' => $data,
            'anggota' => $anggota,
            'koleksi' => $koleksi,
            'max_wkt_pjm' => $max_wkt_pjm,
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
        $no_transaksi_kembali = date('YmdHis');
        $data = [
            'no_transaksi_kembali' => $no_transaksi_kembali,
            'kd_anggota' => $request->input('kd_anggota'),
            // Perbaikan: Sesuaikan nama input dengan yang ada di HTML/JS
            'tg_pinjam' => $request->input('tg_pinjam'),
            'tg_bts_kembali' => $request->input('tg_bts_kembali'),
            'tg_kembali' => $request->input('tg_kembali'),
            'kd_koleksi' => $request->input('kd_koleksi'),
            'denda' => $request->input('denda'),
            'ket' => $request->input('ket'),
            'id_pengguna' => Auth::user()->id,
        ];
        TrsKembali::create($data);
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
            'kd_anggota' => $request->input('kd_anggota'),
            // Perbaikan: Sesuaikan nama input dengan yang ada di HTML/JS
            'tg_pinjam' => $request->input('tg_pinjam'),
            'tg_bts_kembali' => $request->input('tg_bts_kembali'),
            'tg_kembali' => $request->input('tg_kembali'),
            'kd_koleksi' => $request->input('kd_koleksi'),
            'denda' => $request->input('denda'),
            'ket' => $request->input('ket'),
        ];

        $datas = TrsKembali::findOrFail($id);
        $datas->update($data);
        return back()->with('message_update', 'Data Sudah diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = TrsKembali::findOrFail($id);
        $kdKoleksi = $data->kd_koleksi;

        $koleksi = Koleksi::where('kd_koleksi', $kdKoleksi)->first();
        if($koleksi){
            $koleksi->status = 'TERSEDIA'; // Asumsi 'TERSEDIA' adalah status yang benar
            $koleksi->save();
        }

        $data->delete();
        return back()->with('message_delete', 'Data Berhasil dihapus');
    }
}