<?php

namespace Tests\Unit\app\Models\LDAP;

use App\Models\LDAP\OrganizationalUnit;
use Tests\Helpers\PrivateMethodTrait;
use Tests\TestCase;

class OrganizationalUnitTest extends TestCase
{
    use PrivateMethodTrait;

    /**
     * @throws \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     */
    public function testGetName()
    {
        $dnString = 'OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';
        $ou = OrganizationalUnit::createByDnString($dnString);

        $this->assertEquals('Leaf level', $ou->getName());
    }

    /**
     * @throws \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     */
    public function testAddOu()
    {
        $dnString = 'OU=Node level,OU=Root level,DC=domain,DC=local';
        $ou = OrganizationalUnit::createByDnString($dnString);

        $nestedDnString = 'OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';
        $nestedOu = OrganizationalUnit::createByDnString($nestedDnString);

        $ou->add($nestedOu);
        $this->assertEquals(['Leaf level' => $nestedOu], $ou->getNested());
    }

    /**
     * @param $dnString
     * @throws \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     * @expectedException \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     * @dataProvider createException
     */
    public function testCreateException($dnString)
    {
        $this->assertTrue(true);
        OrganizationalUnit::createByDnString($dnString);
    }

    public function createException()
    {
        return [
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local'],
            ['DC=domain,DC=local']
        ];
    }
}
