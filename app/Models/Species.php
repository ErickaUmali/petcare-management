<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    private static $defaultSpecies = [
        'canine/dog',
        'feline/cat'
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    public function breeds()
    {
        return $this->hasMany(Breed::class);
    }

    public static function getRandomSpecies()
    {
        return collect(self::$defaultSpecies);
    }
}
