<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.08.2018
 * Time: 15:56
 */

namespace Tests\Feature\Servers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\ServerFixture;
use Tests\Helpers\AuthTrait;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase, FixtureTrait, AuthTrait;

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
        $response = $this->get('/ldap/1/edit');
        $response->assertRedirect('/login');
    }

    public function testUpdatePage()
    {
        $this->login();

        $result = $this->get('/ldap/1/edit');
        $result->assertOk();
        $result->assertSeeText('Save');
    }

    public function testUpdate()
    {
        $this->login();

        $this->assertDatabaseHas('servers', [
            'id' => 1,
            'name' => 'Local ldap server 1'
        ]);

        $newName = 'Local ldap server 1 updated';

        $result = $this->put('/ldap/1', [
            'name' => $newName,
            'hostname' => 'ldap1.local',
            'username' => 'username1',
        ]);

        $result->assertRedirect('/ldap/1');

        $this->assertDatabaseHas('servers', [
            'id' => 1,
            'name' => $newName,
            'hostname' => 'ldap1.local',
            'username' => 'username1',
        ]);
    }
}