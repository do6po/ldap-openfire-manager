<?php

namespace Tests\Feature\Auth;

use App\Models\Users\User;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\UserFixture;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase, FixtureTrait;

    protected $uri = '/login';

    /**
     * @throws \LaravelFlux\Fixture\Exceptions\InvalidConfigException
     */
    public function setUp()
    {
        parent::setUp();

        $this->initFixtures();
    }

    public function fixtures(): array
    {
        return [
            'users' => UserFixture::class,
        ];
    }


    public function testLoginPage()
    {
        $response = $this->get($this->uri);

        $response->assertOk();
    }

    public function testLogin()
    {
        $user = [
            'email' => 'admin1@example.com',
            'password' => '1234',
        ];

        $this->assertFalse($this->isAuthenticated());

        $response = $this->post($this->uri, $user);
        $response->assertRedirect('/');

        $this->assertAuthenticated();
        $this->assertAuthenticatedAs(
            User::whereEmail('admin1@example.com')
                ->get()
                ->first()
        );
    }

    public function testLoginFailed()
    {
        $user = [
            'email' => 'admin1@example.com',
            'password' => '12345',
        ];

        $this->assertFalse($this->isAuthenticated());


        $response = $this->post($this->uri, $user);
        $response->assertRedirect();
        $this->assertFalse($this->isAuthenticated());

        $newResponse = $this->get($this->uri);
        $newResponse->assertSeeText('These credentials do not match our records');
    }
}
