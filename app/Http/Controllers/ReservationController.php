<?php

namespace App\Http\Controllers;

use App\Helpers\PDF;
use App\Helpers\ReservationHelper;
use App\Http\Requests\ReservationBetweenRequest;
use App\Http\Requests\ReservationStoreRequest;
use App\Http\Requests\ReservationTakenRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Pet;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['pet', 'doctor', 'appointment'])
            ->where('user_id', auth()->user()->id)->get();

        return view('client.reservations.index')
            ->with('user', auth()->user())
            ->with('reservations', $reservations);
    }

    public function create()
    {
        return view('client.reservations.create')
            ->with('user', auth()->user())
            ->with('pets', Pet::where('user_id', auth()->user()->id)->get())
            ->with('appointments', Appointment::all())
            ->with('doctors', Doctor::all());
    }

    public function store(ReservationStoreRequest $request)
    {
        Reservation::create(array_merge($request->validated(), [
            'user_id' => auth()->user()->id,
            'reference' => ReservationHelper::generateUniqueReference(),
        ]));

        return redirect()->route('reservations.index');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['pet.breed', 'pet.species', 'appointment', 'doctor', 'user']);

        if (auth()->user()->role == 3) {
            return view('client.reservations.show')
                ->with('user', auth()->user())
                ->with('reservation', $reservation);
        }

        return view('admin.reservations.show')
            ->with('user', auth()->user())
            ->with('reservation', $reservation);
    }

    public function update(Reservation $reservation, Request $request)
    {
        $reservation->status = $request->status;
        $reservation->save();
        return redirect()->route('reservations.pending');
    }

    public function pending(Request $request)
    {
        if ($request->has('year_checked') && $request->has('month_checked')) {
            session(['filter' => [
                'year' => [
                    'boolean' => true,
                    'value' => $request->year,
                ],
                'month' => [
                    'boolean' => true,
                    'value' => Reservation::getMonths()[$request->month - 1],
                ],
            ]]);
            return redirect()->route('reservations.pending.yearAndMonth', [
                'year' => $request->year,
                'month' => $request->month,
            ]);
        } else if ($request->has('year_checked')) {
            session(['filter' => [
                'year' => [
                    'boolean' => true,
                    'value' => $request->year,
                ],
                'month' => [
                    'boolean' => false,
                    'value' => '',
                ],
            ]]);
            return redirect()->route('reservations.pending.year', [
                'year' => $request->year,
            ]);
        } else if ($request->has('month_checked')) {
            session(['filter' => [
                'year' => [
                    'boolean' => false,
                    'value' => '',
                ],
                'month' => [
                    'boolean' => true,
                    'value' => Reservation::getMonths()[$request->month - 1],
                ],
            ]]);
            return redirect()->route('reservations.pending.month', [
                'month' => $request->month,
            ]);
        }

        session(['filter' => [
            'year' => [
                'boolean' => false,
                'value' => '',
            ],
            'month' => [
                'boolean' => false,
                'value' => '',
            ],
        ]]);

        $pendingReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 0)->get();
        $reservations = $pendingReservations;

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $pendingReservations]);

        return view('admin.reservations.pending')
            ->with('user', auth()->user())
            ->with('reservations', $pendingReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    public function pendingYear($year, Request $request)
    {
        $pendingReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 0)->get();
        $reservations = $pendingReservations;
        $pendingReservations = $pendingReservations
            ->filter(function ($reservation) use ($request) {
                $date = new Carbon($reservation->date);
                return $date->year == $request->year;
            });

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $pendingReservations]);

        return view('admin.reservations.pending')
            ->with('user', auth()->user())
            ->with('reservations', $pendingReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    public function pendingMonth($month, Request $request)
    {
        $pendingReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 0)->get();
        $reservations = $pendingReservations;
        $pendingReservations = $pendingReservations
            ->filter(function ($reservation) use ($request) {
                $date = new Carbon($reservation->date);
                return $date->month == $request->month;
            });

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $pendingReservations]);

        return view('admin.reservations.pending')
            ->with('user', auth()->user())
            ->with('reservations', $pendingReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    public function pendingYearAndMonth($year, $month, Request $request)
    {
        $pendingReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 0)->get();
        $reservations = $pendingReservations;
        $pendingReservations = $pendingReservations
            ->filter(function ($reservation) use ($request) {
                $date = new Carbon($reservation->date);
                return $date->year == $request->year && $date->month == $request->month;
            });

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $pendingReservations = $pendingReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $pendingReservations]);

        return view('admin.reservations.pending')
            ->with('user', auth()->user())
            ->with('reservations', $pendingReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    //------------------------------------------------------------------
    //------------------------------------------------------------------
    //------------------------------------------------------------------

    public function completed(Request $request)
    {
        if ($request->has('year_checked') && $request->has('month_checked')) {
            session(['filter' => [
                'year' => [
                    'boolean' => true,
                    'value' => $request->year,
                ],
                'month' => [
                    'boolean' => true,
                    'value' => Reservation::getMonths()[$request->month - 1],
                ],
            ]]);
            return redirect()->route('reservations.completed.yearAndMonth', [
                'year' => $request->year,
                'month' => $request->month,
            ]);
        } else if ($request->has('year_checked')) {
            session(['filter' => [
                'year' => [
                    'boolean' => true,
                    'value' => $request->year,
                ],
                'month' => [
                    'boolean' => false,
                    'value' => '',
                ],
            ]]);
            return redirect()->route('reservations.completed.year', [
                'year' => $request->year,
            ]);
        } else if ($request->has('month_checked')) {
            session(['filter' => [
                'year' => [
                    'boolean' => false,
                    'value' => '',
                ],
                'month' => [
                    'boolean' => true,
                    'value' => Reservation::getMonths()[$request->month - 1],
                ],
            ]]);
            return redirect()->route('reservations.completed.month', [
                'month' => $request->month,
            ]);
        }

        session(['filter' => [
            'year' => [
                'boolean' => false,
                'value' => '',
            ],
            'month' => [
                'boolean' => false,
                'value' => '',
            ],
        ]]);

        $completedReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 1)->get();
        $reservations = $completedReservations;

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $completedReservations]);

        return view('admin.reservations.completed')
            ->with('user', auth()->user())
            ->with('reservations', $completedReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    public function completedYear($year, Request $request)
    {
        $completedReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 1)->get();
        $reservations = $completedReservations;
        $completedReservations = $completedReservations
            ->filter(function ($reservation) use ($request) {
                $date = new Carbon($reservation->date);
                return $date->year == $request->year;
            });

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $completedReservations]);

        return view('admin.reservations.completed')
            ->with('user', auth()->user())
            ->with('reservations', $completedReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    public function completedMonth($month, Request $request)
    {
        $completedReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 1)->get();
        $reservations = $completedReservations;
        $completedReservations = $completedReservations
            ->filter(function ($reservation) use ($request) {
                $date = new Carbon($reservation->date);
                return $date->month == $request->month;
            });

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $completedReservations]);

        return view('admin.reservations.completed')
            ->with('user', auth()->user())
            ->with('reservations', $completedReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    public function completedYearAndMonth($year, $month, Request $request)
    {
        $completedReservations = Reservation::with(['user', 'pet', 'doctor', 'appointment'])
            ->where('status', 1)->get();
        $reservations = $completedReservations;
        $completedReservations = $completedReservations
            ->filter(function ($reservation) use ($request) {
                $date = new Carbon($reservation->date);
                return $date->year == $request->year && $date->month == $request->month;
            });

        if ($request->has('sort_by')) {
            if ($request->sort_by == 'latest') {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
            } else {
                $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR);
            }
        } else {
            $completedReservations = $completedReservations->sortBy('date', SORT_REGULAR, true);
        }

        session(['reservations' => $completedReservations]);

        return view('admin.reservations.completed')
            ->with('user', auth()->user())
            ->with('reservations', $completedReservations)
            ->with('months', Reservation::getMonths())
            ->with('years', $reservations
                ->pluck('date')
                ->map(function ($date) {
                    $carbon = new Carbon($date);
                    return $carbon->year;
                })->unique())
            ->with('earliest', $request->has('sort_by') && $request->sort_by == 'earliest');
    }

    public function pendingPrint()
    {
        $reservations = session('reservations');
        $filter = session('filter');
        $headerDetails = ['Owner', 'Pet', 'Species', 'Date', 'Time'];
        $pdf = new PDF();

        if ($filter['year']['boolean'] == true && $filter['month']['boolean'] == true) {
            $title = "Pending Reservations for {$filter['month']['value']} {$filter['year']['value']}";
        } else if ($filter['year']['boolean'] == true && $filter['month']['boolean'] == false) {
            $title = "Pending Reservations for {$filter['year']['value']}";
        } else if ($filter['year']['boolean'] == false && $filter['month']['boolean'] == true) {
            $title = "Pending Reservations for {$filter['month']['value']}";
        } else {
            $title = "Pending Reservations";
        }

        $pdf->AddPage();
        $pdf->addTitle('Web-based Pet Care Online Reservation and Appointment Scheduling: A Veterinary Application');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetTextColor(82, 73, 79);
        $pdf->MultiCell(0, 0, $title);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(0, 26, 255);

        foreach ($headerDetails as $detail) {
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, $detail, 0, 0, 'C', true);
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(64, 64, 64);
        foreach ($reservations as $reservation) {
            $pdf->Ln(10);
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, "{$reservation->user->firstname} {$reservation->user->lastname}", 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, $reservation->pet->name, 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, ucwords(explode('/', $reservation->pet->species->name)[0]) . '/' . ucwords(explode('/', $reservation->pet->species->name)[1]), 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, Carbon::parse($reservation->date)->toFormattedDateString(), 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, $reservation->time, 0, 0, 'C');
        }
        // $pdf->Cell(20, 6, , 1, 0, 'C', true);

        $pdf->Output('D', 'pending_transactions.pdf');
    }

    public function completedPrint()
    {
        $reservations = session('reservations');
        $filter = session('filter');
        $headerDetails = ['Owner', 'Pet', 'Species', 'Date', 'Time'];
        $pdf = new PDF();

        if ($filter['year']['boolean'] == true && $filter['month']['boolean'] == true) {
            $title = "Completed Reservations for {$filter['month']['value']} {$filter['year']['value']}";
        } else if ($filter['year']['boolean'] == true && $filter['month']['boolean'] == false) {
            $title = "Completed Reservations for {$filter['year']['value']}";
        } else if ($filter['year']['boolean'] == false && $filter['month']['boolean'] == true) {
            $title = "Completed Reservations for {$filter['month']['value']}";
        } else {
            $title = "Completed Reservations";
        }

        $pdf->AddPage();
        $pdf->addTitle('Web-based Pet Care Online Reservation and Appointment Scheduling: A Veterinary Application');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetTextColor(82, 73, 79);
        $pdf->MultiCell(0, 0, $title);
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 13);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(0, 26, 255);

        foreach ($headerDetails as $detail) {
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, $detail, 0, 0, 'C', true);
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(64, 64, 64);
        foreach ($reservations as $reservation) {
            $pdf->Ln(10);
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, "{$reservation->user->firstname} {$reservation->user->lastname}", 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, $reservation->pet->name, 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, ucwords(explode('/', $reservation->pet->species->name)[0]) . '/' . ucwords(explode('/', $reservation->pet->species->name)[1]), 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, Carbon::parse($reservation->date)->toFormattedDateString(), 0, 0, 'C');
            $pdf->Cell($pdf->GetPageWidth() / 5 - 4, 8, $reservation->time, 0, 0, 'C');
        }

        $pdf->Output('D', 'completed_transactions.pdf');
    }

    public function print(Reservation $reservation)
    {
        switch (auth()->user()->role) {
            case 1:
                $label = 'Admin Copy';
                $output = 'petcare_transaction_admin_copy.pdf';
                break;
            case 2:
                $label = 'Staff Copy';
                $output = 'petcare_transaction_staff_copy.pdf';
                break;
            case 3:
                $label = 'Client Copy';
                $output = 'petcare_transaction_client_copy.pdf';
                break;
        }

        $reservation->load(['pet.breed', 'pet.species', 'appointment', 'doctor', 'user']);
        $pdf = new PDF();

        $species = ucwords(explode('/', $reservation->pet->species->name)[0]) . '/' . ucwords(explode('/', $reservation->pet->species->name)[1]);
        if (str_contains($reservation->pet->breed->name, '/')) {
            $breed = ucwords(strtolower(explode('/', $reservation->pet->breed->name)[0])) . '/' . ucwords(strtolower(explode('/', $reservation->pet->breed->name)[1]));
        } else {
            $breed = ucwords(strtolower($reservation->pet->breed->name));
        }
        $date = Carbon::parse($reservation->date)->toFormattedDateString();
        if ($reservation->status == 0) {
            $status = 'Pending';
        } elseif ($reservation->status == 1) {
            $status = 'Completed';
        } elseif ($reservation->status == 2) {
            $status = 'Cancelled';
        } elseif ($reservation->status == 3) {
            $status = 'Did not arrive';
        }

        $pdf->AddPage('P', [180, 180]);
        $pdf->addTitle('Web-based Pet Care Online Reservation and Appointment Scheduling: A Veterinary Application');
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->SetTextColor(50, 69, 43);
        $pdf->MultiCell(0, 10, $label);
        $pdf->Ln(5);

        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTextColor(64, 64, 64);

        $pdf->SetFillColor(232, 237, 255);

        if (auth()->user()->role == 1 || auth()->user()->role == 2) {
            $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Owner name:", 0, 0, 'L', true);
            $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $reservation->user->firstname . ' ' . $reservation->user->lastname, 0, 0, 'L', true);
            $pdf->Ln(8);

            $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Contact:", 0, 0, 'L');
            $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $reservation->user->contact, 0, 0, 'L');
            $pdf->Ln(8);
        }

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Pet name:", 0, 0, 'L', true);
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $reservation->pet->name, 0, 0, 'L', true);
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Species:", 0, 0, 'L');
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $species, 0, 0, 'L');
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Breed:", 0, 0, 'L', true);
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $breed, 0, 0, 'L', true);
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Appointment:", 0, 0, 'L');
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $reservation->appointment->name, 0, 0, 'L');
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Doctor:", 0, 0, 'L', true);
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $reservation->doctor->name, 0, 0, 'L', true);
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Date:", 0, 0, 'L');
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $date, 0, 0, 'L');
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Time:", 0, 0, 'L', true);
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $reservation->time, 0, 0, 'L', true);
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Status:", 0, 0, 'L');
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $status, 0, 0, 'L');
        $pdf->Ln(8);

        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, "Reference:", 0, 0, 'L', true);
        $pdf->Cell($pdf->GetPageWidth() / 2 - 10, 8, $reservation->reference, 0, 0, 'L', true);
        $pdf->Ln(8);

        $pdf->Output('D', $output);
    }

    public function taken(ReservationTakenRequest $request)
    {
        return Reservation::where('date', $request->date)->get();
    }

    public function times()
    {
        return Reservation::getAvailableTimes();
    }

    public function between(ReservationBetweenRequest $request)
    {
        $minDate = new Carbon($request->min);
        $maxDate = new Carbon($request->max);

        $reservations = Reservation::select('id', 'date')
            ->whereBetween('date', [$minDate->toDateString(), $maxDate->toDateString()])->get();

        return $reservations->map(function ($reservation) {
            return $reservation->date;
        });
    }
}
