<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Imports\UserImport;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Anggota_kelas;
use App\Models\Periode_kbm;
use App\Models\Setting_spp;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            $siswa = Siswa::all();
            $kelas = Kelas::all();
            $periode = Periode_kbm::all();

            return view('Siswa.siswa', compact('siswa', 'kelas', 'periode'));
        }

        return back();
    }

    public function userSiswa()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            $user = User::whereIn('level', ['siswa'])->get();

            return view('Siswa.userSiswa', compact('user'));
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            $idperiode = $request->periode;

            // dd($idperiode);

            $settingspp = Setting_spp::where('id', $idperiode)->first();
            // dd($settingspp);

            $user = [
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'nama_petugas' => $request->nama,
                'level' => 'siswa',
            ];

            $user = User::create($user);

            // $idsiswa = User::
            $data = [
                'id_user' => $user->id,
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ];

            // dd($data);

            $siswas = Siswa::create($data);

            $anggota_kelas = [
                'id_siswa' => $siswas->id,
                'id_kelas' => $request->id_kelas,
                'id_setting_spp' => $settingspp->id,
                'id_periode' => $settingspp->id_periode,
            ];

            Anggota_kelas::create($anggota_kelas);

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            Siswa::where('id', $id)->delete();

            return back();
        }
    }

    public function datasiswa($id)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'siswa') {

            $siswa = Siswa::join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->join('spps', 'siswas.id_spp', '=', 'spps.id')
                ->select('kelas.nama_kelas', 'kelas.id as kelas_id', 'spps.nominal', 'spps.tahun', 'spps.id as idspp', 'siswas.*')
                ->where('siswas.id', $id)
                ->get();

            $bulan = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'Oktober', 'November', 'December'
            ];

            $pembayaran = Pembayaran::where('id_siswa', $id)->get();

            $statusPembayaran = [];

            foreach ($bulan as $bln) {
                $statusPembayaran[$bln] = 'Belum Dibayar';
            }

            foreach ($pembayaran as $bayar) {
                $bulanPembayaran = $bayar->bulan_bayar;
                if (in_array($bulanPembayaran, $bulan)) {
                    $statusPembayaran[$bulanPembayaran] = 'Sudah Dibayar';
                }
            }

            // dd($pembayaran);
            return view('Siswa.datasiswa', compact('siswa', 'bulan', 'statusPembayaran', 'pembayaran'));
        }
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            $data = [
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ];

            Siswa::where('id', $id)->update($data);

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        //
    }

    public function importsiswa(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            $this->validate($request, [
                'file' => 'required|mimes:csv,xls,xlsx'
            ]);

            $file = $request->file('file');

            $nama_file = rand() . $file->getClientOriginalName();

            $file->move('filesiswa', $nama_file);

            Excel::import(new UserImport, public_path('/filesiswa/' . $nama_file));
            Excel::import(new SiswaImport, public_path('/filesiswa/' . $nama_file));
            // Excel::import(new AnggotaKelasImport, public_path('/filesiswa/' . $nama_file));

            return back();
        }
    }
}
