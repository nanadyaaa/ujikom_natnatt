<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrsPinjam extends Model
{
    use HasFactory;
    // protected $table = 'trs_pinjam'; // Pastikan nama tabel benar
    protected $primaryKey = 'id'; // Sesuaikan jika primary key bukan 'id'
    protected $guarded = ['id']; // Atau $fillable jika Anda mendefinisikan secara eksplisit

    protected $fillable = [
        'no_transaksi_pinjam',
        'kd_anggota',
        'tg_pinjam',
        'tgl_bts_kembali',
        'kd_koleksi',
        'id_pengguna',
        'status',
    ];

    protected $table = 'trs_pinjam';

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'kd_anggota', 'kd_anggota');
    }

    public function koleksi()
    {
        return $this->belongsTo(Koleksi::class, 'kd_koleksi', 'kd_koleksi');
    }
}