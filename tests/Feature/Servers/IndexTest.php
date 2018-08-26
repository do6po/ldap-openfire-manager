<?php

namespace Tests\Feature\Servers;

use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\ServerFixture;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexTest extends TestCase
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

    /**
     * @throws \LaravelFlux\Fixture\Exceptions\InvalidConfigException
     */
    public function testIndex(): void
    {
        $result = $this->get('/ldap');
        $result->assertOk();
        $result->assertSeeText('Company name');

        $servers = $this->getFixture('servers');
        $orderData = [];

        foreach ($servers as $server) {
            $orderData[] = $server['name'];
        }

        $result->assertSeeTextInOrder($orderData);
    }
}
