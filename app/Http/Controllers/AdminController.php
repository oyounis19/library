<?php

namespace App\Http\Controllers;

use App\Models\DailyStat;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard(){
        $statWeek = DailyStat::whereBetween('date', [Carbon::now()->subWeek(), Carbon::now()]);
        $statMonth = DailyStat::whereBetween('date', [Carbon::now()->subMonth(), Carbon::now()]);
        return view('admin.dashboard', [
            'products' => Product::all(),
            'stat' => DailyStat::where('date', now()->toDateString())->first(),
            'weeklyStat' => $statWeek->sum('total_income') - $statWeek->sum('total_cost'),
            'monthlyStat' => $statMonth->sum('total_income') - $statMonth->sum('total_cost'),
        ]);
    }
}
