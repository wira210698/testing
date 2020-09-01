<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Prasekolah extends Model
{
    use SoftDeletes;
    protected $table = 'tb_pelayanan_prasekolah';
    public $incrementing = false;
    protected $fillable=[
        'anak_id','tgl_pelayanan','tempat','status_gizi','pemberian_arv'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(Prasekolah $item){
            $code ='PS';
            $countDataOnTable = Prasekolah::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
        });

    }

    public function anak(){
        return $this->belongsTo(Anak::class);
    }
}
