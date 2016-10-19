<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
   	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vote';
    protected $primaryKey = 'id_vote';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_facebook',
        'nama_facebook',
        'email',
        'vote_code',
        'status',
        'ip_addr'
    ];

    public function booth()
    {
    	return $this->belongsTo('App\Booth', 'id_booth', 'id_booth');
    }
}
