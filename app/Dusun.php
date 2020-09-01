<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dusun extends Model
{
    use SoftDeletes;
    protected $table ='tb_dusun';
    public $autoincrement =false;
    public $incrementing = false;
    protected $fillable = ['id','nama_dusun'];

    public function ibu(){
        return $this->hasMany(Ibu::class);
    }
    public function keluargaberencana(){
        return $this->hasMany(KeluargaBerencana::class);
    }
    public function anak(){
        return $this->hasMany(Anak::class);
    }
}
