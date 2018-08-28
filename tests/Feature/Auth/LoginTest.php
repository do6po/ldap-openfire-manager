<?php

namespace Tests\Feature\Auth;

use LaravelFlux\Fixture\Traits\FixtureTrait;
use Tests\Fixtures\UserFixture;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase, FixtureTrait;

    protected $uri = '/login';

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
            'users' => UserFixture::class,
        ];
    }


    public function testLoginPage()
    {
        $response = $this->get($this->uri);

        $response->assertOk();
    }
}
