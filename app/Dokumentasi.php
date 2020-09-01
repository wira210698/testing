<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Dokumentasi extends Model
{
    use SoftDeletes;
    protected $table = "tb_doc";
    public $autoincrement =false;
    public $incrementing = false;
    protected $fillable = [
        'img',
        'kategori',
        'judul',
        'subjek',
        'ket'
    ];
    public static function boot(){
        
        parent::boot();
        static::creating(function(Dokumentasi $item){
            $code ='D';
            $countDataOnTable = Dokumentasi::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT);
            $item->id = $code;
        });

    }
    
}
