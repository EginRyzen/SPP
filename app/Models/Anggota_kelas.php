<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggota_kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'anggota_kelas';

    protected $fillable = [
        'id_kelas',
        'id_siswa',
        'id_periode',
        'id_setting_spp'
    ];
}
