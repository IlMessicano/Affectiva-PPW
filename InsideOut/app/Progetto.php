<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Progetto extends Model
{
    public $table='progetto';

    public $timestamps = false;

    protected $primaryKey ="id";

    protected $fillable = [
        'utente', 'dataCreazione',
    ];

    public function task(){
        return $this->hasMany('App\Task');
    }

    public function condivisione(){
        return $this->hasMany('App\Share');
    }
}
