<?php

namespace App\Http\Controllers;

use App\Models\Anggota_kelas;
use Carbon\Carbon;
use App\Models\Spp;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Pembayaran;
use App\Models\Periode_kbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {
            $kelas = Kelas::all();
            $tahunajaran = Periode_kbm::all();

            // $inputkelas = $request->id_siswa;
            // $siswa = Anggota_kelas::join('siswas', 'siswas.id', '=', 'anggota_kelas.id_siswa')
            //     ->join('kelas', 'kelas.id', '=', 'anggota_kelas.id_kelas')
            //     ->join('setting_spps', 'setting_spps.id', '=', 'anggotakelas.id_setting_spp')
            //     ->join('spps', 'spps.id', '=', 'setting_spps.id_spp')
            //     ->where(function ($filter) use ($inputkelas) {
            //         if (isset($inputkelas)) {
            //             $filter->where('siswas.id_kelas', $inputkelas);
            //         }
            //     })
            //     ->select(
            //         'kelas.nama_kelas',
            //         'kelas.id as kelas_id',
            //         'spps.nominal',
            //         'spps.keterangan',
            //         'spps.id as idspp',
            //         'siswas.*',
            //         'anggota_kelas.id as id_anggotakelas'
            //     )
            //     ->get();
            return view('Pembayaran.pembayaran', compact('kelas', 'siswa', 'tahunajaran'));
        }

        return back();
    }

    public function history()
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {

            $history = Pembayaran::join('anggota_kelas', 'pembayarans.id_anggotakelas', '=', 'anggota_kelas.id')
                ->join('users', 'users.id', '=', 'pembayarans.id_petugas')
                ->join('siswas', 'siswas.id', '=', 'anggota_kelas.id_siswa')
                ->join('periode_kbms', 'periode_kbms.id', '=', 'anggota_kelas.id_periode')
                ->join('kelas', 'kelas.id', '=', 'anggota_kelas.id_kelas')
                ->join('setting_spps', 'setting_spps.id', '=', 'anggota_kelas.id_setting_spp')
                ->join('spps', 'spps.id', '=', 'setting_spps.id_spp')
                ->get();

            return view('Pembayaran.history', compact('history'));
        }

        return back();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */

    public function cart(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {
            $bulantahun = $request->month;
            $id  = $request->id_siswa;
            $carbonDate = new Carbon($bulantahun);
            $petugas = Auth::user();

            $tahun = $carbonDate->year;
            $bulan = $carbonDate->format('F');

            $data = Siswa::where('id', $id)->first();
            $spp = Spp::where('id', $data->id_spp)->first();
            $kelas = Kelas::where('id', $data->id_kelas)->first();

            // dd($spp);

            $cart = session()->get('cart', []);
            $itemCount = count($cart);
            $newId = $itemCount + 1;
            // dd($newId);

            if (isset($cart[$id])) {
                foreach ($cart as $item) {
                    if ($item['id_siswa'] === $id && $item['bulan_bayar'] === $bulan && $item['tahun_bayar'] === $tahun) {
                        return back()->with('pesan', 'Data Ada');
                    }
                }

                $baru = count($cart) + 1;
                // dd($baru);

                $cart[$newId] = [
                    'id_siswa' => $id,
                    'id_petugas' => $petugas->id,
                    'id_spp' => $petugas->id,
                    'nama' => $data->nama,
                    'kelas' => $kelas->kompetensi_keahlian,
                    'bulan_bayar' => $bulan,
                    'tahun_bayar' => $tahun,
                    'jumlah_bayar' => $spp->nominal,
                    'jumlah' => 1,
                    'id' => $baru,
                ];

                // dd($cart);

                $request->session()->put('cart', $cart);
                return back();
            } else {
                $cart[$id] = [
                    'id_siswa' => $id,
                    'id_petugas' => $petugas->id,
                    'id_spp' => $petugas->id,
                    'nama' => $data->nama,
                    'kelas' => $kelas->kompetensi_keahlian,
                    'bulan_bayar' => $bulan,
                    'tahun_bayar' => $tahun,
                    'jumlah_bayar' => $spp->nominal,
                    'jumlah' => 1,
                    'id' => $newId,
                ];
                $request->session()->put('cart', $cart);

                return back();
            }
        }
    }

    public function hapus($id)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {

            $cart = session()->get('cart');
            $itemCount = count($cart);

            // unset($cart[$id]);


            if ($itemCount > 1) {
                unset($cart[$id]);
                session()->put('cart', $cart);
            } else {
                session()->forget('cart');
            }

            return back();
        }
    }
    public function reset()
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {

            session()->forget('cart');

            return back();
        }
    }
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {
            $user = Auth::user();

            $cart = session()->get('cart');

            if (isset($cart)) {
                foreach (session('cart') as $value) {
                    $idSiswa = $value['id_siswa'];
                    $bulanBayar = $value['bulan_bayar'];

                    $fistorNew = Pembayaran::where('id_siswa', $idSiswa)
                        ->where('bulan_bayar', $bulanBayar)
                        ->first();
                    if (!$fistorNew) {
                        $data = [
                            'id_siswa' => $value['id_siswa'],
                            'id_petugas' => $user->id,
                            'id_spp' => $value['id_spp'],
                            'tgl_bayar' => now(),
                            'bulan_bayar' => $value['bulan_bayar'],
                            'tahun_bayar' => $value['tahun_bayar'],
                            'jumlah_bayar' => $value['jumlah_bayar'],
                        ];

                        Pembayaran::create($data);
                    }
                }
                session()->forget('cart');
                return back();
            } else {
                return back()->with('pesan', 'Belum Ada Cart');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // dd($id);

        $user = Auth::user();

        if ($user->level == 'admin') {

            Pembayaran::where('id', $id)->delete();

            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function pembayaranbaru(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {

            $kelas = Kelas::all();
            $tahunajaran = Periode_kbm::all();

            $inputkelas = $request->idkelas;
            $idSiswa = $request->id_siswa;
            $periode = $request->id_periode;
            // dd($periode);

            $siswa = Anggota_kelas::join('siswas', 'siswas.id', '=', 'anggota_kelas.id_siswa')
                ->join('periode_kbms', 'periode_kbms.id', '=', 'anggota_kelas.id_periode')
                ->join('kelas', 'kelas.id', '=', 'anggota_kelas.id_kelas')
                ->join('setting_spps', 'setting_spps.id', '=', 'anggota_kelas.id_setting_spp')
                ->join('spps', 'spps.id', '=', 'setting_spps.id_spp')
                ->where(function ($filter) use ($inputkelas, $periode) {
                    if (isset($periode)) {
                        $filter->where('anggota_kelas.id_periode', $periode);
                    }
                    if (isset($inputkelas)) {
                        $filter->where('anggota_kelas.id_kelas', $inputkelas);
                    }
                })
                ->select(
                    'kelas.nama_kelas',
                    'kelas.id as kelas_id',
                    'spps.nominal',
                    'spps.keterangan',
                    'spps.id as idspp',
                    'periode_kbms.periodekbm_periode',
                    'periode_kbms.id as idperiode',
                    'anggota_kelas.id as id_anggotakelas',
                    'siswas.*'
                )
                ->get();

            if (isset($idSiswa)) {
                // dd($idSiswa);
                $datasiswa = Anggota_kelas::join('siswas', 'siswas.id', '=', 'anggota_kelas.id_siswa')
                    ->join('periode_kbms', 'periode_kbms.id', '=', 'anggota_kelas.id_periode')
                    ->join('kelas', 'kelas.id', '=', 'anggota_kelas.id_kelas')
                    ->join('setting_spps', 'setting_spps.id', '=', 'anggota_kelas.id_setting_spp')
                    ->join('spps', 'spps.id', '=', 'setting_spps.id_spp')
                    ->select(
                        'kelas.nama_kelas',
                        'kelas.id as kelas_id',
                        'spps.nominal',
                        'spps.keterangan',
                        'spps.id as idspp',
                        'periode_kbms.periodekbm_periode',
                        'periode_kbms.id as idperiode',
                        'anggota_kelas.id as id_anggotakelas',
                        'siswas.*'
                    )
                    ->where('anggota_kelas.id', $idSiswa)
                    ->get();

                // dd($datasiswa);

                $bulan = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'Oktober', 'November', 'December'
                ];

                $pembayaran = Pembayaran::where('id_anggotakelas', $idSiswa)->get();

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
                return view('Pembayaran.pembayaranbaru', compact('kelas', 'tahunajaran', 'siswa', 'datasiswa', 'bulan', 'statusPembayaran'));
            }


            return view('Pembayaran.pembayaranbaru', compact('kelas', 'siswa', 'tahunajaran'));
        }
        return back();
    }

    public function storebaru(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {

            $user = Auth::user();

            $id_anggotakelas = $request->id_anggotakelas;
            $bulan = $request->bulan_bayar;
            $tahun = $request->tahun_bayar;
            $jumlahbayar = $request->nominal;
            // dd($tahun);

            if (isset($bulan)) {
                $siswa = Anggota_kelas::where('id', $id_anggotakelas)->first();
                // dd($siswa);

                foreach ($bulan as $bln) {
                    Pembayaran::create([
                        'id_anggotakelas' => $siswa->id,
                        'id_settingspp' => $siswa->id_setting_spp,
                        'id_periode' => $siswa->id_periode,
                        'id_petugas' => $user->id,
                        'tgl_bayar' => now(),
                        'bulan_bayar' => $bln,
                        'tahun_bayar' => $tahun,
                        'jumlah_bayar' => $jumlahbayar,
                    ]);
                }
            }

            return back();
        }
    }

    public function print($id)
    {

        // dd($id);
        $siswa = Anggota_kelas::join('siswas', 'siswas.id', '=', 'anggota_kelas.id_siswa')
            ->join('periode_kbms', 'periode_kbms.id', '=', 'anggota_kelas.id_periode')
            ->join('kelas', 'kelas.id', '=', 'anggota_kelas.id_kelas')
            ->join('setting_spps', 'setting_spps.id', '=', 'anggota_kelas.id_setting_spp')
            ->join('spps', 'spps.id', '=', 'setting_spps.id_spp')
            ->select(
                'kelas.nama_kelas',
                'kelas.id as kelas_id',
                'spps.nominal',
                'spps.keterangan',
                'spps.id as idspp',
                'periode_kbms.periodekbm_periode',
                'periode_kbms.id as idperiode',
                'anggota_kelas.id as id_anggotakelas',
                'siswas.*'
            )
            ->where('anggota_kelas.id', $id)
            ->get();

        $bulan = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'Oktober', 'November', 'December'
        ];

        $pembayaran = Pembayaran::where('id_anggotakelas', $id)->get();

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
        return view('Pembayaran.printpembayaran', compact('siswa', 'bulan', 'statusPembayaran', 'pembayaran'));
    }
}
