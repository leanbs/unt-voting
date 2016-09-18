<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'booth';
    protected $primaryKey = 'id_booth';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'directory_logo',
        'logo_name',
        'nama_produk',
        'anggota_kelompok',
        'deskripsi_produk'
    ];

    public function vote()
    {
    	return $this->hasMany('App\Vote', 'id_booth', 'id_booth');
    }
}
