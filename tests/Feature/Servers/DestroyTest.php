<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.08.2018
 * Time: 16:12
 */

namespace Tests\Feature\Servers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\ServerFixture;
use Tests\Helpers\AuthTrait;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase, FixtureTrait, AuthTrait;

    const URI = '/ldap/1';

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

    public function testDestroy(): void
    {
        $this->login();

        $data = [
            'id' => 1,
            'name' => 'Local ldap server 1'
        ];
        $this->assertDatabaseHas('servers', $data);

        $result = $this->delete(self::URI);
        $result->assertRedirect('/ldap');

        $this->assertDatabaseMissing('servers', $data);
    }
}