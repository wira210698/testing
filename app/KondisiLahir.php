<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class KondisiLahir extends Model
{
    use SoftDeletes;
    protected $table = 'tb_kondisi_lahir';
    public $incrementing = false;
    protected $fillable=[
        'anak_id','tgl_pelayanan','tempat','kd_kondisi','kd_pelayanan','ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(KondisiLahir $item){
            $code ='KL';
            $countDataOnTable = KondisiLahir::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
        });

    }

    public function anak(){
        return $this->belongsTo(Anak::class);
    }
}
