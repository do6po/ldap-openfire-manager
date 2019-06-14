<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.08.18
 * Time: 13:00
 */

namespace App\Services\LDAP;


use App\Drivers\LDAP\LDAPConnection;
use App\Exceptions\Model\LDAP\CreateOrganizationalUnitException;
use App\Exceptions\Model\LDAP\DCNotFoundException;
use App\Exceptions\Model\LDAP\OrganizationalUnitExistException;
use App\Models\LDAP\Attributes\DistinguishedName;
use App\Models\LDAP\LDAP;
use App\Models\LDAP\LdapUser;
use App\Models\LDAP\OrganizationalUnit;
use App\Models\LDAP\OrganizationalUnitFactory;
use App\Models\LDAP\Roster;
use App\Models\LDAP\UserMapper;

class LDAPService
{
    /**
     * @var LDAPConnection
     */
    protected $connection;

    public function __construct(LDAPConnection $connection)
    {
        $this->connection = $connection;
    }

    public function test(LDAP $server)
    {
        return $this->connection->test($server);
    }

    /**
     * @param LDAP $server
     * @param Roster $roster
     * @return OrganizationalUnit[]
     * @throws OrganizationalUnitExistException
     * @throws \App\Drivers\LDAP\LDAPConnectException
     * @throws CreateOrganizationalUnitException
     * @throws DCNotFoundException
     */
    public function getRoster(LDAP $server, Roster $roster)
    {
        $provider = $this->connection->connect($server, $roster);

        $array = $provider
            ->search()
            ->rawFilter($roster->users_group)
            ->whereHas('cn')
            ->sortBy('cn')
            ->get();

        $ldapUsers = UserMapper::map($array);

        return $this->getRosterAsArray($ldapUsers, $roster);
    }

    /**
     * @param LdapUser[] $ldapUsers
     * @param Roster $roster
     * @return OrganizationalUnit[]
     * @throws OrganizationalUnitExistException
     * @throws CreateOrganizationalUnitException
     * @throws DCNotFoundException
     */
    private function getRosterAsArray($ldapUsers, Roster $roster)
    {
        foreach ($ldapUsers as $user) {
            $dn = DistinguishedName::createByDnString($user->getDn());
            $currentOu = OrganizationalUnitFactory::findOrCreateByDnString($dn->getParentDn());
            $currentOu->addUser($user);
        }

        return OrganizationalUnitFactory::findOrCreateByDnString($roster->roster_path)->getNested();
    }
}