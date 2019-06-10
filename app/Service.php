<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class Service extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'service';

    protected $fillable = [
        'id',
        'name', 
        'created_at',
        'updated_at',
    
        ];
        }


