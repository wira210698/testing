<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anak extends Model
{
    use SoftDeletes;
    protected $table ='reg_anak';
    public $autoincrement =false;
    public $incrementing = false;
    protected $fillable = [
        'NIK',
        'nama_ibu',
        'nama_anak',
        'status',
        'tgl_lahir',
        'umur',
        'dusun_id',
        'jk',
        'buku_KIA',
        'ket'
    ];

    public static function boot(){
        
        parent::boot();
        static::creating(function(Anak $item){
            $code ='AK';
            $countDataOnTable = Anak::withTrashed()->count();
            $code.=str_pad($countDataOnTable,4,'0',STR_PAD_LEFT);
            $item->id = $code;
        });
    }

    public function dusun(){
        return $this->belongsTo(Dusun::class);
    }

    public function kunjungananak(){
        return $this->hasMany(KunjunganAnak::class);
    }

    public function prasekolah(){
        return $this->hasMany(Prasekolah::class);
    }
    public function kematiananak(){
        return $this->hasOne(KematianAnak::class);
    }
    public function kondisilahir(){
        return $this->hasOne(KondisiLahir::class);
    }
    public function imunisasi(){
        return $this->belongsToMany(Imunisasi::class)->withPivot(['tgl_kunjungan'])->whereNull('anak_imunisasi.deleted_at')->withTimeStamps();
    }

    
}
