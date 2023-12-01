<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use App\Models\Periode_kbm;
use App\Models\setting_spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingSppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            $spp = Spp::all();
            $periode =  Periode_kbm::all();

            $settingspp = Setting_spp::join('periode_kbms', 'periode_kbms.id', '=', 'setting_spps.id_periode')
                ->join('spps', 'setting_spps.id_spp', '=', 'spps.id')
                ->select(
                    'periode_kbms.periodekbm_periode',
                    'periode_kbms.id as idperiode',
                    'setting_spps.*',
                    'spps.nominal',
                    'spps.keterangan',
                    'spps.id as idspp',
                )
                ->get();

            // dd($settingspp);

            return view('SettingSpp.settingspp', compact('settingspp', 'periode', 'spp'));
        }
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
        // dd($request->idspp); 

        $data = [
            'id_spp' => $request->idspp,
            'id_periode' => $request->idperiode,
        ];

        Setting_spp::create($data);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        setting_spp::where('id', $id)->delete();

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(setting_spp $setting_spp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = [
            'id_spp' => $request->idspp,
            'id_periode' => $request->idperiode,
        ];

        Setting_spp::where('id', $id)->update($data);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(setting_spp $setting_spp)
    {
        //
    }
}
