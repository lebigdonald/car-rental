<?php

namespace App\Http\Controllers;

use App\Http\Requests\RentMakingRequest;
use App\Http\Requests\RentUpdateRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rent;
use Carbon\Carbon;
use App\Models\Car;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\RentApproved;
use App\Mail\RentRejected;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            $rents = Rent::with(['car', 'user'])->latest()->paginate(15);
            return view('admin.rents', compact('rents'));
        } else {
            $rents = Rent::with('car')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
            return view('rents')->with(compact('rents'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RentMakingRequest $request, $id)
    {
        $car = Car::findOrFail($id);

        $validatedData = $request->validated();

        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);

        // Check if the car is available for the selected dates
        // Only check against active rentals (not cancelled ones)
        $conflictingRent = Rent::where('car_id', $id)
            ->where('payement_status', '!=', 'annulé')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($query) use ($startDate, $endDate) {
                          $query->where('start_date', '<', $startDate)
                                ->where('end_date', '>', $endDate);
                      });
            })->exists();

        if ($conflictingRent) {
            return redirect()->back()->withErrors(['message' => 'Cette voiture n\'est pas disponible pour la période sélectionnée.']);
        }

        $rent = new Rent();
        $rent->start_date = $validatedData['start_date'];
        $rent->end_date = $validatedData['end_date'];
        $rent->payement_method = $validatedData['payement_method'];

        $nbDay = $endDate->diffInDays($startDate);
        if ($nbDay == 0) {
            $nbDay = 1;
        }

        $rent->total_cost = $nbDay * $car->daily_rate;
        $rent->payement_status = "en attente";
        $rent->car_id = $id;
        $rent->user_id = Auth::id();
        $rent->save();

        return redirect()->back()->with('success', "Vous venez de louez la voiture pour à " . $rent->total_cost . " FCFA pour " . $nbDay . " jours");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rent = Rent::with(['car', 'user'])->findOrFail($id);

        if (Auth::guard('admin')->check()) {
            return view('admin.rent-details', ['rent' => $rent]);
        } else {
            // Ensure the user owns the rent
            if ($rent->user_id !== Auth::id()) {
                abort(403);
            }
            return view('rents'); // This view seems to list rents, maybe it should be a detail view? Keeping as is for now.
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rent = Rent::with('car')->findOrFail($id);

        if (Auth::guard('admin')->check()) {
            return view('admin.rent-edit', ['rent' => $rent]);
        } else {
            return redirect()->route('rent.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RentUpdateRequest $request, string $id)
    {
        $rent = Rent::findOrFail($id);
        $validatedData = $request->validated();

        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);

        // Check for availability if dates changed
        if ($startDate->ne($rent->start_date) || $endDate->ne($rent->end_date)) {
            $conflictingRent = Rent::where('car_id', $rent->car_id)
                ->where('id', '!=', $rent->id) // Exclude the current rental
                ->where('payement_status', '!=', 'annulé')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                          ->orWhereBetween('end_date', [$startDate, $endDate])
                          ->orWhere(function ($query) use ($startDate, $endDate) {
                              $query->where('start_date', '<', $startDate)
                                    ->where('end_date', '>', $endDate);
                          });
                })->exists();

            if ($conflictingRent) {
                return redirect()->back()->withErrors(['message' => 'Cette voiture n\'est pas disponible pour la période sélectionnée.']);
            }

            // Recalculate total cost
            $nbDay = $endDate->diffInDays($startDate);
            if ($nbDay == 0) {
                $nbDay = 1;
            }
            $rent->total_cost = $nbDay * $rent->car->daily_rate;
        }

        $rent->start_date = $validatedData['start_date'];
        $rent->end_date = $validatedData['end_date'];
        $rent->payement_status = $validatedData['payement_status'];
        $rent->payement_method = $validatedData['payement_method'];
        $rent->save();

        return redirect()->route('admin.rent.index')->with('success', 'La location a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rent = Rent::findOrFail($id);

        if (Auth::guard('admin')->check()) {
            $rent->delete();
            return redirect()->route('admin.rent.index')->with('success', 'La location a été supprimée avec succès.');
        } else {
            // Allow user to cancel if it's their rent and maybe pending?
            if ($rent->user_id === Auth::id()) {
                $rent->payement_status = 'annulé';
                $rent->save();
                return redirect()->route('rent.index')->with('success', 'La location a été annulée.');
            }
            return redirect()->route('rent.index');
        }
    }

    public function approve($id)
    {
        $rent = Rent::with('user', 'car')->findOrFail($id);
        $rent->payement_status = 'payé';
        $rent->save();

        try {
            Mail::to($rent->user->email)->send(new RentApproved($rent));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back()->with('success', 'La location a été approuvée et l\'email a été envoyé.');
    }

    public function reject($id)
    {
        $rent = Rent::with('user', 'car')->findOrFail($id);
        $rent->payement_status = 'annulé';
        $rent->save();

        try {
            Mail::to($rent->user->email)->send(new RentRejected($rent));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return redirect()->back()->with('success', 'La location a été rejetée et l\'email a été envoyé.');
    }

    public function invoice($id)
    {
        $rent = Rent::with(['car', 'user'])->findOrFail($id);

        if (!Auth::guard('admin')->check() && $rent->user_id !== Auth::id()) {
            abort(403);
        }

        if ($rent->payement_status !== 'payé') {
            return redirect()->back()->withErrors(['message' => 'La facture n\'est disponible que pour les locations payées.']);
        }

        return view('invoice', compact('rent'));
    }
}
