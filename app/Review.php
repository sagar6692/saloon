<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class Review extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'review';

    protected $fillable = [
        'id',
        'user_id',
        'saloon_id', 
        'review_no', 
        'comments', 
        'created_at',
        'updated_at',
    
        ];

        }
  

