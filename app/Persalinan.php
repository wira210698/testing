<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Persalinan extends Model
{
    use SoftDeletes;
    protected $table = 'tb_persalinan';
    public $incrementing = false;
    protected $fillable=[
        'ibu_id','tgl_persalinan','tng_penolong','jenis_kelahiran'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(Persalinan $item){
            $code ='P';
            $countDataOnTable = Persalinan::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
            // $newId= 'P';
            // $lastId =Persalinan::max('id');
            // $idIncremment = substr($lastId,-4);
            // $newId .=str_pad($idIncremment +1, 4, '0', STR_PAD_LEFT);
            // $item->id= $newId;
        });

    }

    public function ibu(){
        return $this->belongsTo(Ibu::class);
    }

}
