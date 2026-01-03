<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'avatar',
        'preferred_language',
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

    /**
     * Check if admin is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if admin has specific role
     */
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Get admin's initials for avatar
     */
    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
        }
        
        return $initials;
    }

    /**
     * Get tickets assigned to this admin.
     */
    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_admin_id');
    }

    /**
     * Get ticket replies by this admin.
     */
    public function ticketReplies()
    {
        return $this->hasMany(TicketReply::class, 'admin_id');
    }
}