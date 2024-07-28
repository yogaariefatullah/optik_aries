<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RekapBarangKeluar extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'rekap_barang_keluar';
    protected $fillable = [
        'tanggal',
        'lensa',
        'frame',
        'jumlah',
        'keterangan',
        'cabang_id',
        'id_transaksi',
        'diskon',
        'lensa_id_kiri'
    ];
}
