<?php

namespace App\Models;

use App\Helpers\UserHelper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'profile',
        'firstname',
        'lastname',
        'contact',
        'username',
        'password',
        'security_question_id',
        'answer',
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

    private static $roles = [1, 2, 3];
    private static $defaultPassword = 'admin123';

    public static function getRandomRole()
    {
        return collect(self::$roles)->random();
    }

    public static function getDefaultPassword()
    {
        return bcrypt(self::$defaultPassword);
    }

    public static function getRandomContact()
    {
        return '09' . UserHelper::numbers(9);
    }

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function securityQuestion()
    {
        return $this->belongsTo(SecurityQuestion::class);
    }
}
