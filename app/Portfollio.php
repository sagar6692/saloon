<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class Portfollio extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'portfolio';

    protected $fillable = [
        'id',
        'user_id',
        'photo', 
        'created_at',
        'updated_at',
    
        ];

        }


