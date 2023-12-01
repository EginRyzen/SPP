<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting_spp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'setting_spps';

    protected $fillable = [
        'id_spp',
        'id_periode',
    ];
}
