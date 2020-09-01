<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KeluargaBerencana extends Model
{
    
    use SoftDeletes;
    protected $table ='reg_keluarga_berencana';
    public $autoincrement =false;
    public $incrementing = false;
    protected $fillable = [
        'nama_ibu',
        'nama_suami',
        'umur',
        'jmlh_anak',
        'dusun_id',
        'riwayat_penyakit',
        'faktor_resiko',
        'gakin',
        'pasca_bersalin',
        'ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(KeluargaBerencana $item){
            $code ='KB';
            $countDataOnTable = KeluargaBerencana::count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT);
            $item->id = $code;
        });

    }

    public function dusun(){
        return $this->belongsTo(Dusun::class);
    }
    public function kunjungankb(){
        return $this->hasMany(KunjunganKb::class, 'kb_id', 'id');
    }
    
}
