<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'role',
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

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'nip', 'username');
    }

    public function admin()
    {
        return $this->hasOne(Admin::class, 'username_admin', 'username');
    }

    public function getNameAttribute(): string
    {
        return $this->role === 'dosen'
            ? ($this->dosen?->nama ?? $this->username)
            : ($this->admin?->username_admin ?? $this->username);
    }

    public function getEmailAttribute(): ?string
    {
        return $this->role === 'dosen'
            ? $this->dosen?->email
            : $this->admin?->email;
    }
}
