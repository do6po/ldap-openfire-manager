<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 26.08.2018
 * Time: 16:17
 */

namespace Tests\Feature\Servers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\ServerFixture;
use Tests\TestCase;

class ShowTest extends TestCase
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

    public function testShow()
    {
        $result = $this->get('/ldap/1');
        $result->assertOk();

        $result->assertSeeTextInOrder([
            'Local ldap server 1',
            'ldap1.local',
            '389',
            'username1',
        ]);

        $result->assertSeeText('Test connection');
    }
}