<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'species_id',
        'breed_id',
        'name',
        'profile',
        'birthday',
        'gender',
        'marking',
    ];

    private static $genders = ['male', 'female'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public static function getRandomGender()
    {
        return collect(self::$genders)->random();
    }

    public static function getGenders()
    {
        return self::$genders;
    }

    public static function getRandomBirthday()
    {
        return Carbon::now()->subDays(rand(14, (365 * rand(1, 8))))->toDateString();
    }
}
