<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $table='task';

    public $timestamps = false;

    protected $primaryKey ="id";

    protected $fillable = [
        'progetto', 'nomeTask','descrizione'
    ];

    public function progetto(){
        return $this->hasMany('App\Video');
    }
}
