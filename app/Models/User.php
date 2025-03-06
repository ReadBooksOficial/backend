<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'pacoca'; // Define a conexão do sistema A
    protected $table = 'users';         // Define a tabela de usuários do sistema A

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'user_name',
        'email', 'phone',
        'password',
        'site',
        'biography',
        'sexo',
        'birth_date',
        'reset_password_token',
        'next_payment',
        'verified_profile',
        'readbook_user_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey(); // Retorna a chave primária do usuário
    }

    // Método requerido pela interface JWTSubject
    public function getJWTCustomClaims()
    {
        return []; // Você pode retornar um array de claims personalizados, se necessário
    }
}
