<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekapKeluarExport implements FromCollection, WithHeadings
{
    protected $dates;

    public function __construct($dates)
    {
        $this->dates = $dates;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = DB::table('rekap_barang_keluar')
        ->leftJoin('barang as lensa', function ($join) {
            $join->on('rekap_barang_keluar.lensa', '=', 'lensa.id');
        })
        ->leftJoin('barang as frame', function ($join) {
            $join->on('rekap_barang_keluar.frame', '=', 'frame.id');
        })
        ->where('rekap_barang_keluar.cabang_id', Auth::user()->cabang_id)
        ->select(
            'rekap_barang_keluar.tanggal',
            'lensa.nama_barang as lensa',
            'frame.nama_barang as frame',
            'rekap_barang_keluar.jumlah',
            'rekap_barang_keluar.keterangan'
        );

        if (!empty($this->dates)) {
            $data->whereDate('rekap_barang_keluar.tanggal', $this->dates);
        }

        return $data->get();
    }

    /**
     * Menambahkan header di file excel
     */
    public function headings(): array
    {
        return [
            'Tanggal',
            'Lensa',
            'Frame',
            'Jumlah',
            'Keterangan',
        ];
    }
}
