<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Imunisasi extends Model
{
    use SoftDeletes;
    protected $table ="tb_imunisasi";
    public $incrementing = false;
    protected $fillable=[
        'nama_imunisasi','ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(Imunisasi $item){
            $code ='IM';
            $countDataOnTable = Imunisasi::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
        });

    }

    public function anak(){
        return $this->belongsToMany(Anak::class)->withPivot(['tgl_kunjungan'])->whereNull('anak_imunisasi.deleted_at')->withTimeStamps();
    }
}
