<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembayaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_petugas',
        'id_anggotakelas',
        'id_settingspp',
        'id_periode',
        'tgl_bayar',
        'tahun_bayar',
        'bulan_bayar',
        'jumlah_bayar',
    ];
}
