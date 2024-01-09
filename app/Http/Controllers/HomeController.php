<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
   
    public function index()
    {
        $totalProducts = Product::count();
        $totalSales = Sale::count();
        $totalSuppliers = Supplier::count();
        $totalInvoices = Invoice::count();
    
        // Fetch monthly sales data from the sales table
        $monthlySales = Sale::selectRaw('SUM(amount) as total_amount, MONTH(created_at) as month')
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
    
    
        $formattedMonthlySales = [];
        foreach ($monthlySales as $sale) {
            $formattedMonthlySales[] = [
                'month' => \DateTime::createFromFormat('!m', $sale->month)->format('F'), // Format month name
                'total_amount' => (int) $sale->total_amount // Ensure the amount is an integer
            ];
        }
    
        $topSales = Sale::select('product_id', DB::raw('SUM(amount) as total_sales'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();
    
        $formattedTopSales = [];
        foreach ($topSales as $sale) {
            $product = Product::find($sale->product_id);
            if ($product) {
                $formattedTopSales[] = [
                    'productName' => $product->name,
                    'totalSales' => $sale->total_sales,
                ];
            }
        }
    
        // Get today's date and yesterday's date
        $today = Carbon::today()->toDateString();
        $yesterday = Carbon::yesterday()->toDateString();
    
        // Query sales data for today and yesterday
        $todaySales = Sale::whereDate('created_at', $today)->sum('amount');
        $yesterdaySales = Sale::whereDate('created_at', $yesterday)->sum('amount');
    
        // Fetch this week's sales
        $thisWeekSales = Sale::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                            ->sum('amount');
    
        // Fetch last week's sales
        $lastWeekSales = Sale::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])
                            ->sum('amount');
    
        return view('home', [
            'monthlySales' => $formattedMonthlySales,
            'formattedTopSales'=> $formattedTopSales,
            'totalProducts' => $totalProducts,
            'totalSales' => $totalSales,
            'totalSuppliers' => $totalSuppliers,
            'totalInvoices' => $totalInvoices,
            'todaySales' => $todaySales, 
            'yesterdaySales' => $yesterdaySales,
            'thisWeekSales' =>$thisWeekSales,
             'lastWeekSales' =>$lastWeekSales,
        ]);
    }
}
