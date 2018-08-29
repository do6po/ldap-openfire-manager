<?php

namespace Tests\Unit\app\Models\LDAP;

use App\Models\LDAP\LDAP;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\LDAPFixture;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LDAPTest extends TestCase
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

    public function fixtures()
    {
        return [
            LDAPFixture::class,
        ];
    }

    public function testCreate(): void
    {
        $params = [
            'name' => 'New server name',
            'hostname' => 'new-hostname.local',
            'port' => 389,
            'username' => 'newUsername',
            'password' => \Hash::make('1234'),
        ];
        $this->assertDatabaseMissing(LDAP::TABLE_NAME, $params);
        LDAP::create($params);
        $this->assertDatabaseHas(LDAP::TABLE_NAME, $params);
    }

    public function testUpdate(): void
    {
        $updatedServerName = 'Updated server name';
        $this->assertDatabaseMissing(LDAP::TABLE_NAME, ['name' => $updatedServerName]);

        $serverId = 1;
        $server = LDAP::findOrFail($serverId);
        $this->assertNotNull($server);

        $server->name = $updatedServerName;
        $this->assertTrue($server->save());
        $this->assertDatabaseHas(LDAP::TABLE_NAME, ['name' => $updatedServerName]);
    }

    public function testCreateWithoutPort()
    {
        $params = [
            'name' => 'New server name',
            'hostname' => 'new-hostname.local',
            'username' => 'newUsername',
            'password' => \Hash::make('1234'),
        ];
        $this->assertDatabaseMissing(LDAP::TABLE_NAME, $params);
        LDAP::create($params);

        $params['port'] = 389;
        $this->assertDatabaseHas(LDAP::TABLE_NAME, $params);
    }
}
