<?php

namespace Tests\Unit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public $prefix = 'auth/';

    /**
     * Testa se os campos são requeridos.
     */
    public function testFieldsIsRequired()
    {
        $data = [];
        $reponse = $this->postJson($this->uri . $this->prefix . 'login', $data, $this->headers);
        $reponse->assertStatus(422);
    }

    /**
     * Testa a validação dos campos.
     */
    public function testIsValidField()
    {
        $data = [
            'email' => 'geovane', //Precisa ser um e-mail no formato válido.
            'password' => 'geova', // Precisa ter no mínimo 6 characters.
        ];

        $reponse = $this->postJson($this->uri . $this->prefix . 'login', $data, $this->headers);
        $reponse->assertStatus(422)
            ->assertJsonStructure([
                'errors' => [
                    'email',
                    'password',
                ],
            ]);
    }

    /**
     * Testa o login com as credenciais incorretas.
     */
    public function testLoginFail()
    {
        $data = [
            'email' => 'wrog@email.com',
            'password' => 'badpassword',
        ];

        $reponse = $this->postJson($this->uri . $this->prefix . 'login', $data, $this->headers);
        $reponse->assertStatus(401)
            ->assertJsonStructure([
                'errors' => [
                    'login',
                ],
            ]);
    }

    /**
     * Testa o login com as credenciais incorretas.
     */
    public function testLoginSuccess()
    {
        Sanctum::actingAs(
            factory(User::class)
                ->create(),
            ['*']
        );

        $reponse = $this->get($this->uri . 'me', $this->headers);
        $reponse->assertOk();
    }

    /**
     * Testa o logout do usuário.
     */
    public function testLogout()
    {
        Sanctum::actingAs(
            factory(User::class)->create(),
            ['*']
        );

        $reponse = $this->get($this->uri . $this->prefix . 'logout', $this->headers);
        $reponse->assertNoContent();
    }
}
