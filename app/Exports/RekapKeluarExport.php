<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekapKeluarExport implements FromCollection, WithHeadings
{
    protected $dates;

    public function __construct($dates, $cabang_export)
    {
        $this->dates = $dates;
        $this->cabang_export = $cabang_export;
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
            ->leftJoin('barang as lensa_kiri', function ($join) {
                $join->on('rekap_barang_keluar.lensa_id_kiri', '=', 'lensa_kiri.id')
                    ->where('lensa_kiri.jenis', '=', 1);
            })
            ->leftJoin('barang as frame', function ($join) {
                $join->on('rekap_barang_keluar.frame', '=', 'frame.id');
            })
            ->join('transaksi', 'transaksi.id', 'rekap_barang_keluar.id_transaksi')
            ->select(
                'rekap_barang_keluar.tanggal',
                'lensa.nama_barang as lensa',
                'lensa.harga_asli as lensa_harga',
                'lensa_kiri.nama_barang as lensa_kiri',
                'lensa_kiri.harga_asli as lensa_kiri_kiri',
                'frame.nama_barang as frame',
                'frame.harga_asli as frame_harga',
                'rekap_barang_keluar.jumlah',
                'transaksi.no_telp',
                'transaksi.diskon',
                'rekap_barang_keluar.keterangan'
            );

        // Filter by date if dates are provided
        if (!empty($this->dates)) {
            $data->whereDate('rekap_barang_keluar.tanggal', $this->dates);
        }

        // Check if the user is admin (cabang_id == 0)
        if (Auth::user()->cabang_id == 0) {
            // If admin, filter by cabang_export if provided
            if (!empty($this->cabang_export)) {
                $data->where('rekap_barang_keluar.cabang_id', $this->cabang_export);
            }
        } else {
            // If not admin, filter by the user's cabang_id
            $data->where('rekap_barang_keluar.cabang_id', Auth::user()->cabang_id);
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
            'Harga Asli Lensa Kanan',
            'Lensa Kiri',
            'Harga Asli Lensa Kiri',
            'Frame',
            'Harga Asli Frame',
            'Jumlah',
            'No Telp',
            'Diskon',
            'Keterangan',
        ];
    }
}
