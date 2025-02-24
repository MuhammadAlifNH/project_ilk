<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'profile',
        'name',
        'role',
        'email',
        'password',
        'phone',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : asset('images/profile-placeholder.png');
    }


    /**
     * Relasi: User memiliki banyak Fakultas
     */
    public function fakultas()
    {
        return $this->hasMany(Fakultas::class);
    }

    /**
     * Relasi: User memiliki banyak Labs
     */
    public function labs()
    {
        return $this->hasMany(Labs::class);
    }

    /**
     * Relasi: User memiliki banyak Perkeras
     */
    public function perkeras()
    {
        return $this->hasMany(Perkeras::class);
    }

    /**
     * Relasi: User memiliki banyak Perlunak
     */
    public function perlunak()
    {
        return $this->hasMany(Perlunak::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
    
    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }
}
