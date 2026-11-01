<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 14px; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { font-size: 24px; font-weight: bold; margin-bottom: 20px; color: #4F46E5; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .total { font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">NILE PAINTS - INVOICE</div>
        
        <p><strong>Invoice No:</strong> #{{ $invoice->id }}</p>
        <p><strong>Date:</strong> {{ $invoice->date }}</p>
        
        <hr>

        <h3>Customer Details</h3>
        <p><strong>Name:</strong> {{ $invoice->customer->name }}</p>
        <p><strong>Address:</strong> {{ $invoice->customer->address }}</p>
        <p><strong>Contact No:</strong> {{ $invoice->customer->contact_no }}</p>

        <h3>Purchased Items</h3>
        <table>
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Unit Price (LKR)</th>
                    <th>Total (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->item_name }}</td>
                    <td>{{ $invoice->qty }}</td>
                    <td>{{ number_format($invoice->unit_price, 2) }}</td>
                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <h3 style="text-align: right; margin-top: 30px;">
            Total Amount: LKR {{ number_format($invoice->total_amount, 2) }}
        </h3>
    </div>
</body>
</html>