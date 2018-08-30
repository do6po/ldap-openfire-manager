<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 30.08.2018
 * Time: 20:08
 */

namespace Tests\Feature\LDAP;

use App\Models\LDAP\Roster;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\LDAPFixture;
use Tests\Fixtures\RosterFixtures;
use Tests\Helpers\AuthTrait;
use Tests\TestCase;

class RosterCreateTest extends TestCase
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

        $this->login();
        $this->post('/');

        $this->assertDatabaseMissing(Roster::TABLE_NAME, $rosterAttributes);

        $response = $this->post(self::URI, $rosterAttributes);
        //$response->assertRedirect('/');

        $this->assertDatabaseHas(Roster::TABLE_NAME, $rosterAttributes);
    }
}