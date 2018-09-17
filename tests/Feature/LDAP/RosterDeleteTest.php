<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 17.09.18
 * Time: 17:35
 */

namespace Tests\Feature\LDAP;


use App\Models\LDAP\Roster;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\LDAPFixture;
use Tests\Fixtures\RosterFixtures;
use Tests\Helpers\AuthTrait;
use Tests\TestCase;

class RosterDeleteTest extends TestCase
{
    use RefreshDatabase, FixtureTrait, AuthTrait;

    const URI = '/ldap/roster';

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
            LDAPFixture::class,
            RosterFixtures::class,
        ];
    }

    public function testDelete()
    {
        $rosterAttributes = [
            'name' => 'Roster 1 for LDAP 1',
            'ldap_id' => 1,
        ];

        $this->login();
        $this->prepareUrlForRequest('/ldap/1');

        $this->assertDatabaseHas(Roster::TABLE_NAME, $rosterAttributes);

        $result = $this->delete('/ldap/roster/1');
        $result->assertRedirect();

        $this->assertDatabaseMissing(Roster::TABLE_NAME, $rosterAttributes);
    }
}