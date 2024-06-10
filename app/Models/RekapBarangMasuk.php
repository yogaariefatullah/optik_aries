<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class RekapBarangMasuk extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $primaryKey = 'id';
    protected $table = 'rekap_barang_masuk';
    protected $fillable = [
        'tanggal',
        'jenis_barang',
        'id_barang',
        'jumlah_barang',
        'harga_modal',
        'harga_jual',
        'cabang_id'
    ];
}
