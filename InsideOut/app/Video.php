<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    public $table='video';

    public $timestamps = false;

    protected $primaryKey ="id";

    protected $fillable = [
        'task', 'nomeVideo', 'risultatoAnalisi'
    ];
}
