<?php

namespace App;
//use Laravel\Passport\HasApiTokens;
//use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
//use Illuminate\Database\Eloquent\Model;

class RegistrationSaloon extends Authenticatable
{
   // use HasApiTokens, Notifiable;

   public $table = 'registration_saloon';

    protected $fillable = [
        'id',
        'name', 
        'address', 
        'pincode    ', 
        'mobile_no',
        'longitude',
        'latitude',
        'saloon_number',
        'contact_number',
        'email',
        'no_of_seats',
        'type',
        'logo',
        'banner1',
        'banner2',
        'banner3',
        'contact_person_name',
        'created_at',
        'updated_at',
        'otp',
        'status',
        'is_email_verify',
        'remember_token',

        ];
        /**
        * The attributes that should be hidden for arrays.
        *
        * @var array
        */
        protected $hidden = [
        'password', 'remember_token','verification_code',
        ];
        }
    //

