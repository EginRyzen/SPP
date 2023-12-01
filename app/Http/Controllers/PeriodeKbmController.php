<?php

namespace App\Http\Controllers;

use App\Models\Periode_kbm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodeKbmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            $periode = Periode_kbm::all();
            // dd($periode);
            return view('Periode.periode', compact('periode'));
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
                'periodekbm_periode' => $request->periodekbm_periode,
                'periodekbm_tanggalawal' => $request->periodekbm_tanggalawal,
                'periodekbm_tanggalakhir' => $request->periodekbm_tanggalakhir,
            ];

            // dd($data);

            Periode_kbm::create($data);

            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        Periode_kbm::where('id', $id)->delete();

        return back()->with('hapus', 'success');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(periode_kbm $periode_kbm)
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
                'periodekbm_periode' => $request->periodekbm_periode,
                'periodekbm_tanggalawal' => $request->periodekbm_tanggalawal,
                'periodekbm_tanggalakhir' => $request->periodekbm_tanggalakhir,
            ];

            // dd($data);

            Periode_kbm::where('id', $id)->update($data);

            return back()->with('update', 'success');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(periode_kbm $periode_kbm)
    {
        //
    }
}
