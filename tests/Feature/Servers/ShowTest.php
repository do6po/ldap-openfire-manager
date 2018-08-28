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
use Tests\Helpers\AuthTrait;
use Tests\TestCase;

class ShowTest extends TestCase
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

    public function testShow(): void
    {
        $this->login();

        $result = $this->get(self::URI);
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