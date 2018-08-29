<?php

namespace Tests\Feature\LDAP;

use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\LDAPFixture;
use Tests\Helpers\AuthTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
{
    use RefreshDatabase, FixtureTrait, AuthTrait;

    const URI = '/ldap';

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
            'servers' => LDAPFixture::class,
        ];
    }

    public function testRedirectForNonAuth(): void
    {
        $response = $this->get(self::URI);
        $response->assertRedirect('/login');
    }

    /**
     * @throws \LaravelFlux\Fixture\Exceptions\InvalidConfigException
     */
    public function testIndex(): void
    {
        $this->login();

        $response = $this->get(self::URI);
        $response->assertOk();
        $response->assertSeeText('Company name');

        $servers = $this->getFixture('servers');
        $orderData = [];

        foreach ($servers as $server) {
            $orderData[] = $server['name'];
        }

        $response->assertSeeTextInOrder($orderData);
    }
}
