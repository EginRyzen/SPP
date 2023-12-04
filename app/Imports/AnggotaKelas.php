<?php

namespace App\Imports;

use App\Models\Anggota_kelas;
use App\Models\Kelas;
use App\Models\Setting_spp;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class SiswaImport implements ToModel, WithHeadingRow
{

    use Importable;

    protected $siswas;
    protected $kelas;
    protected $setting_spps;

    public function __construct()
    {
        $this->siswas = Siswa::select('id', 'nama')->get();
        $this->kelas = Kelas::select('id', 'nama_kelas')->get();
        $this->setting_spps = Setting_spp::select('id', 'id_periode')->get();

        // dd($this->kelas);
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $siswas = $this->siswas->where('nama', $row['Nama'])->first();
        $kelas = $this->kelas
            ->where('nama_kelas', $row['NamaKelas'])
            ->where('id_periode', $row['Periode'])
            ->first();
        $setting_spps = $this->setting_spps
            ->where('id_periode', $row['Periode'])
            ->first();

        return new Anggota_kelas([
            'siswa_id' => $siswas->id,
            'id_kelas' => $kelas->id,
            'id_setting_spp' => $setting_spps->id,
            'id_kelas' => $kelas->id,
        ]);
    }
}
