<?php

namespace App\Http\Controllers;

use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        if ($user->level == 'admin') {

            $spp = Spp::all();
            return view('SPP.spp', compact('spp'));
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
                'tahun' => $request->tahun,
                'nominal' => $request->nominal,
            ];

            Spp::create($data);
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

            Spp::where('id', $id)->delete();
        }

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spp $spp)
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
                'tahun' => $request->tahun,
                'nominal' => $request->nominal,
            ];

            Spp::where('id', $id)->update($data);
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spp $spp)
    {
        //
    }
}
