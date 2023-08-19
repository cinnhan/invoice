<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable implements JWTSubject
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable;

    protected $table = 'invoice_accounts';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
