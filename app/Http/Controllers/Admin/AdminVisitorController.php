<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class AdminVisitorController extends Controller
{
    /**
     * Display a listing of the visitors.
     */
    public function index()
    {
        $today = now()->startOfDay();
        
        $visitorsToday = Visitor::where('created_at', '>=', $today)->count();
        $visitorsYesterday = Visitor::whereBetween('created_at', [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()])->count();
        
        $topCountries = Visitor::select('country', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('country')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $visitors = Visitor::latest()->paginate(50);
        return view('admin.visitors.index', compact('visitors', 'visitorsToday', 'visitorsYesterday', 'topCountries'));
    }

    /**
     * Delete all visitor records.
     */
    public function deleteAll()
    {
        Visitor::truncate();
        
        return redirect()->route('admin.visitors.index')->with('success', 'All visitor records have been deleted successfully.');
    }
}
