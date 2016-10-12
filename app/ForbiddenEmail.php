<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForbiddenEmail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'forbiddenemail';
    protected $primaryKey = 'id_forbiddenemail';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'forbidden_email'
    ];
}
