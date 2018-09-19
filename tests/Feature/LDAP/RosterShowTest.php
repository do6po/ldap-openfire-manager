<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 17.09.18
 * Time: 17:35
 */

namespace Tests\Feature\LDAP;


use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\LDAPFixture;
use Tests\Fixtures\RosterFixtures;
use Tests\Helpers\AuthTrait;
use Tests\TestCase;

class RosterShowTest extends TestCase
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

    public function testShow()
    {
        $this->login();

        $result = $this->get('/ldap/roster/1');
        $result->assertOk();
    }
}