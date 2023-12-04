<?php

namespace App\Imports;

use App\Models\Anggota_kelas;
use Maatwebsite\Excel\Concerns\ToModel;

class AnggotaKelas implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Anggota_kelas([
            //
        ]);
    }
}
