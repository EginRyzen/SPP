<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periode_kbm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Periode_kbms';

    protected $fillable = [
        'periodekbm_periode',
        'periodekbm_tanggalawal',
        'periodekbm_tanggalakhir',
    ];
}
