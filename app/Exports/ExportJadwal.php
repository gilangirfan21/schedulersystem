<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportJadwal implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Jadwal::select('id', 'kode_kelas', 'hari', 'tanggal', 'kode_matkul', 'pertemuan', 'kode_ruangan', 'kode_jam', 'kode_dosen')->get();
    }

    public function headings(): array {
        return ['id', 'kode_kelas', 'hari', 'tanggal', 'pertemuan', 'kode_matkul', 'kode_jam', 'kode_ruangan', 'kode_dosen'];
    }
}
