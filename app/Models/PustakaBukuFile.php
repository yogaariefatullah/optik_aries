<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PustakaBukuFile extends Authenticatable
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
    protected $table = 'pustaka_buku_file';
    protected $fillable = [
        'id',
        'id_pustaka_buku',
        'file',
        'code',
    ];
}
