<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'status',
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
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        // Prefer new `role` column when present; fall back to legacy `is_admin` flag
        if (property_exists($this, 'role') && !empty($this->role)) {
            return $this->role === 'admin' || ($this->is_admin ?? false) === true;
        }

        return ($this->is_admin ?? false) === true;
    }

    /**
     * Check if user is customer
     */
    public function isCustomer()
    {
        return !$this->isAdmin();
    }

    /**
     * Check if user is banned
     */
    public function isBanned()
    {
        return $this->status === 'banned';
    }

    /**
     * Check if user is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
