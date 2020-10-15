<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $table='task';

    protected $primaryKey ="id";

    protected $fillable = [
        'progetto', 'nomeTask','descrizione'
    ];

    public function video(){
        return $this->hasMany('App\Video');
    }
}
