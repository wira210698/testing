<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KunjunganIbu extends Model
{
    use SoftDeletes;
    protected $table = 'tb_kunjungan_ibu';
    public $incrementing = false;
    protected $fillable=[
        'ibu_id','usia_hamil','tgl_kunjungan','ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(KunjunganIbu $item){
            $code ='K';
            $countDataOnTable = KunjunganIbu::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
            // $newId= 'K';
            // $lastId =KunjunganIbu::max('id');
            // $idIncremment = substr($lastId,-4);
            // $newId .=str_pad($idIncremment +1, 4, '0', STR_PAD_LEFT);
            // $item->id= $newId;
        });

    }

    public function ibu(){
        return $this->belongsTo(Ibu::class);
    }

}
