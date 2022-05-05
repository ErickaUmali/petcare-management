<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetUpdateRequest;
use App\Models\Breed;
use App\Models\Pet;
use App\Models\Species;
use Exception;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        return view('pets.index')
            ->with('user', auth()->user())
            ->with('pets', Pet::with('breed', 'species')->where('user_id', auth()->user()->id)->get());
    }

    public function create()
    {
        return view('pets.create')
            ->with('user', auth()->user())
            ->with('genders', Pet::getGenders())
            ->with('species', Species::all())
            ->with('breeds', Breed::where('species_id', 1)->get());
    }

    public function store(PetStoreRequest $request)
    {
        try {
            $totalExistingPets = Pet::where(array_merge($request->validated(), [
                'user_id' => auth()->user()->id,
            ]))->get()->count();

            if ($totalExistingPets > 0) {
                return redirect()
                    ->back()->withInput()
                    ->withErrors(['name' => 'Pet already exists.']);
            }

            if ($request->has('marking') && strlen($request->marking) > 0) {
                $pet = Pet::create(array_merge($request->validated(), [
                    'user_id' => auth()->user()->id,
                    'marking' => $request->marking,
                ]));
            } else {
                $pet = Pet::create(array_merge($request->validated(), [
                    'user_id' => auth()->user()->id,
                ]));
            }

            if ($pet) {
                return redirect()->route('pets.index');
            }
        } catch (Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()]);
        }
    }

    public function update(Pet $pet, PetUpdateRequest $request)
    {
        $pet->profile = $request->file('profile')->store('public/profiles/pet');
        $pet->save();
        return redirect()->route('pets.show', $pet->id);
    }

    public function show(Pet $pet)
    {
        $pet->load(['breed', 'species']);
        return view('pets.show')
            ->with('user', auth()->user())
            ->with('pet', $pet);
    }

    public function breeds(Request $request)
    {
        return Breed::where('species_id', $request->species_id)->get();
    }

    public function profile(Request $request)
    {
        return Pet::where('id', $request->id)->first();
    }
}
