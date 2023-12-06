<?php

namespace App\Imports;

use App\Models\Spp;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Periode_kbm;
use App\Models\Setting_spp;
use App\Models\Anggota_kelas;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class AnggotaKelasImport implements ToModel, WithHeadingRow
{

    use Importable;

    protected $siswas;
    protected $kelas;
    protected $setting_spps;
    // protected $spps;

    public function __construct()
    {
        $this->siswas = Siswa::select('id', 'nama')->get();
        $this->kelas = Kelas::select('id', 'nama_kelas')->get();
        $this->setting_spps = Setting_spp::select('id', 'id_periode')->get();
        // $this->spps = Spp::select('id', 'keterangan')->get();

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
        $periode = Periode_kbm::where('periodekbm_periode', $row['Periode'])->first();
        // dd($periode);
        Log::info('Debug Info', ['siswas' => $siswas, 'periode' => $periode]);
        if ($periode) {
            $nominal = Spp::where('nominal', $row['Nominal'])->first();
            // dd($nominal);
            // Periksa apakah $nominal tidak null sebelum mencoba membaca propertinya
            Log::info('Debug Info2', ['siswas' => $siswas, 'periode' => $periode]);
            if ($nominal) {
                $kelas = Kelas::where('nama_kelas', $row['NamaKelas'])
                    ->where('id_periode', $periode->id)
                    ->first();

                // dd($kelas);
                Log::info('Debug Info3', ['kelas' => $kelas]);

                // Periksa apakah $kelas tidak null sebelum mencoba membaca propertinya
                if ($kelas) {
                    $setting_spps = Setting_spp::where('id_spp', $nominal->id)
                        ->where('id_periode', $periode->id)
                        ->first();

                    return new Anggota_kelas([
                        'id_siswa' => $siswas->id,
                        'id_kelas' => $kelas->id,
                        'id_setting_spp' => $setting_spps->id,
                        'id_periode' => $kelas->id_periode,
                    ]);
                } else {
                    // $kelas bernilai null, menampilkan alert menggunakan JavaScript
                    Session::flash('kelas', 'kelas_not_found');
                }
            } else {
                // $nominal bernilai null, menampilkan alert menggunakan JavaScript
                Session::flash('nominal', 'nominal');
            }
        } else {
            Log::info('Debug Info4', ['siswas' => $siswas, 'periode' => $periode]);
            // $periode bernilai null, menampilkan alert menggunakan JavaScript
            Session::flash('tahun', 'periode_not_found');
        }
        // Log::info('Debug Info', ['row' => $row]);
    }
}
