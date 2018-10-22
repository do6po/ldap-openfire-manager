<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 10.10.18
 * Time: 12:40
 */

namespace App\Models\LDAP;


use App\Exceptions\Model\LDAP\CreateOrganizationalUnitException;
use App\Exceptions\Model\LDAP\DCNotFoundException;
use App\Exceptions\Model\LDAP\OrganizationalUnitExistException;
use App\Models\LDAP\Attributes\DistinguishedName;

class OrganizationalUnitFactory
{
    /**
     * @var OrganizationalUnit[]
     */
    protected static $repository = [];

    /**
     * @param string $dnString
     * @return OrganizationalUnit
     * @throws CreateOrganizationalUnitException
     * @throws DCNotFoundException
     * @throws OrganizationalUnitExistException
     */
    public static function findOrCreateByDnString(string $dnString)
    {
        return self::findOrCreate(DistinguishedName::createByDnString($dnString));
    }

    /**
     * @param DistinguishedName $dn
     * @return OrganizationalUnit
     * @throws OrganizationalUnitExistException
     * @throws CreateOrganizationalUnitException
     * @throws DCNotFoundException
     */
    public static function findOrCreate(DistinguishedName $dn): OrganizationalUnit
    {
        if ($ou = self::getByKey($dn)) {
            return $ou;
        }

        return self::createByDn($dn);
    }

    /**
     * @param string $key
     * @return OrganizationalUnit|bool
     */
    public static function getByKey(string $key)
    {
        if (self::exists($key)) {
            return self::$repository[$key];
        }

        return false;
    }

    /**
     * @param DistinguishedName $dn
     * @return OrganizationalUnit
     * @throws OrganizationalUnitExistException
     * @throws CreateOrganizationalUnitException
     * @throws DCNotFoundException
     */
    public static function createByDn(DistinguishedName $dn): OrganizationalUnit
    {
        $ou = OrganizationalUnit::createByDn($dn);
        self::add($ou);

        if ($dn->countNestingLevel() > 1) {
            $parentOu = self::findOrCreate($dn->getParentDn());
            $parentOu->add($ou);
        }

        return $ou;
    }

    /**
     * @param OrganizationalUnit $ou
     * @throws OrganizationalUnitExistException
     */
    public static function add(OrganizationalUnit $ou)
    {
        $dnString = $ou->getDnString();
        if (self::exists($dnString)) {
            throw new OrganizationalUnitExistException(
                sprintf('Organizational unit with name %s - exist!', $dnString)
            );
        }

        self::$repository[$dnString] = $ou;
    }

    public static function exists(string $key): bool
    {
        return array_key_exists($key, self::$repository);
    }

    public static function cleanOut(): void
    {
        self::$repository = [];
    }

    public static function getAll(): array
    {
        return self::$repository;
    }
}