<?php

namespace App\Exports;

use App\Models\Jadwal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


// class ExportJadwal implements FromQuery
class ExportJadwal implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Jadwal::select('jadwal.kode_kelas', 'ref_kelas.tingkat', 'ref_jurusan.jurusan', 'ref_kelas.kelas', 'jadwal.hari', 'jadwal.tanggal', 'jadwal.pertemuan', 'jadwal.kode_matkul', 'ref_matkul.matkul', 'jadwal.kode_jam', 'jadwal.kode_ruangan', 'jadwal.kode_dosen', 'ref_dosen.dosen')
                    ->leftJoin('ref_kelas', 'jadwal.kode_kelas', '=', 'ref_kelas.kode')
                    ->leftJoin('ref_jurusan', 'ref_kelas.kode_jurusan', '=', 'ref_jurusan.kode')
                    ->leftJoin('ref_matkul', 'jadwal.kode_matkul', '=', 'ref_matkul.kode')
                    ->leftJoin('ref_dosen', 'jadwal.kode_dosen', '=', 'ref_dosen.kode')
                    ->limit(3)
                    ->get();
    }

    public function headings(): array {
        return [
            'kode_kelas',
            'tingkat',
            'jurusan',
            'kelas',
            'hari',
            'tanggal',
            'pertemuan',
            'kode_matkul',
            'matkul',
            'kode_jam',
            'kode_ruangan',
            'kode_dosen',
            'dosen'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:M1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'FFFF00', // Yellow color
                        ],
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'], // Black color
                        ],
                    ],
                ]);
                $event->sheet->getStyle('A1:M' . $event->sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            },
        ];
    }
}
