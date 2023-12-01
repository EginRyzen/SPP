<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\anggota_kelas;
use App\Models\Periode_kbm;
use App\Models\Setting_spp;
use Illuminate\Support\Facades\Auth;

class AnggotaKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            $kelas = Kelas::all();
            $siswa = Siswa::all();
            $periode = Periode_kbm::all();

            $anggota_kelas = Anggota_kelas::join('siswas', 'siswas.id', '=', 'anggota_kelas.id_siswa')
                ->join('kelas', 'kelas.id', '=', 'anggota_kelas.id_kelas')
                ->join('periode_kbms', 'periode_kbms.id', '=', 'anggota_kelas.id_periode')
                ->join('setting_spps', 'anggota_kelas.id_setting_spp', '=', 'setting_spps.id')
                ->join('spps', 'setting_spps.id_spp', '=', 'spps.id')
                ->select(
                    'anggota_kelas.*',
                    'siswas.nama',
                    'siswas.id as idsiswa',
                    'kelas.nama_kelas',
                    'kelas.kompetensi_keahlian',
                    'kelas.id as idkelas',
                    'periode_kbms.periodekbm_periode',
                    'periode_kbms.id as idperiode',
                    'setting_spps.id as idsetting',
                    'spps.nominal'
                )
                ->get();

            // dd($anggota_kelas);

            return view('AnggotaKelas.anggotakelas', compact('anggota_kelas', 'kelas', 'siswa', 'periode'));
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kelas = $request->idkelas;
        $periode = $request->idperiode;

        // dd($kelas);

        $settingspp = Setting_spp::where('id_periode', $periode)
            ->first();

        // dd($settingspp);

        $data = [
            'id_kelas' => $kelas,
            'id_siswa' => $request->idsiswa,
            'id_periode' => $request->idperiode,
            'id_setting_spp' => $settingspp->id,
        ];

        Anggota_kelas::create($data);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $users = Anggota_kelas::where('id', $id)->get();
        // dd($users);
        $level = Anggota_kelas::where('id_siswa', $users[0]['id_siswa']);
        $jumlah = $level->count();
        // dd($jumlah);

        if ($jumlah == 1) {
            return back()->with('pesan', 'Akun Tinggal Satu Tidak Bisa Di Hapus');
            // session()->flash('pesan', 'Data Yang Di Hapus Hanya Ada Satu');
        } else {
            Anggota_kelas::where('id', $id)->delete();

            return back()->with('hapus', 'Akun Telah Terhapus');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(anggota_kelas $anggota_kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $data = [
            'id_kelas' => $request->idkelas,
            'id_siswa' => $request->idsiswa,
            'id_periode' => $request->idperiode,
        ];

        Anggota_kelas::where('id', $id)->update($data);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(anggota_kelas $anggota_kelas)
    {
        //
    }
}
