<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->level == 'admin') {
            $petugas = User::whereIn('level', ['petugas', 'admin'])
                ->get();

            return view('Petugas.petugas', compact('petugas'));
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
                'username' => $request->username,
                'password' => bcrypt($request->password),
                'nama_petugas' => $request->nama_petugas,
                'level' => $request->level,
            ];

            User::create($data);
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

            $users = User::where('id', $id)->get();
            // dd($users);
            $level = User::where('level', $users[0]['level']);
            $jumlah = $level->count();
            // dd($jumlah);

            if ($jumlah == 1) {
                return back()->with('pesan', 'Akun Tinggal Satu Tidak Bisa Di Hapus');
                // session()->flash('pesan', 'Data Yang Di Hapus Hanya Ada Satu');
            } else {
                User::where('id', $id)->delete();

                return back()->with('hapus', 'Akun Telah Terhapus');
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $petugas)
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

            $pass = $request->password;
            // dd($pass);
            if (empty($pass)) {
                $data = [
                    'username' => $request->username,
                    'nama_petugas' => $request->nama_petugas,
                    'level' => $request->level,
                ];

                User::where('id', $id)->update($data);
            } else {
                $data = [
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                    'nama_petugas' => $request->nama_petugas,
                    'level' => $request->level,
                ];

                // dd($data);

                User::where('id', $id)->update($data);
            }

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $petugas)
    {
        //
    }
}
