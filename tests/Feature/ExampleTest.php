<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_visit_the_home_page(): void
    {
        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertOk();
    }

    public function test_dashboard_shows_summary_and_recent_invoices(): void
    {
        $customer = Customer::create([
            'name' => 'Amara Perera',
            'contact_no' => '0771234567',
        ]);

        Invoice::create([
            'cus_id' => $customer->id,
            'item_name' => 'Interior Emulsion - Ivory',
            'date' => now()->toDateString(),
            'qty' => 2,
            'unit_price' => 2500,
            'total_amount' => 5000,
        ]);

        Item::create([
            'item_name' => 'Interior Emulsion - Ivory',
            'unit_price' => 2500,
            'qty' => 2,
        ]);

        $this->actingAs(User::factory()->create())
            ->get('/')
            ->assertOk()
            ->assertSee('Total revenue')
            ->assertSee('LKR 5,000.00')
            ->assertSee('Amara Perera')
            ->assertSee('Interior Emulsion - Ivory')
            ->assertSee('Customer details')
            ->assertSee('Item details')
            ->assertSee('0771234567')
            ->assertSee('Invoices')
            ->assertSee('Unit price')
            ->assertSee('Quantity');
    }

    public function test_user_can_create_an_invoice_from_the_dashboard(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/invoices', [
                'customer_name' => 'Amara Perera',
                'contact_no' => '0771234567',
                'address' => 'Colombo',
                'item_name' => 'Interior Emulsion - Ivory',
                'qty' => 2,
                'unit_price' => 2500,
                'date' => now()->toDateString(),
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('invoices', [
            'item_name' => 'Interior Emulsion - Ivory',
            'qty' => 2,
            'total_amount' => 5000,
        ]);
    }

    public function test_invoice_pdf_uses_item_name_stored_on_invoice(): void
    {
        $customer = Customer::create([
            'name' => 'Amara Perera',
            'contact_no' => '0771234567',
        ]);
        $invoice = Invoice::create([
            'cus_id' => $customer->id,
            'item_name' => 'Interior Emulsion - Ivory',
            'date' => now()->toDateString(),
            'qty' => 2,
            'unit_price' => 2500,
            'total_amount' => 5000,
        ]);

        $this->actingAs(User::factory()->create())
            ->get(route('invoices.pdf', $invoice->id))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_guest_cannot_access_invoice_routes(): void
    {
        $this->post('/invoices')->assertRedirect(route('login'));
        $this->get('/invoices/1/pdf')->assertRedirect(route('login'));
    }
}
