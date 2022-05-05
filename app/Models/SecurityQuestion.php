<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityQuestion extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'question'
    ];

    private static $defaultQuestions = [
        'What is the name of your favorite pet',
        'What is your mother\'s maiden name',
        'What is your favorite sport',
        'What is your favorite online game',
        'What is the name of the city you live in',
        'What is your favorite color',
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public static function getDefaultQuestions()
    {
        return collect(self::$defaultQuestions);
    }
}
