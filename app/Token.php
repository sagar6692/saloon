<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class Token extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'token';

    protected $fillable = [
        'id',
        'token_no', 
        'user_id', 
        'created_at',
        'updated_at',
    
        ];
 
    }

