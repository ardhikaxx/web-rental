<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'whatsapp',
        'photo',
        'gender',
        'birth_date',
        'address',
        'city',
        'identity_number',
        'notes',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function booted()
    {
        static::creating(function ($user) {
            if ($user->name && $user->phone && ! $user->whatsapp) {
                $user->whatsapp = $user->phone;
            }
        });
    }

    public function getRoleNameAttribute(): string
    {
        return optional($this->roles()->first())->name ?? 'customer';
    }

    public function getAvatarAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        $initial = mb_strtoupper(mb_substr($this->name, 0, 1));
        return 'https://ui-avatars.com/api/?name=' . urlencode($initial) . '&background=4361ee&color=fff';
    }
}