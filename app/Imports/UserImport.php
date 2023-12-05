<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        $data = User::where('nama_petugas', $row['Nama'])->firstOrNew();
        // dd($row['Username']);
        $data->username = trim($row['Username']);
        // dd($data->username);
        $data->nama_petugas = $row['Nama'];
        $data->password = Hash::make($row['Password']);
        return $data;
        // return new User([

        // ]);
    }
}
