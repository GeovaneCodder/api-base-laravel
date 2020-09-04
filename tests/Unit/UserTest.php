<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public $prefix = 'user/';

    /**
     * Testa os campos obrigatório
     */
    public function testCreateUserFieldsIsRequired()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $data = [];

        $response = $this->postJson($this->uri . $this->prefix, $data, $this->headers);
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'email',
                    'password',
                    'first_name',
                    'last_name',
                ],
            ]);
    }

    /**
     * Testa o sistema que evita duplicidade de email
     * no banco de dados.
     */
    public function testValitateIfHasUserWithEmailOnDatabase()
    {
        $user = factory(User::class)->create();

        $data = [
            'email' => $user->email,
            'password' => $user->password,
            'first_name' => 'someone',
            'last_name' => 'any'
        ];

        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->postJson($this->uri . $this->prefix, $data, $this->headers);
        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'email',
                ],
            ]);
    }

    /**
     * Testa a funcionalidade de criar um novo usuário
     */
    public function testCreateNewUser()
    {
        $data = [
            'email' => 'newuser@email.com',
            'password' => 'newuserpass',
            'first_name' => 'someone',
            'last_name' => 'any'
        ];

        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $response = $this->postJson($this->uri . $this->prefix, $data, $this->headers);
        $response->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'full_name',
                'first_name',
                'last_name',
                'email',
                'role'
            ]);
    }
}
