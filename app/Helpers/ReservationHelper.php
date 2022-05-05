<?php

namespace App\Helpers;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReservationHelper
{
    private static $times = [];

    public function getRandomValidDate()
    {
        $date = Carbon::tomorrow()->addDays(rand(0, 60));
        $reservations = Reservation::where('date', $date)->get();
        $takenTimes = [];

        foreach ($reservations as $reservation) {
            array_push($takenTimes, $reservation['time']);
        }

        self::$times = collect(Reservation::getAvailableTimes())->diff(collect($takenTimes));

        if (self::$times->isEmpty()) {
            return self::getRandomValidDate();
        }

        return $date;
    }

    public function getAvailableTime()
    {
        return collect(self::$times)->random();
    }

    public static function generateUniqueReference()
    {
        do {
            $reference = Str::random(3) . '-' . Str::random(3) . '-' . Str::random(3);
            $reservations = Reservation::where('reference', $reference)->get();
        } while ($reservations->count() > 0);

        return $reference;
    }
}
