<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public $autoincrement =false;
    public $incrementing = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'alamat','no_identitas', 'telp','image','role_id','username', 'password',
    ];
    public static function boot(){
        
        parent::boot();
        static::creating(function(User $item){
            // $code ='USR';
            // $countDataOnTable = user::count();
            // $code.=str_pad($countDataOnTable,2,'0',STR_PAD_LEFT);
            // $item->id = $code;
            $lastId = User::orderBy('id','DESC')->get('id');
            $newId= 'USR';
            $lastId =User::max('id');
            $idIncremment = substr($lastId,-2);
            $newId .=str_pad($idIncremment +1, 2, '0', STR_PAD_LEFT);
            $item->id= $newId;
        });

    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
