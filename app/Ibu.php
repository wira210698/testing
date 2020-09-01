<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ibu extends Model
{
    use SoftDeletes;
    protected $table ='reg_ibu';
    public $autoincrement =false;
    public $incrementing = false;
    protected $fillable = [
        'NIK',
        'nama_ibu',
        'nama_suami',
        'dusun_id',
        'umur',
        'usia_hamil',
        'kehamilan_ke',
        'jrk_hamil',
        'bb',
        'tb',
        'td',
        'p_resiko',
        'tgl_p_resiko',
        'ket'
    ];

    // public function getId(){
    //     return  DB::table('reg_ibu')->orderBy('id')take-(1)->get;
    // }
    public static function boot(){
        
        parent::boot();
        static::creating(function(Ibu $item){
            $code ='IB';
            $countDataOnTable = Ibu::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT);
            $item->id = $code;
            // $lastId = Ibu::orderBy('id','DESC')->get('id');
            // $newId= 'IB';
            // $lastId =Ibu::withTrashed()->max('id');
            // $idIncremment = substr($lastId,-4);
            // $newId .=str_pad($idIncremment +1, 4, '0', STR_PAD_LEFT);
            // $item->id= $newId;
        });

    }
    public function dusun(){
        return $this->belongsTo(Dusun::class);
    }

    public function kunjunganibu(){
        return $this->hasMany(KunjunganIbu::class);
    }

    public function persalinan(){
        return $this->hasMany(Persalinan::class);
    }

    public function ibumenyusui(){
        return $this->hasMany(IbuMenyusui::class);
    }

}
