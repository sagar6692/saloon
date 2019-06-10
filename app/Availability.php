<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class Availability extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'availability';

    protected $fillable = [
        'id',
        'user_id', 
        'date', 
        'reason', 
        'created_at',
        'updated_at',
    
        ];
 
        }


