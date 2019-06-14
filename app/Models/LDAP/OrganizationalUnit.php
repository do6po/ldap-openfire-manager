<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 10.10.18
 * Time: 12:31
 */

namespace App\Models\LDAP;


use App\Exceptions\Model\LDAP\CreateOrganizationalUnitException;
use App\Models\LDAP\Attributes\DistinguishedName;

class OrganizationalUnit
{
    /**
     * @var DistinguishedName
     */
    protected $dn;

    /**
     * @var self[]
     */
    protected $nested = [];

    /**
     * @var LdapUser[]
     */
    protected $users = [];

    /**
     * OrganizationalUnit constructor.
     * @param DistinguishedName $dn
     * @throws CreateOrganizationalUnitException
     */
    public function __construct(DistinguishedName $dn)
    {
        $this->dn = $dn;

        if (!$this->validate()) {
            throw new CreateOrganizationalUnitException(
                sprintf(
                    'Distinguished name: "%s" - does not indicate the required object',
                    $this->dn->getDnString()
                )
            );
        }
    }

    /**
     * @param string $dnString
     * @return OrganizationalUnit
     * @throws CreateOrganizationalUnitException
     */
    public static function createByDnString(string $dnString): self
    {
        return self::createByDn(DistinguishedName::createByDnString($dnString));
    }

    /**
     * @param DistinguishedName $dn
     * @return OrganizationalUnit
     * @throws CreateOrganizationalUnitException
     */
    public static function createByDn(DistinguishedName $dn): self
    {
        return new self($dn);
    }

    public function getName(): string
    {
        return $this->dn->getCurrentOrganizationalUnit();
    }

    public function getDn()
    {
        return $this->dn;
    }

    public function getDnString()
    {
        return $this->dn->getDnString();
    }

    /**
     * @return self[]
     */
    public function getNested(): array
    {
        return $this->nested;
    }

    public function add(self $ou): void
    {
        $this->nested[$ou->getName()] = $ou;
        $this->sortNested();
    }

    public function addUser(LdapUser $user): void
    {
        $this->users[] = $user;
        $this->sortUsers();
    }

    /**
     * @return LdapUser[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }

    public function countUsers(): int
    {
        return count($this->users);
    }

    protected function validate(): bool
    {
        return $this->dn->isOrganizationalUnit();
    }

    protected function sortNested(): void
    {
        ksort($this->nested, SORT_STRING);
    }

    protected function sortUsers(): void
    {
        sort($this->users, SORT_STRING);
    }
}