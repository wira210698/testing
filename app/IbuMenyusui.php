<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class IbuMenyusui extends Model
{
    use SoftDeletes;
    protected $table = 'tb_ibu_menyusui';
    public $incrementing = false;
    protected $fillable=[
        'ibu_id','tgl_nifas','ket','periode_nifas'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(IbuMenyusui $item){
            $code ='P';
            $countDataOnTable = IbuMenyusui::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT) ;
            $item->id = $code;
            // $newId= 'P';
            // $lastId =Persalinan::max('id');
            // $idIncremment = substr($lastId,-4);
            // $newId .=str_pad($idIncremment +1, 4, '0', STR_PAD_LEFT);
            // $item->id= $newId;
        });

    }

    public function ibu(){
        return $this->belongsTo(Ibu::class);
    }
}
