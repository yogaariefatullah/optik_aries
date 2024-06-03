<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Transaksi extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $primaryKey = 'id';
    protected $table = 'transaksi';
    protected $fillable = [
        'spher_od',
        'cylders_od',
        'axis_od',
        'prism_od',
        'base_od',
        'add_od',
        'pd_od',

        'spher_os',
        'cylders_os',
        'axis_os',
        'prism_os',
        'base_os',
        'add_os',
        'tseg_os',

        'lensa_id',
        'frame_id',
        'tanggal_selesai',
        'order_tanggal',
        'lain_lain',
        'nama',
        'alamat',
        'jam',
        'no_telp',
        'resep_dr',
        'jumlah',
        'uang_muka',
        'sisa',
        'no_transaksi',
        'id_cabang',

    ];
}
