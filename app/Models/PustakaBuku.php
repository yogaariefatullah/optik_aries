<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PustakaBuku extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $connection = 'pgsql2';

    protected $primaryKey = 'id';
    protected $casts = [
        'id' => 'string'
    ];
    protected $table = 'pustaka_buku';
    protected $fillable = [
        'id',
        'id_subjek',
        'pengarang',
        'judul',
        'penerbit',
        'jumlah_halaman',
        'tipe_media',
        'bahasa',
        'cover',
        'deskripsi',
        'tahun_terbit',
    ];
}
