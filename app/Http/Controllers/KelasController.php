<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Periode_kbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            $periode = Periode_kbm::all();

            $kelas = Kelas::join('periode_kbms', 'periode_kbms.id', '=', 'kelas.id_periode')
                ->select(
                    'periode_kbms.periodekbm_periode',
                    'periode_kbms.id as idperiode',
                    'kelas.*'
                )
                ->get();
            return view('Kelas.kelas', compact('kelas', 'periode'));
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

            $data = [
                'id_periode' => $request->id_periode,
                'nama_kelas' => $request->nama_kelas,
                'kompetensi_keahlian' => $request->kompetensi_keahlian,
            ];

            Kelas::create($data);
        }

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            Kelas::where('id', $id)->delete();
            return back()->with('hapus', 'Suksess Del');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $user = Auth::user();

        if ($user->level == 'admin') {

            $data = [
                'id_periode' => $request->id_periode,
                'nama_kelas' => $request->nama_kelas,
                'kompetensi_keahlian' => $request->kompetensi_keahlian,
            ];

            Kelas::where('id', $id)->update($data);
            return back()->with('update', 'Sukses');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        //
    }
}
