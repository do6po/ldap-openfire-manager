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
use Tests\TestCase;

class DestroyTest extends TestCase
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

    public function testDestroy()
    {
        $data = [
            'id' => 1,
            'name' => 'Local ldap server 1'
        ];
        $this->assertDatabaseHas('servers', $data);

        $result = $this->delete('/ldap/1');
        $result->assertRedirect('/ldap');

        $this->assertDatabaseMissing('servers', $data);
    }
}