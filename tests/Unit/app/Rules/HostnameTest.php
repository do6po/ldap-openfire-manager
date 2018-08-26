<?php

namespace Tests\Unit\app\Rules;

use App\Rules\Hostname;
use Tests\Helpers\PrivateMethodTrait;
use Tests\TestCase;

class HostnameTest extends TestCase
{
    use PrivateMethodTrait;

    /**
     * @var Hostname
     */
    protected $rule;

    protected $attribute = 'hostname';

    public function setUp()
    {
        parent::setUp();

        $this->rule = new Hostname();
    }

    /**
     * @param $value
     * @param $expected
     * @dataProvider validationDataProvider
     */
    public function testValidation($value, $expected)
    {
        $this->assertEquals($expected, $this->rule->passes($this->attribute, $value));
    }

    public function validationDataProvider()
    {
        return [
            ['192.168.1.1', true],
            ['8.8.8.8', true],
            ['domain.local', true],
            ['domain.loc', true],
            ['google.com.ua', true],
            ['google_com', false],
        ];
    }

    /**
     * @param $value
     * @param $expected
     * @throws \ReflectionException
     * @dataProvider isIpAddressDataProvider
     */
    public function testIsIpAddress($value, $expected)
    {
        $method = $this->makePublicMethod(Hostname::class, 'isIpAddress');
        $this->assertEquals($expected, $method->invoke($this->rule, $value));
    }

    public function isIpAddressDataProvider()
    {
        return [
            ['192.168.1.1', true],
            ['1.1.1.1', true],
            ['1.255.2.254', true],
            ['192.168.256.1', false],
            ['255.255.255', false],
        ];
    }

    /**
     * @param $value
     * @param $expected
     * @throws \ReflectionException
     * @dataProvider isHostnameDataProvider
     */
    public function testIsHostname($value, $expected)
    {
        $method = $this->makePublicMethod(Hostname::class, 'isHostname');
        $this->assertEquals($expected, $method->invoke($this->rule, $value));
    }

    public function isHostnameDataProvider()
    {
        return [
            ['localhost', true],
            ['google.com.ua', true],
            ['localdomain.loc', true],
            ['localdomain.local', true],
            ['failed domain', false],
        ];
    }
}
