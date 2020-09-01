<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KunjunganKb extends Model
{
    use SoftDeletes;
    protected $table = 'tb_kunjungan_kb';
    public $incrementing = false;
    protected $fillable=[
        'kb_id','tgl_kunjungan','kategori_peserta','jenis_kb','ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(KunjunganKb $item){
            // $code ='KK';
            // $countDataOnTable = KunjunganIbu::withTrashed()->count();
            // $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            // $item->id = $code;
            $newId= 'KK';
            $lastId =KunjunganKb::withTrashed()->max('id');
            $idIncremment = substr($lastId,-4);
            $newId .=str_pad($idIncremment +1, 4, '0', STR_PAD_LEFT);
            $item->id= $newId;
        });

    }

    public function keluargaberencana(){
        return $this->belongsTo(KeluargaBerencana::class);
    }
}
