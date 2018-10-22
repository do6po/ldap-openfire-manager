<?php

namespace Tests\Unit\app\Models\LDAP\Attributes;

use App\Models\LDAP\Attributes\DistinguishedName;
use Tests\TestCase;

class DistinguishedNameTest extends TestCase
{
    protected $dnString = 'CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';

    /**
     * @var DistinguishedName
     */
    protected $dnObject;


    public function setUp()
    {
        parent::setUp();

        $this->dnObject = DistinguishedName::createByDnString($this->dnString);
    }

    public function testString()
    {
        $this->assertEquals($this->dnString, $this->dnObject);
    }

    /**
     * @param $dn
     * @param $expected
     * @dataProvider countNestingLevelDataProvider
     */
    public function testCountNestingLevel($dn, $expected)
    {
        $dnObject = DistinguishedName::createByDnString($dn);
        $this->assertEquals($expected, $dnObject->countNestingLevel());
    }

    public function countNestingLevelDataProvider()
    {
        return [
            ['CN=Имя пользователя,OU=Уровень ниже,OU=Уровень выше,DC=domain,DC=local', 2],
            ['OU=Уровень ниже,OU=Уровень выше,DC=domain,DC=local', 2],
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', 3],
            ['CN=Имя пользователя,OU=Root level,DC=domain,DC=local', 1],
        ];
    }

    /**
     * @param $dn
     * @param $expected
     * @dataProvider getOuAsArrayDataProvider
     */
    public function testGetOuAsArray($dn, $expected)
    {
        $dnObject = DistinguishedName::createByDnString($dn);
        $this->assertEquals($expected, $dnObject->getOuAsArray());
    }

    public function getOuAsArrayDataProvider()
    {
        return [
            ['CN=Имя пользователя,OU=Уровень ниже,OU=Уровень выше,DC=domain,DC=local', [
                1 => 'Уровень выше',
                2 => 'Уровень ниже',
            ]],
            ['OU=Уровень ниже,OU=Уровень выше,DC=domain,DC=local', [
                1 => 'Уровень выше',
                2 => 'Уровень ниже',
            ]],
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', [
                1 => 'Root level',
                2 => 'Node level',
                3 => 'Leaf level',
            ]],
            ['CN=Имя пользователя,OU=Root level,DC=domain,DC=local', [
                1 => 'Root level',
            ]],
        ];
    }

    /**
     * @param $dnString
     * @param $expected
     * @throws \App\Exceptions\Model\LDAP\DCNotFoundException
     * @dataProvider getDomainComponentsStringDataProvider
     */
    public function testGetRootDomainNamingContext($dnString, $expected)
    {
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertEquals($expected, $dn->getRootDomainNamingContext());
    }

    public function getDomainComponentsStringDataProvider()
    {
        return [
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', 'DC=domain,DC=local'],
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,dc=domain,dc=local', 'dc=domain,dc=local'],
        ];
    }

    /**
     * @param $dnString
     * @param $expected
     * @dataProvider getCommonNameDataProvider
     */
    public function testGetCommonName($dnString, $expected)
    {
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertEquals($expected, $dn->getCommonName());
    }

    public function getCommonNameDataProvider()
    {
        return [
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', 'Имя пользователя'],
            ['cn=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,dc=domain,dc=local', 'Имя пользователя'],
            ['OU=Leaf level,OU=Node level,OU=Root level,dc=domain,dc=local', ''],
        ];
    }

    /**
     * @param $dnString
     * @param $nestingLevel
     * @param $expected
     * @throws \App\Exceptions\Model\LDAP\DCNotFoundException
     * @throws \App\Exceptions\Model\LDAP\OuNestedLevelException
     * @dataProvider trimToNestingLevelDataProvider
     */
    public function testTrimToNestingLevel($dnString, $nestingLevel, $expected)
    {
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertEquals($expected, $dn->trimToNestingLevel($nestingLevel));
    }

    public function trimToNestingLevelDataProvider()
    {
        return [
            [
                'CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local',
                1,
                'OU=Root level,DC=domain,DC=local'
            ],
            [
                'CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local',
                2,
                'OU=Node level,OU=Root level,DC=domain,DC=local'
            ],
            [
                'CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local',
                3,
                'OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local'
            ],
        ];
    }

    /**
     * @param $dnString
     * @param $expected
     * @dataProvider getCurrentOrganizationalUnitDataProvider
     */
    public function testGetCurrentOrganizationalUnit($dnString, $expected)
    {
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertEquals($expected, $dn->getCurrentOrganizationalUnit());
    }

    public function getCurrentOrganizationalUnitDataProvider()
    {
        return [
            [
                'CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local',
                'Leaf level'
            ],
            [
                'ou=Node level,ou=Root level,dc=domain,dc=local',
                'Node level'
            ],
        ];
    }

    public function testCreateByDnString()
    {
        $dnString = 'CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';
        $dn = DistinguishedName::createByDnString($dnString);

        $identicalDn = new DistinguishedName();
        $identicalDn->setDn($dnString);

        $this->assertEquals($identicalDn, $dn);
    }

    /**
     * @throws \App\Exceptions\Model\LDAP\DCNotFoundException
     */
    public function testGetParent()
    {
        $dnString = 'CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';
        $dn = DistinguishedName::createByDnString($dnString);

        $parentDnString = 'OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local';
        $parentDn = DistinguishedName::createByDnString($parentDnString);

        $this->assertEquals($parentDn, $dn->getParentDn());

    }

    /**
     * @param $dnString
     * @param $expected
     * @dataProvider isOrganizationalUnitDataProvider
     */
    public function testIsOrganizationalUnit($dnString, $expected)
    {
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertEquals($expected, $dn->isOrganizationalUnit());
    }

    public function isOrganizationalUnitDataProvider()
    {
        return [
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', false],
            ['OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', true],
            ['DC=domain,DC=local', false],
        ];
    }

    /**
     * @param $dnString
     * @param $expected
     * @dataProvider isCommonNameUnitDataProvider
     */
    public function testIsCommonName($dnString, $expected)
    {
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertEquals($expected, $dn->isCommonName());
    }

    public function isCommonNameUnitDataProvider()
    {
        return [
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', true],
            ['OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', false],
            ['DC=domain,DC=local', false],
        ];
    }

    /**
     * @param $dnString
     * @param $expected
     * @dataProvider isDomainComponentDataProvider
     */
    public function testIsDomainComponent($dnString, $expected)
    {
        $dn = DistinguishedName::createByDnString($dnString);
        $this->assertEquals($expected, $dn->isDomainComponent());
    }

    public function isDomainComponentDataProvider()
    {
        return [
            ['CN=Имя пользователя,OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', false],
            ['OU=Leaf level,OU=Node level,OU=Root level,DC=domain,DC=local', false],
            ['DC=domain,DC=local', true],
        ];
    }
}
