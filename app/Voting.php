<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'voting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'vote',
    ];

    /**
     * The atttributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
