<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')
            ->assertRedirect(route('login'));
    }

    public function test_login_page_is_available_to_guests(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Welcome back')
            ->assertSee('Sign in to your account')
            ->assertSee(route('register'));
    }

    public function test_user_can_sign_in_and_is_redirected_to_home(): void
    {
        $user = User::factory()->create([
            'email' => 'staff@nilepaints.test',
            'password' => 'correct-password',
        ]);

        $this->post(route('login.store'), [
            'email' => 'staff@nilepaints.test',
            'password' => 'correct-password',
            'remember' => '1',
        ])
            ->assertRedirect(route('home'))
            ->assertSessionHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_return_to_login_with_an_error(): void
    {
        User::factory()->create([
            'email' => 'staff@nilepaints.test',
            'password' => 'correct-password',
        ]);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => 'staff@nilepaints.test',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_user_can_sign_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_guest_can_register_and_is_signed_in(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create your account')
            ->assertSee('Confirm password');

        $this->post(route('register.store'), [
            'name' => 'Nile Staff',
            'email' => 'new-user@nilepaints.test',
            'password' => 'secure-password',
            'password_confirmation' => 'secure-password',
        ])->assertRedirect(route('home'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Nile Staff',
            'email' => 'new-user@nilepaints.test',
        ]);
    }

    public function test_registration_requires_valid_unique_email_and_confirmed_password(): void
    {
        User::factory()->create(['email' => 'existing@nilepaints.test']);

        $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'New Staff',
                'email' => 'existing@nilepaints.test',
                'password' => 'short',
                'password_confirmation' => 'different',
            ])
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors(['email', 'password']);

        $this->assertGuest();
    }
}
