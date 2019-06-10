<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class SaloonMan extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'saloon_man';

    protected $fillable = [
        'id',
        'saloon_id', 
        'service_id', 
        'status',
        'created_at',
        'updated_at',
    
        ];

        }


