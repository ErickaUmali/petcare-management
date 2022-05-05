<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'pet_id',
        'doctor_id',
        'appointment_id',
        'status',
        'date',
        'time',
        'reference',
    ];

    private static $times = [
        '7:00 am - 8:00 am',
        '8:00 am - 9:00 am',
        '9:00 am - 10:00 am',
        '10:00 am - 11:00 am',
        '11:00 am - 12:00 pm',
        '1:00 pm - 2:00 pm',
        '2:00 pm - 3:00 pm',
        '3:00 pm - 4:00 pm',
        '4:00 pm - 5:00 pm',
        '5:00 pm - 6:00 pm',
    ];

    private static $months = [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ];

    private static $reservationLimit = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public static function getAvailableTimes()
    {
        return collect(self::$times);
    }


    public static function getMinDate()
    {
        return Carbon::tomorrow()->toDateString();
    }

    public static function getMaxDate()
    {
        return Carbon::tomorrow()->addDays(rand(60))->toDateString();
    }

    public static function getReservationLimit()
    {
        return self::$reservationLimit;
    }

    public static function getMonths()
    {
        return collect(self::$months);
    }
}
