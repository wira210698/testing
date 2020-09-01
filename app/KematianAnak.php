<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KematianAnak extends Model
{
    use SoftDeletes;
    protected $table = 'tb_anak_meninggal';
    public $incrementing = false;
    protected $fillable=[
        'anak_id','tgl_kematian','tempat','usia_kematian','penyebab_kematian','ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(KematianAnak $item){
            $code ='KT';
            $countDataOnTable = KematianAnak::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
        });

    }

    public function anak(){
        return $this->belongsTo(Anak::class);
    }
}
