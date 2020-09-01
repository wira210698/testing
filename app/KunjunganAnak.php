<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KunjunganAnak extends Model
{
    use SoftDeletes;
    protected $table = 'tb_kunjungan_anak';
    public $incrementing = false;
    protected $fillable=[
        'anak_id','tgl_kunjungan','kd_pelayanan','tempat','umur','bb','kondisi_anak','ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(KunjunganAnak $item){
            // $code ='KA';
            // $countDataOnTable = KunjunganAnak::withTrashed()->count();
            // $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            // $item->id = $code;
            $newId= 'KA';
            $lastId =KunjunganAnak::withTrashed()->max('id');
            $idIncremment = substr($lastId,-4);
            $newId .=str_pad($idIncremment +1, 4, '0', STR_PAD_LEFT);
            $item->id= $newId;
        });

    }

    public function anak(){
        return $this->belongsTo(Anak::class);
    }

}
