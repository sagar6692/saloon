<?php
namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable
{
  use HasApiTokens, Notifiable;
/**
* The attributes that are mass assignable.
*
* @var array
*/
        protected $fillable = [
        'id',
        'user_type',
        'first_name', 
        'last_name', 
        'mobile_no',
        'password',
        'email',
        'api_token',
        'is_email_verify',
        'is_mobile_verify',
        'otp_password',
        'is_delete',
        'is_active',
        'otp',
        'status',
        'created_at',
        'updated_at',
        ];
        /**
        * The attributes that should be hidden for arrays.
        *
        * @var array
        */
        protected $hidden = [
        'password', 'remember_token','verification_code','user_type'
        ];
        }