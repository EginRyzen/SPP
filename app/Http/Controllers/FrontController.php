<?php

namespace App\Http\Controllers;

use App\Models\Anggota_kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dasbord');
    }
    public function login()
    {
        return view('login');
    }
    public function postlogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $data = $request->only('username', 'password');

        // dd($data);
        if (Auth::attempt($data)) {
            $user = Auth::user();
            if ($user->level == 'siswa') {
                // dd($user);
                $siswa = Siswa::where('id_user', $user->id)->first();
                // dd($siswa);
                $anggota = Anggota_kelas::where('id_siswa', $siswa->id)->first();

                // dd($anggota);

                $request->session()->put('siswa', $siswa, $anggota);
                return redirect('dasbord');
            }
            return redirect('dasbord');
        }
        dd('Autentikasi Eror');
    }
    public function logout()
    {
        session()->flush();

        Auth::logout();

        return redirect('/');
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
