<?php

namespace Tests\Unit\app\Models\LDAP;

use App\Models\LDAP\Attributes\DistinguishedName;
use App\Models\LDAP\OrganizationalUnit;
use App\Models\LDAP\OrganizationalUnitFactory;
use Tests\TestCase;

class OrganizationalUnitFactoryTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        OrganizationalUnitFactory::cleanOut();
    }

    /**
     * @throws \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     * @throws \App\Exceptions\Model\LDAP\DCNotFoundException
     * @throws \App\Models\LDAP\OrganizationalUnitExistException
     */
    public function testCreateByDn()
    {
        $ou = OrganizationalUnitFactory::createByDn(
            DistinguishedName::createByDnString('OU=Уровень ниже,OU=Увроень выше,DC=domain,DC=local')
//            DistinguishedName::createByDnString('CN=Имя пользователя,OU=Уровень ниже,OU=Увроень выше,DC=domain,DC=local')
        );

        $this->assertInstanceOf(OrganizationalUnit::class, $ou);
        $this->assertEquals('Уровень ниже', $ou->getName());
    }

    /**
     * @throws \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     * @throws \App\Exceptions\Model\LDAP\DCNotFoundException
     * @throws \App\Models\LDAP\OrganizationalUnitExistException
     */
    public function testExist()
    {
        $dnString = 'OU=Уровень ниже,OU=Увроень выше,DC=domain,DC=local';
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertFalse(OrganizationalUnitFactory::exists($dnString));

        OrganizationalUnitFactory::createByDn($dn);
        $this->assertTrue(OrganizationalUnitFactory::exists($dnString));
    }

    /**
     * @throws \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     * @throws \App\Models\LDAP\OrganizationalUnitExistException
     */
    public function testAdd()
    {
        $dnString = 'OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';
        $ou = OrganizationalUnit::createByDnString($dnString);
        OrganizationalUnitFactory::add($ou);

        $this->assertEquals([$dnString => $ou], OrganizationalUnitFactory::getAll());
    }

    /**
     * @throws \App\Exceptions\Model\LDAP\CreateOrganizationalUnitException
     * @throws \App\Exceptions\Model\LDAP\DCNotFoundException
     * @throws \App\Models\LDAP\OrganizationalUnitExistException
     */
    public function testFindOrCreateTwoLevels()
    {
        $dnString = 'OU=Node level,OU=Root level,DC=domain,DC=local';
        $ou = OrganizationalUnitFactory::findOrCreateByDnString($dnString);

        $dnDeepString = 'OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';
        $dnDeep = DistinguishedName::createByDnString($dnDeepString);
        $ouDeepExpected = OrganizationalUnitFactory::findOrCreate($dnDeep);

        $this->assertEquals(['Leaf level' => $ouDeepExpected], $ou->getNested());
    }
}
