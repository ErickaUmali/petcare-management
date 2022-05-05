<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'anonymous',
        'message',
        'stars',
    ];

    private static $defaultFeedbacks = [
        'Staffs are very accomodating. I\'ll rate them 9 out of 10.',
        'Facilities are neat and sanitized. Services are also affordable.',
        'Great service and great doctors!! I have had nothing but good to say about the clinic.. Very compassionate and friendly !!'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getDefaultFeedbacks()
    {
        return collect(self::$defaultFeedbacks);
    }
}
