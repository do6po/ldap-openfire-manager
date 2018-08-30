<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 30.08.2018
 * Time: 18:31
 */

namespace Tests\Unit\app\Models\LDAP;

use App\Models\LDAP\Roster;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\LDAPFixture;
use Tests\TestCase;

class RosterTest extends TestCase
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

    public function testCreate()
    {
        $factory = Factory::create();
        $rosterAttributes = [
            'name' => 'new roster name',
            'roster_path' => '(objectClass=user)',
            'users_group' => '(cn=group)',
            'description' => $factory->text,
            'ldap_id' => 1,
        ];

        $this->assertDatabaseMissing(Roster::TABLE_NAME, $rosterAttributes);
        Roster::create($rosterAttributes);
        $this->assertDatabaseHas(Roster::TABLE_NAME, $rosterAttributes);
    }

    public function testCreateWithoutNullableFields()
    {
        $rosterAttributes = [
            'name' => 'new roster name',
            'ldap_id' => 1,
        ];

        $this->assertDatabaseMissing(Roster::TABLE_NAME, $rosterAttributes);
        Roster::create($rosterAttributes);
        $this->assertDatabaseHas(Roster::TABLE_NAME, $rosterAttributes);
    }
}