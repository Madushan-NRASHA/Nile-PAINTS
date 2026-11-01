<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Item;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $thisMonth = now()->startOfMonth()->toDateString();

        return view('dashboard', [
            'invoiceCount' => Invoice::count(),
            'customerCount' => Customer::count(),
            'totalRevenue' => Invoice::sum('total_amount'),
            'monthRevenue' => Invoice::whereDate('date', '>=', $thisMonth)
                ->whereDate('date', '<=', now()->toDateString())
                ->sum('total_amount'),
            'recentInvoices' => Invoice::with('customer')
                ->orderByDesc('date')
                ->orderByDesc('id')
                ->limit(8)
                ->get(),
            'recentCustomers' => Customer::withCount('invoices')
                ->orderByDesc('id')
                ->limit(8)
                ->get(),
            'recentItems' => Item::orderByDesc('id')
                ->limit(8)
                ->get(),
        ]);
    }
}
