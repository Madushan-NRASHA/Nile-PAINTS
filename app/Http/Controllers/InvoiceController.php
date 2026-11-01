<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    // දත්ත ගබඩා කිරීමේ ක්‍රියාවලිය (Store Method)
    public function store(Request $request)
    {
        // 1. Validation නීති (Validation Rules)
        $validatedData = $request->validate([
            // Customer Validation
            'customer_name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'contact_no' => 'required|string|max:20',

            // Item Validation (නව අයිතමයක් නම් හෝ පවතින එකක් නම්)
            'item_name' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'qty' => 'required|integer|min:1',

            // Invoice Validation
            'date' => 'required|date',
        ]);

        DB::transaction(function () use ($validatedData) {
            $customer = Customer::firstOrCreate(
                ['contact_no' => $validatedData['contact_no']],
                [
                    'name' => $validatedData['customer_name'],
                    'address' => $validatedData['address'] ?? null,
                ]
            );

            $item = Item::create([
                'item_name' => $validatedData['item_name'],
                'unit_price' => $validatedData['unit_price'],
                'qty' => $validatedData['qty'],
            ]);

            $totalAmount = $validatedData['qty'] * $validatedData['unit_price'];

            Invoice::create([
                'cus_id' => $customer->id,
                'item_name' => $item->item_name,
                'date' => $validatedData['date'],
                'qty' => $validatedData['qty'],
                'unit_price' => $validatedData['unit_price'],
                'total_amount' => $totalAmount,
            ]);
        });

        return redirect()->route('home')->with('success', 'Invoice created successfully.');
    }

    public function downloadPDF($id)
    {
        $invoice = Invoice::with('customer')->findOrFail($id);

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download('invoice-'.$invoice->id.'.pdf');
    }
}
