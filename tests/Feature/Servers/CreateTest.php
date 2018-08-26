<?php

namespace Tests\Feature\Servers;

use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\ServerFixture;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTest extends TestCase
{
    use RefreshDatabase, FixtureTrait;

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

    public function testCreate(): void
    {
        $result = $this->get('/ldap/create');
        $result->assertOk();
        $result->assertSeeText('Add new');
    }

    public function testCreatePost(): void
    {
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
