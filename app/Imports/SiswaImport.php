<?php

namespace App\Imports;

use App\Models\Spp;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class SiswaImport implements ToModel, WithHeadingRow
{
    use Importable;

    protected $users;

    public function __construct()
    {
        $this->users = User::select('id', 'nama_petugas',)->get();

        // dd($this->kelas);
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * 
     */


    public function model(array $row)
    {
        $users = $this->users->where('nama_petugas', $row['Nama'])->first();
        // dd($kelas);

        $data = Siswa::where('nisn', $row['Nisn'])->firstOrNew();
        $data->id_user = $users->id;
        $data->nisn = $row['Nisn'];
        $data->nis = $row['Nis'];
        $data->nama = $row['Nama'];
        $data->alamat = $row['Alamat'];
        $data->no_telp = $row['Telp'];

        return $data;
    }
}
