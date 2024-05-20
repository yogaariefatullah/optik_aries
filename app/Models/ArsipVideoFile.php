<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ArsipVideoFile extends Authenticatable
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
    protected $table = 'arsip_video_file';
    protected $fillable = [
        'id',
        'id_arsip_video',
        'file',
        'code',
    ];
}
