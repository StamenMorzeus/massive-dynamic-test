<?php

namespace Tests\Feature;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_index_page()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $response = $this->actingAs($user, 'web')
            ->get('/users');

        $response->assertStatus(200);
    }

    public function test_not_login_user_index_page()
    {
        $response = $this->get('/users');

        $response->assertStatus(302)
            ->assertRedirectContains('login');;
    }

    public function test_create_user_page()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $response = $this->actingAs($user, 'web')
            ->get('/users/create');

        $response->assertStatus(200);
    }

    public function test_create_user()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $response = $this->actingAs($user, 'web')
            ->post('/users', [
                'name' => 'test',
                'username' => 'etest',
                'email' => 'email@email.com',
                'password' => 'password',
                'role' => UserRoleEnum::CLIENT->value
            ]);

        $response->assertStatus(302)
            ->assertSessionHas('success')
            ->assertRedirectContains('/users');
    }

    public function test_create_exist_email_user()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $response = $this->actingAs($user, 'web')
            ->post('/users', [
                'name' => 'test1',
                'username' => 'etest1',
                'email' => $user->email,
                'password' => 'password',
                'role' => UserRoleEnum::CLIENT->value
            ]);

        $response->assertStatus(302)
            ->assertSessionHas('errors');
    }

    public function test_update_user_page()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $userForUpdate = User::factory()->create();
        $userForUpdate['role'] = UserRoleEnum::CLIENT;

        $response = $this->actingAs($user, 'web')
            ->get(route('user_edit', $userForUpdate->id));

        $response->assertStatus(200);
    }

    public function test_update_not_exist_user_page()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $response = $this->actingAs($user, 'web')
            ->get(route('user_edit', 123123));

        $response->assertStatus(302)
            ->assertSessionHas('error')
            ->assertRedirectContains('/users');
    }

    public function test_update_user()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $userForUpdate = User::factory()->create();
        $userForUpdate['role'] = UserRoleEnum::CLIENT;

        $response = $this->actingAs($user, 'web')
            ->put(route('user_update', $userForUpdate->id), [
                'name' => 'test',
                'username' => 'etest',
                'role' => UserRoleEnum::CLIENT->value
            ]);

        $response->assertStatus(302)
            ->assertSessionHas('success')
            ->assertRedirectContains('/users');
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::ADMINISTRATOR;

        $userForDelete = User::factory()->create();
        $userForDelete['role'] = UserRoleEnum::CLIENT;

        $response = $this->actingAs($user, 'web')
            ->delete(route('user_destroy', $userForDelete->id));

        $response->assertStatus(302)
            ->assertSessionHas('success')
            ->assertRedirectContains('/users');
    }

    public function test_delete_user_with_secretary()
    {
        $user = User::factory()->create();
        $user['role'] = UserRoleEnum::SECRETARY;

        $userForDelete = User::factory()->create();
        $userForDelete['role'] = UserRoleEnum::CLIENT;

        $response = $this->actingAs($user, 'web')
            ->delete(route('user_destroy', $userForDelete->id));

        $response->assertStatus(302)
            ->assertRedirectContains('dashboard');
    }

}
