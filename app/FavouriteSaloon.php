<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class FavouriteSaloon extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'favourite';

    protected $fillable = [
        'id',
        'user_id', 
        'saloon_id', 
        'created_at',
        'updated_at',
    
        ];

        }


