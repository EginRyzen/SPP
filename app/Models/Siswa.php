<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_kelas',
        'id_spp',
        'id_user',
        'nisn',
        'nis',
        'nama',
        'alamat',
        'no_telp',
    ];
}
