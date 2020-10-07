<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    public $table='condivisione';

    public $timestamps = false;

    protected $primaryKey ="id";

    protected $fillable = [
        'nomeProgetto', 'proprietario','collaboratore','progetto'
    ];

    public function progetto(){
        return $this->hasMany('App\Progetto');
    }
}
