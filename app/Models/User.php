<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

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
        'email',
        'password',
        'class_id',
        'role',
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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function oralTestScores()
    {
        return $this->hasMany(Point::class)->where('type', 'Kiểm tra miệng');
    }

    public function quizScores()
    {
        return $this->hasMany(Point::class)->where('type', 'Kiểm tra 15 phút');
    }

    public function midtermTestScores()
    {
        return $this->hasMany(Point::class)->where('type', 'Kiểm tra 45 phút');
    }

    public function finalTestScores()
    {
        return $this->hasMany(Point::class)->where('type', 'Kiểm tra học kì');
    }
}
