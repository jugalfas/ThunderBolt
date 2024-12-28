<?php

namespace App\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasName
{
    use HasFactory, Notifiable, SoftDeletes, CanResetPassword, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'public_name',
        'email',
        'password',
        'address',
        'date_of_birth',
        'gender',
        'profile_image',
        'phone_number',
        'role'
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
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'date_of_birth' => 'date',
    ];

    /**
     * The attributes that should be appended to model's JSON form.
     *
     * @var array
     */
    protected $appends = [
        // Optional: if you want to calculate a virtual attribute like full name
        // 'full_name',
    ];

    /**
     * Accessor for full name (optional).
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFilamentName(): string
    {
        return $this->getAttributeValue('public_name');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function scopeWithFullName($query)
    {
        return $query->selectRaw('CONCAT(first_name, " ", last_name) as full_name, id');
    }
}
