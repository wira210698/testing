<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SasaranIbu extends Model
{
    use SoftDeletes;
    protected $table = 'tb_sasaran_ibu';
    public $incrementing = false;
    protected $fillable=[
        'dusun_id','bumil','bulin','bumil_resti','periode'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(SasaranIbu $item){
            $code ='SI';
            $countDataOnTable = SasaranIbu::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
        });

    }
}
