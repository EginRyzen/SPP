<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Spp;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Pembayaran;
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

            $inputkelas = $request->id_kelas;
            $siswa = Siswa::join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->join('spps', 'siswas.id_spp', '=', 'spps.id')
                ->where(function ($filter) use ($inputkelas) {
                    if (isset($inputkelas)) {
                        $filter->where('siswas.id_kelas', $inputkelas);
                    }
                })
                ->select('kelas.nama_kelas', 'kelas.id as kelas_id', 'spps.nominal', 'spps.tahun', 'spps.id as idspp', 'siswas.*')
                ->get();
            return view('Pembayaran.pembayaran', compact('kelas', 'siswa'));
        }

        return back();
    }

    public function history()
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {

            $history = Pembayaran::join('users', 'pembayarans.id_petugas', '=', 'users.id')
                ->join('siswas', 'pembayarans.id_siswa', '=', 'siswas.id')
                ->join('spps', 'pembayarans.id_spp', '=', 'spps.id')
                ->join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->select('pembayarans.*', 'users.*', 'siswas.*', 'spps.*', 'kelas.*')
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

            $inputkelas = $request->idkelas;
            $idSiswa = $request->id_siswa;

            $siswa = Siswa::join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                ->join('spps', 'siswas.id_spp', '=', 'spps.id')
                ->where(function ($filter) use ($inputkelas) {
                    if (isset($inputkelas)) {
                        $filter->where('siswas.id_kelas', $inputkelas);
                    }
                })
                ->select('kelas.nama_kelas', 'kelas.id as kelas_id', 'spps.nominal', 'spps.tahun', 'spps.id as idspp', 'siswas.*')
                ->get();

            if (isset($idSiswa)) {
                $datasiswa = Siswa::join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
                    ->join('spps', 'siswas.id_spp', '=', 'spps.id')
                    ->select('kelas.nama_kelas', 'kelas.id as kelas_id', 'spps.nominal', 'spps.tahun', 'spps.id as idspp', 'siswas.*')
                    ->where('siswas.id', $idSiswa)
                    ->get();

                // dd($datasiswa);

                $bulan = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'Oktober', 'November', 'December'
                ];

                $pembayaran = Pembayaran::where('id_siswa', $idSiswa)->get();

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
                return view('Pembayaran.pembayaranbaru', compact('kelas', 'siswa', 'datasiswa', 'bulan', 'statusPembayaran'));
            }


            return view('Pembayaran.pembayaranbaru', compact('kelas', 'siswa'));
        }
        return back();
    }

    public function storebaru(Request $request)
    {
        $user = Auth::user();

        if ($user->level == 'admin' || $user->level == 'petugas') {

            $user = Auth::user();

            $id_siswa = $request->id_siswa;
            $bulan = $request->bulan_bayar;
            $tahun = $request->tahun_bayar;
            $jumlahbayar = $request->nominal;
            // dd($jumlahbayar);

            if (isset($bulan)) {
                $siswa = Siswa::where('id', $id_siswa)->first();

                foreach ($bulan as $bln) {
                    Pembayaran::create([
                        'id_siswa' => $id_siswa,
                        'id_spp' => $siswa->id_spp,
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

        // $siswa = Siswa::where('id', $id_siswa)->first();

        // $data = [
        //     'id_siswa' => $id_siswa,
        //     'id_petugas' => $user->id,
        //     'id_spp' => $siswa->id_spp,
        //     'tgl_bayar' => now(),
        //     'bulan_bayar' => $bulan,
        //     'tahun_bayar' => $tahun,
        //     'jumlah_bayar' => $jumlahbayar,
        // ];

        // dd($data);

        // Pembayaran::create($data);

    }

    public function print($id)
    {

        // dd($id);
        $siswa = Siswa::join('kelas', 'siswas.id_kelas', '=', 'kelas.id')
            ->join('spps', 'siswas.id_spp', '=', 'spps.id')
            ->select('siswas.*', 'kelas.*', 'kelas.id as id_kelas', 'kelas.nama_kelas', 'spps.*', 'spps.*')
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
        return view('Pembayaran.printpembayaran', compact('siswa', 'bulan', 'statusPembayaran', 'pembayaran'));
    }
}
