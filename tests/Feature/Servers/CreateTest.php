<?php

namespace Tests\Feature\Servers;

use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\ServerFixture;
use Tests\Helpers\AuthTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase, FixtureTrait, AuthTrait;

    const URI = '/ldap/create';

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
            'servers' => ServerFixture::class,
        ];
    }

    public function testRedirectForNonAuth(): void
    {
        $response = $this->get(self::URI);
        $response->assertRedirect('/login');
    }

    public function testCreatePage(): void
    {
        $this->login();

        $result = $this->get(self::URI);
        $result->assertOk();
        $result->assertSeeText('Add new');
    }

    public function testCreate(): void
    {
        $this->login();

        $newServer = [
            'name' => 'new server name',
            'hostname' => 'hostname.loc',
            'port' => 389,
            'username' => 'newUsername',
            'password' => '1234',
        ];

        $this->assertDatabaseMissing('servers', $newServer);

        $result = $this->post('/ldap', $newServer);
        $result->assertRedirect('/ldap');

        $this->assertDatabaseHas('servers', $newServer);
    }
}
