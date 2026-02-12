<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\User;
use App\Models\Rent;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $totalCars = Car::count();
        $totalUsers = User::count();

        $activeRentals = Rent::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where('payement_status', 'payé')
            ->count();

        $pendingRentals = Rent::where('payement_status', 'en attente')->count();

        $totalRevenue = Rent::where('payement_status', 'payé')->sum('total_cost');
        $pendingRevenue = Rent::where('payement_status', 'en attente')->sum('total_cost');

        // Most popular car
        $popularCarId = Rent::select('car_id', DB::raw('count(*) as total'))
            ->groupBy('car_id')
            ->orderByDesc('total')
            ->first();

        $popularCar = null;
        if ($popularCarId) {
            $popularCar = Car::find($popularCarId->car_id);
        }

        // Recent rentals
        $recentRentals = Rent::with(['user', 'car'])->latest()->take(5)->get();

        // Monthly rentals for the current year
        $monthlyRentals = Rent::select(
            DB::raw('count(id) as count'),
            DB::raw("DATE_FORMAT(created_at, '%m') as month_name")
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month_name')
            ->orderBy('month_name')
            ->pluck('count', 'month_name');

        // Monthly revenue for the current year
        $monthlyRevenue = Rent::select(
            DB::raw('sum(total_cost) as total'),
            DB::raw("DATE_FORMAT(created_at, '%m') as month_name")
        )
            ->whereYear('created_at', date('Y'))
            ->where('payement_status', 'payé')
            ->groupBy('month_name')
            ->orderBy('month_name')
            ->pluck('total', 'month_name');

        $labels = [];
        $data = [];
        $revenueData = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $labels[] = Carbon::create()->month($i)->format('F');
            $data[] = $monthlyRentals[$month] ?? 0;
            $revenueData[] = $monthlyRevenue[$month] ?? 0;
        }

        return view('admin.index', compact('totalCars', 'totalUsers', 'activeRentals', 'pendingRentals', 'totalRevenue', 'pendingRevenue', 'popularCar', 'recentRentals', 'labels', 'data', 'revenueData'));
    }
}
