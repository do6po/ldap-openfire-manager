<?php

namespace Tests\Feature\LDAP;

use App\Models\LDAP\LDAP;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\LDAPFixture;
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
            'ldap_servers' => LDAPFixture::class,
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

        $this->assertDatabaseMissing(LDAP::TABLE_NAME, $newServer);

        $this->post('/ldap', $newServer);

        $this->assertDatabaseHas(LDAP::TABLE_NAME, $newServer);
    }

    public function testCreateWithNotUniqueName(): void
    {
        $this->login();

        $newServer = [
            'name' => 'Local ldap server 1',
            'hostname' => 'hostname.loc',
            'port' => 389,
            'username' => 'newUsername',
            'password' => '1234',
        ];

        $result = $this->post('/ldap', $newServer);
        $result->assertRedirect();

        $newResult = $this->get('/ldap/create');
        $newResult->assertSee('Local ldap server 1');

        $this->assertDatabaseMissing(LDAP::TABLE_NAME, $newServer);
    }
}
