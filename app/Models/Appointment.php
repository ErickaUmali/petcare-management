<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
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

    private static $defaultAppointments = [
        'Consultation',
        'Grooming',
        'Deworming',
        'Anti-Rabies',
        'Vaccination',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public static function getDefaultAppointments()
    {
        return collect(self::$defaultAppointments);
    }
}
