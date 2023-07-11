<?php

namespace App\Imports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportJadwal implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Jadwal([
            // id tidak diinput (auto increment)
            'kode_kelas' => $row['kode_kelas'],
            'hari' => $row['hari'],
            'tanggal' => $row['tanggal'],
            'pertemuan' => $row['pertemuan'],
            'kode_matkul' => $row['kode_matkul'],
            'kode_jam' => $row['kode_jam'],
            'kode_ruangan' => $row['kode_ruangan'],
            'kode_dosen' => $row['kode_dosen']
        ]);
    }
}
