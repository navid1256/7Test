<?php

namespace Tests\API\V2;

use App\Models\User;
use App\repositories\Contracts\UserRepositoryInterface;
use App\repositories\Eloquent\EloquentBaseRepository;
use App\repositories\Eloquent\EloquentUserRepository;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_user_repository_contract_resolves_to_eloquent_implementation(): void
    {
        $repository = $this->app->make(UserRepositoryInterface::class);

        $this->assertInstanceOf(EloquentUserRepository::class, $repository);
        $this->assertInstanceOf(EloquentBaseRepository::class, $repository);
    }

    public function test_should_create_a_new_user(): void
    {
        $userData = [
            'full_name' => 'Amir Salehi',
            'email' => 'amir@example.test',
            'mobile' => '09121112222',
            'password' => 'Test-password-123!',
            'password_confirmation' => 'Test-password-123!',
        ];

        $response = $this->postJson('/api/v2/users', $userData);

        $response->assertCreated()
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'full_name',
                    'email',
                    'mobile',
                ],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'کاربر با موفقیت ایجاد شد',
                'data' => [
                    'full_name' => $userData['full_name'],
                    'email' => $userData['email'],
                    'mobile' => $userData['mobile'],
                ],
            ])
            ->assertJsonMissingPath('data.password');

        $this->assertDatabaseHas(User::class, [
            'full_name' => $userData['full_name'],
            'email' => $userData['email'],
            'mobile' => $userData['mobile'],
        ]);

        $user = User::query()->where('email', $userData['email'])->firstOrFail();

        expect(Hash::check($userData['password'], $user->password))->toBeTrue();
    }
}
