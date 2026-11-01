<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f6f2">
    <title>Dashboard | Nile Paints</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: #192c26;
            background: #f5f6f2;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            --green: #264c3b;
            --muted: #849088;
            --line: #e9ece6;
        }

        * { box-sizing: border-box; }
        body { min-width: 320px; min-height: 100vh; margin: 0; }
        button, input, textarea { font: inherit; }
        button, a { -webkit-tap-highlight-color: transparent; }

        .app-shell { min-height: 100vh; }
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 5;
            width: 248px;
            display: flex;
            flex-direction: column;
            padding: 28px 18px 20px;
            color: #fff;
            background: #173832;
        }

        .brand { display: flex; align-items: center; gap: 12px; padding: 0 9px; color: inherit; text-decoration: none; }
        .brand-mark {
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255,255,255,.3);
            border-radius: 12px;
            color: #d9e7a6;
            font-size: 17px;
            font-weight: 800;
        }

        .brand-name { display: block; font-size: 13px; font-weight: 750; letter-spacing: .12em; }
        .brand-caption { display: block; margin-top: 4px; color: rgba(255,255,255,.55); font-size: 9px; letter-spacing: .18em; }
        .nav-label { margin: 48px 10px 12px; color: rgba(255,255,255,.42); font-size: 9px; font-weight: 700; letter-spacing: .17em; text-transform: uppercase; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 13px; border-radius: 9px; color: rgba(255,255,255,.7); font-size: 12px; font-weight: 600; text-decoration: none; }
        .nav-link svg { flex: 0 0 auto; opacity: .78; }
        .nav-link.active { color: #fff; background: rgba(255,255,255,.12); }
        .sidebar-note { margin-top: auto; padding: 16px; border: 1px solid rgba(255,255,255,.13); border-radius: 12px; background: rgba(255,255,255,.05); }
        .sidebar-note-title { margin: 0 0 6px; color: #e3ebc9; font-size: 11px; font-weight: 700; }
        .sidebar-note p { margin: 0; color: rgba(255,255,255,.57); font-size: 10px; line-height: 1.6; }
        .sidebar-footer { display: flex; align-items: center; gap: 10px; margin-top: 18px; padding: 4px 3px; }
        .avatar { width: 34px; height: 34px; display: grid; flex: 0 0 auto; place-items: center; border-radius: 50%; color: #1f4534; background: #dbe7bd; font-size: 12px; font-weight: 750; }
        .user-info { min-width: 0; flex: 1; }
        .user-name { overflow: hidden; color: #fff; font-size: 11px; font-weight: 650; text-overflow: ellipsis; white-space: nowrap; }
        .user-role { margin-top: 3px; color: rgba(255,255,255,.5); font-size: 10px; }
        .logout-button { display: grid; width: 32px; height: 32px; place-items: center; border: 0; border-radius: 8px; color: rgba(255,255,255,.67); background: transparent; cursor: pointer; }
        .logout-button:hover { color: #fff; background: rgba(255,255,255,.1); }

        .main { min-height: 100vh; margin-left: 248px; }
        .topbar { height: 76px; display: flex; align-items: center; justify-content: space-between; padding: 0 44px; border-bottom: 1px solid var(--line); background: rgba(255,255,255,.8); }
        .breadcrumb { color: #8a958e; font-size: 11px; }
        .breadcrumb strong { color: #34463e; font-weight: 650; }
        .topbar-date { color: #78847c; font-size: 11px; }
        .content { width: min(1220px, 100%); margin: 0 auto; padding: 38px 44px 52px; }
        .welcome-row { display: flex; align-items: flex-end; justify-content: space-between; gap: 20px; margin-bottom: 29px; }
        .welcome-kicker { margin: 0 0 9px; color: #728078; font-size: 11px; }
        .welcome-title { margin: 0; font-family: Georgia, "Times New Roman", serif; font-size: 34px; font-weight: 400; letter-spacing: -.045em; }
        .welcome-subtitle { margin: 8px 0 0; color: #87918b; font-size: 12px; }
        .primary-button { min-height: 42px; display: inline-flex; align-items: center; justify-content: center; gap: 9px; padding: 0 16px; border: 0; border-radius: 8px; color: #fff; background: var(--green); cursor: pointer; font-size: 11px; font-weight: 700; text-decoration: none; transition: background .15s, transform .15s; }
        .primary-button:hover { transform: translateY(-1px); background: #193d2c; }
        .primary-button:focus-visible, .logout-button:focus-visible, .download-link:focus-visible, .modal-close:focus-visible { outline: 3px solid #9ab879; outline-offset: 3px; }

        .flash { margin: 0 0 20px; padding: 12px 15px; border: 1px solid #cfe5d4; border-radius: 9px; color: #285c38; background: #f0f8f1; font-size: 12px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 16px; margin-bottom: 25px; }
        .stat-card { min-height: 145px; padding: 20px 21px; border: 1px solid var(--line); border-radius: 12px; background: #fff; }
        .stat-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .stat-label { color: #7d8981; font-size: 11px; font-weight: 550; }
        .stat-icon { width: 32px; height: 32px; display: grid; place-items: center; border-radius: 9px; color: #376045; background: #eef4e7; }
        .stat-value { margin-top: 17px; font-family: Georgia, "Times New Roman", serif; font-size: 29px; letter-spacing: -.04em; }
        .stat-caption { margin-top: 5px; color: #96a098; font-size: 10px; }

        .panel { overflow: hidden; border: 1px solid var(--line); border-radius: 12px; background: #fff; }
        .detail-panels { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; margin-top: 20px; }
        .panel-heading { display: flex; align-items: center; justify-content: space-between; gap: 15px; padding: 20px 22px; border-bottom: 1px solid #eef0eb; }
        .panel-title { margin: 0; font-size: 13px; font-weight: 700; }
        .panel-description { margin: 5px 0 0; color: #919b94; font-size: 10px; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 12px 22px; color: #98a19a; background: #fbfcfa; font-size: 9px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; white-space: nowrap; }
        td { padding: 14px 22px; border-top: 1px solid #f0f2ee; color: #536159; font-size: 11px; white-space: nowrap; }
        tbody tr:hover { background: #fcfdfa; }
        .invoice-number { color: #32493b; font-weight: 700; }
        .customer-cell { display: flex; align-items: center; gap: 9px; }
        .customer-avatar { width: 28px; height: 28px; display: grid; place-items: center; border-radius: 50%; color: #46644b; background: #eff3e8; font-size: 10px; font-weight: 700; }
        .customer-name { color: #405149; font-weight: 600; }
        .item-name { max-width: 190px; overflow: hidden; text-overflow: ellipsis; }
        .detail-table th, .detail-table td { padding-right: 16px; padding-left: 16px; }
        .detail-table td { white-space: normal; }
        .detail-table .customer-name { overflow-wrap: anywhere; }
        .detail-empty { padding: 30px 16px; color: #929c95; font-size: 11px; text-align: center; }
        .amount { color: #33473a; font-weight: 700; }
        .download-link { display: inline-flex; align-items: center; gap: 6px; color: #58715e; font-size: 10px; font-weight: 650; text-decoration: none; }
        .download-link:hover { color: #1f4e35; }
        .empty-state { padding: 54px 20px; color: #88938c; text-align: center; }
        .empty-icon { width: 42px; height: 42px; display: grid; place-items: center; margin: 0 auto 14px; border-radius: 13px; color: #526e53; background: #f0f4e9; }
        .empty-title { margin: 0; color: #425349; font-size: 13px; font-weight: 700; }
        .empty-copy { margin: 7px 0 17px; font-size: 11px; }

        dialog { width: min(560px, calc(100% - 28px)); max-width: none; max-height: min(90vh, 780px); padding: 0; overflow: auto; border: 1px solid #e6eae2; border-radius: 16px; color: #192c26; background: #fff; box-shadow: 0 24px 90px rgba(17,39,30,.22); }
        dialog::backdrop { background: rgba(18, 36, 29, .48); backdrop-filter: blur(3px); }
        .modal-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 15px; padding: 22px 25px 17px; border-bottom: 1px solid #edf0ea; }
        .modal-title { margin: 0; font-family: Georgia, "Times New Roman", serif; font-size: 25px; font-weight: 400; letter-spacing: -.03em; }
        .modal-subtitle { margin: 6px 0 0; color: #87918a; font-size: 11px; }
        .modal-close { width: 32px; height: 32px; display: grid; flex: 0 0 auto; place-items: center; border: 1px solid #e8ece5; border-radius: 8px; color: #6d7971; background: white; cursor: pointer; }
        .invoice-form { padding: 20px 25px 24px; }
        .form-section-title { margin: 0 0 14px; color: #53645a; font-size: 10px; font-weight: 750; letter-spacing: .11em; text-transform: uppercase; }
        .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
        .form-field { min-width: 0; margin-bottom: 15px; }
        .form-field.full { grid-column: 1 / -1; }
        .form-field label { display: block; margin: 0 0 7px; color: #405149; font-size: 10px; font-weight: 700; }
        .form-field input, .form-field textarea { width: 100%; min-height: 40px; padding: 10px 11px; border: 1px solid #dfe5dd; border-radius: 7px; outline: none; color: #253b30; background: #fff; font-size: 11px; }
        .form-field textarea { min-height: 66px; resize: vertical; }
        .form-field input:focus, .form-field textarea:focus { border-color: #6b9273; box-shadow: 0 0 0 3px rgba(83,124,89,.11); }
        .form-field input[aria-invalid="true"], .form-field textarea[aria-invalid="true"] { border-color: #c74747; }
        .field-error { margin: 6px 0 0; color: #b53636; font-size: 10px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 6px; padding-top: 16px; border-top: 1px solid #edf0ea; }
        .secondary-button { min-height: 40px; padding: 0 14px; border: 1px solid #e0e5dd; border-radius: 8px; color: #59675f; background: #fff; cursor: pointer; font-size: 11px; font-weight: 650; }

        @media (max-width: 980px) {
            .sidebar { width: 218px; }
            .main { margin-left: 218px; }
            .topbar { padding: 0 28px; }
            .content { padding: 32px 28px 44px; }
            .stats-grid { gap: 11px; }
            .stat-card { padding: 17px; }
        }

        @media (max-width: 720px) {
            .sidebar { position: static; width: auto; height: auto; flex-direction: row; align-items: center; justify-content: space-between; padding: 14px 18px; }
            .brand { padding: 0; }
            .brand-mark { width: 36px; height: 36px; }
            .brand-name { font-size: 11px; }
            .brand-caption { font-size: 8px; }
            .nav-label, .nav-link, .sidebar-note { display: none; }
            .sidebar-footer { margin: 0; padding: 0; }
            .sidebar-footer .user-info { display: none; }
            .sidebar-footer .avatar { width: 30px; height: 30px; }
            .main { margin-left: 0; min-height: auto; }
            .topbar { height: 54px; padding: 0 20px; }
            .content { padding: 26px 20px 38px; }
            .welcome-row { align-items: flex-start; }
            .welcome-title { font-size: 30px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .stat-card:last-child { grid-column: 1 / -1; min-height: 120px; }
            .panel-heading { padding: 17px; }
            th, td { padding-right: 16px; padding-left: 16px; }
            .detail-panels { grid-template-columns: 1fr; }
        }

        @media (max-width: 480px) {
            .topbar-date { font-size: 9px; }
            .content { padding: 23px 14px 30px; }
            .welcome-row { flex-direction: column; align-items: stretch; gap: 17px; }
            .welcome-row .primary-button { align-self: flex-start; }
            .welcome-title { font-size: 28px; }
            .stats-grid { gap: 9px; }
            .stat-card { min-height: 130px; padding: 14px; }
            .stat-label { font-size: 10px; }
            .stat-value { font-size: 25px; }
            .stat-icon { width: 28px; height: 28px; }
            .panel-heading { align-items: flex-start; }
            .invoice-form { padding: 18px; }
            .modal-header { padding: 19px 18px 15px; }
            .form-grid { grid-template-columns: 1fr; gap: 0; }
            .form-field.full { grid-column: auto; }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('home') }}" aria-label="Nile Paints dashboard">
                <span class="brand-mark" aria-hidden="true">N</span>
                <span>
                    <span class="brand-name">NILE PAINTS</span>
                    <span class="brand-caption">COLOUR YOUR WORLD</span>
                </span>
            </a>

            <p class="nav-label">Workspace</p>
            <a class="nav-link active" href="{{ route('home') }}" aria-current="page">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><rect x="2" y="2" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="9" y="2" width="5" height="3" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="9" y="7" width="5" height="7" rx="1" stroke="currentColor" stroke-width="1.3"/><rect x="2" y="9" width="5" height="5" rx="1" stroke="currentColor" stroke-width="1.3"/></svg>
                <span>Overview</span>
            </a>

            <div class="sidebar-note">
                <p class="sidebar-note-title">A little inspiration</p>
                <p>Great spaces start with the right colour. Let’s make something wonderful today.</p>
            </div>

            <div class="sidebar-footer">
                <span class="avatar" aria-hidden="true">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                <div class="user-info">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">Workspace account</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-button" type="submit" aria-label="Sign out" title="Sign out">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M6.25 3H3.5A1.5 1.5 0 0 0 2 4.5v7A1.5 1.5 0 0 0 3.5 13h2.75M9.5 11l3-3-3-3M12.5 8H6" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="breadcrumb">Workspace <span aria-hidden="true">/</span> <strong>Overview</strong></div>
                <time class="topbar-date" datetime="{{ now()->toDateString() }}">{{ now()->format('l, j F Y') }}</time>
            </header>

            <div class="content">
                <section class="welcome-row" aria-labelledby="welcome-heading">
                    <div>
                        <p class="welcome-kicker">{{ now()->format('l, j F Y') }}</p>
                        <h1 class="welcome-title" id="welcome-heading">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ explode(' ', auth()->user()->name)[0] }}.</h1>
                        <p class="welcome-subtitle">Here’s what’s happening with your business.</p>
                    </div>
                    <button class="primary-button" type="button" data-open-invoice>
                        <svg width="15" height="15" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M8 3.25v9.5M3.25 8h9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                        <span>New invoice</span>
                    </button>
                </section>

                @if (session('success'))
                    <div class="flash" role="status">{{ session('success') }}</div>
                @endif

                <section class="stats-grid" aria-label="Business summary">
                    <article class="stat-card">
                        <div class="stat-top">
                            <span class="stat-label">Total revenue</span>
                            <span class="stat-icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1.75v12.5M11.25 4.5H6.5a2 2 0 0 0 0 4h3a2 2 0 0 1 0 4H4.75" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg></span>
                        </div>
                        <div class="stat-value">LKR {{ number_format((float) $totalRevenue, 2) }}</div>
                        <div class="stat-caption">Across all recorded invoices</div>
                    </article>

                    <article class="stat-card">
                        <div class="stat-top">
                            <span class="stat-label">This month</span>
                            <span class="stat-icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2.25" y="3.5" width="11.5" height="10" rx="1.5" stroke="currentColor" stroke-width="1.3"/><path d="M5.25 2v3M10.75 2v3M2.5 6.5h11" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg></span>
                        </div>
                        <div class="stat-value">LKR {{ number_format((float) $monthRevenue, 2) }}</div>
                        <div class="stat-caption">{{ now()->format('F Y') }} revenue</div>
                    </article>

                    <article class="stat-card">
                        <div class="stat-top">
                            <span class="stat-label">Invoices & customers</span>
                            <span class="stat-icon" aria-hidden="true"><svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M5 7a2.25 2.25 0 1 0 0-4.5A2.25 2.25 0 0 0 5 7ZM11.25 7a1.75 1.75 0 1 0 0-3.5M1.75 13a3.25 3.25 0 0 1 6.5 0M9 10.25a2.75 2.75 0 0 1 5.25 1.5" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg></span>
                        </div>
                        <div class="stat-value">{{ number_format($invoiceCount) }} <span style="color:#a0aaa2;font-family:inherit;font-size:17px">/ {{ number_format($customerCount) }}</span></div>
                        <div class="stat-caption">Invoices created / customers served</div>
                    </article>
                </section>

                <div class="detail-panels">
                    <section class="panel" aria-labelledby="customers-heading">
                        <div class="panel-heading">
                            <div>
                                <h2 class="panel-title" id="customers-heading">Customer details</h2>
                                <p class="panel-description">Recently added customers</p>
                            </div>
                            @if ($recentCustomers->isNotEmpty())
                                <span class="panel-description">Showing {{ $recentCustomers->count() }}</span>
                            @endif
                        </div>

                        @if ($recentCustomers->isNotEmpty())
                            <div class="table-wrap">
                                <table class="detail-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Contact</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Invoices</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentCustomers as $customer)
                                            <tr>
                                                <td><span class="customer-name">{{ $customer->name }}</span></td>
                                                <td>{{ $customer->contact_no }}</td>
                                                <td>{{ $customer->address ?: '—' }}</td>
                                                <td>{{ number_format($customer->invoices_count) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="detail-empty">No customer details yet.</div>
                        @endif
                    </section>

                    <section class="panel" aria-labelledby="items-heading">
                        <div class="panel-heading">
                            <div>
                                <h2 class="panel-title" id="items-heading">Item details</h2>
                                <p class="panel-description">Recently added items and prices</p>
                            </div>
                            @if ($recentItems->isNotEmpty())
                                <span class="panel-description">Showing {{ $recentItems->count() }}</span>
                            @endif
                        </div>

                        @if ($recentItems->isNotEmpty())
                            <div class="table-wrap">
                                <table class="detail-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Item name</th>
                                            <th scope="col">Unit price</th>
                                            <th scope="col">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentItems as $item)
                                            <tr>
                                                <td><span class="customer-name">{{ $item->item_name }}</span></td>
                                                <td>LKR {{ number_format((float) $item->unit_price, 2) }}</td>
                                                <td>{{ number_format($item->qty) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="detail-empty">No item details yet.</div>
                        @endif
                    </section>
                </div>

                <section class="panel" id="recent-invoices" aria-labelledby="recent-invoices-heading">
                    <div class="panel-heading">
                        <div>
                            <h2 class="panel-title" id="recent-invoices-heading">Recent invoices</h2>
                            <p class="panel-description">Your latest customer transactions</p>
                        </div>
                        @if ($recentInvoices->isNotEmpty())
                            <span class="panel-description">Showing {{ $recentInvoices->count() }} latest</span>
                        @endif
                    </div>

                    @if ($recentInvoices->isNotEmpty())
                        <div class="table-wrap">
                            <table>
                                <thead>
                                    <tr>
                                        <th scope="col">Invoice</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentInvoices as $invoice)
                                        <tr>
                                            <td><span class="invoice-number">#{{ $invoice->id }}</span></td>
                                            <td>
                                                <div class="customer-cell">
                                                    <span class="customer-avatar" aria-hidden="true">{{ strtoupper(substr($invoice->customer->name, 0, 1)) }}</span>
                                                    <span class="customer-name">{{ $invoice->customer->name }}</span>
                                                </div>
                                            </td>
                                            <td><span class="item-name">{{ $invoice->item_name }}</span></td>
                                            <td>{{ \Illuminate\Support\Carbon::parse($invoice->date)->format('d M Y') }}</td>
                                            <td class="amount">LKR {{ number_format((float) $invoice->total_amount, 2) }}</td>
                                            <td><a class="download-link" href="{{ route('invoices.pdf', $invoice->id) }}" aria-label="Download invoice {{ $invoice->id }} PDF">
                                                <svg width="13" height="13" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M8 2.25v7m0 0 2.5-2.5M8 9.25l-2.5-2.5M3 10.5v2A1.5 1.5 0 0 0 4.5 14h7a1.5 1.5 0 0 0 1.5-1.5v-2" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                PDF
                                            </a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <span class="empty-icon" aria-hidden="true"><svg width="19" height="19" viewBox="0 0 20 20" fill="none"><path d="M5 2.75h7l3 3v11.5H5a1.25 1.25 0 0 1-1.25-1.25V4A1.25 1.25 0 0 1 5 2.75Z" stroke="currentColor" stroke-width="1.3" stroke-linejoin="round"/><path d="M12 2.75V6h3M7 9h6M7 12h6" stroke="currentColor" stroke-width="1.3" stroke-linecap="round"/></svg></span>
                            <h3 class="empty-title">Your first invoice starts here</h3>
                            <p class="empty-copy">Create an invoice to see your sales activity on this dashboard.</p>
                            <button class="primary-button" type="button" data-open-invoice>Create an invoice</button>
                        </div>
                    @endif
                </section>
            </div>
        </main>
    </div>

    <dialog id="invoice-dialog" aria-labelledby="invoice-dialog-title">
        <div class="modal-header">
            <div>
                <h2 class="modal-title" id="invoice-dialog-title">Create an invoice</h2>
                <p class="modal-subtitle">Add customer and item details to record a sale.</p>
            </div>
            <button class="modal-close" type="button" data-close-invoice aria-label="Close invoice form">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="m3 3 8 8m0-8-8 8" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
            </button>
        </div>

        <form class="invoice-form" method="POST" action="{{ route('invoices.store') }}">
            @csrf
            <h3 class="form-section-title">Customer details</h3>
            <div class="form-grid">
                <div class="form-field">
                    <label for="customer_name">Customer name</label>
                    <input id="customer_name" name="customer_name" type="text" value="{{ old('customer_name') }}" autocomplete="name" required @error('customer_name') aria-invalid="true" aria-describedby="customer-name-error" @enderror>
                    @error('customer_name')<p class="field-error" id="customer-name-error" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="form-field">
                    <label for="contact_no">Contact number</label>
                    <input id="contact_no" name="contact_no" type="tel" value="{{ old('contact_no') }}" autocomplete="tel" required @error('contact_no') aria-invalid="true" aria-describedby="contact-error" @enderror>
                    @error('contact_no')<p class="field-error" id="contact-error" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="form-field full">
                    <label for="address">Address <span style="font-weight:400;color:#98a19a">(optional)</span></label>
                    <textarea id="address" name="address" autocomplete="street-address" @error('address') aria-invalid="true" aria-describedby="address-error" @enderror>{{ old('address') }}</textarea>
                    @error('address')<p class="field-error" id="address-error" role="alert">{{ $message }}</p>@enderror
                </div>
            </div>

            <h3 class="form-section-title" style="margin-top:7px">Invoice details</h3>
            <div class="form-grid">
                <div class="form-field full">
                    <label for="item_name">Item name</label>
                    <input id="item_name" name="item_name" type="text" value="{{ old('item_name') }}" required @error('item_name') aria-invalid="true" aria-describedby="item-name-error" @enderror>
                    @error('item_name')<p class="field-error" id="item-name-error" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="form-field">
                    <label for="qty">Quantity</label>
                    <input id="qty" name="qty" type="number" min="1" step="1" value="{{ old('qty', 1) }}" required @error('qty') aria-invalid="true" aria-describedby="qty-error" @enderror>
                    @error('qty')<p class="field-error" id="qty-error" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="form-field">
                    <label for="unit_price">Unit price (LKR)</label>
                    <input id="unit_price" name="unit_price" type="number" min="0" step="0.01" value="{{ old('unit_price') }}" required @error('unit_price') aria-invalid="true" aria-describedby="unit-price-error" @enderror>
                    @error('unit_price')<p class="field-error" id="unit-price-error" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="form-field full">
                    <label for="date">Invoice date</label>
                    <input id="date" name="date" type="date" value="{{ old('date', now()->toDateString()) }}" required @error('date') aria-invalid="true" aria-describedby="date-error" @enderror>
                    @error('date')<p class="field-error" id="date-error" role="alert">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="modal-actions">
                <button class="secondary-button" type="button" data-close-invoice>Cancel</button>
                <button class="primary-button" type="submit">Save invoice</button>
            </div>
        </form>
    </dialog>

    <script>
        const invoiceDialog = document.getElementById('invoice-dialog');

        document.querySelectorAll('[data-open-invoice]').forEach((button) => {
            button.addEventListener('click', () => invoiceDialog.showModal());
        });

        document.querySelectorAll('[data-close-invoice]').forEach((button) => {
            button.addEventListener('click', () => invoiceDialog.close());
        });

        invoiceDialog.addEventListener('click', (event) => {
            if (event.target === invoiceDialog) {
                invoiceDialog.close();
            }
        });

        @if ($errors->any())
            invoiceDialog.showModal();
            document.querySelector('[aria-invalid="true"]')?.focus();
        @endif
    </script>
</body>
</html>
