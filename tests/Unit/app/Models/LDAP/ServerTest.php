<?php

namespace Tests\Unit\app\Models\LDAP;

use App\Models\LDAP\Server;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\ServerFixture;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServerTest extends TestCase
{
    use RefreshDatabase, FixtureTrait;

    const TEST_TABLE = 'servers';

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
            ServerFixture::class,
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
        $this->assertDatabaseMissing(self::TEST_TABLE, $params);
        Server::create($params);
        $this->assertDatabaseHas(self::TEST_TABLE, $params);
    }

    public function testUpdate(): void
    {
        $updatedServerName = 'Updated server name';
        $this->assertDatabaseMissing(self::TEST_TABLE, ['name' => $updatedServerName]);

        $serverId = 1;
        $server = Server::findOrFail($serverId);
        $this->assertNotNull($server);

        $server->name = $updatedServerName;
        $this->assertTrue($server->save());
        $this->assertDatabaseHas(self::TEST_TABLE, ['name' => $updatedServerName]);
    }

    public function testCreateWithoutPort()
    {
        $params = [
            'name' => 'New server name',
            'hostname' => 'new-hostname.local',
            'username' => 'newUsername',
            'password' => \Hash::make('1234'),
        ];
        $this->assertDatabaseMissing(self::TEST_TABLE, $params);
        Server::create($params);

        $params['port'] = 389;
        $this->assertDatabaseHas(self::TEST_TABLE, $params);
    }
}
