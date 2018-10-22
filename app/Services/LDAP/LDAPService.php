<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.08.18
 * Time: 13:00
 */

namespace App\Services\LDAP;


use Adldap\Models\User;
use App\Drivers\LDAP\LDAPConnection;
use App\Exceptions\Model\LDAP\CreateOrganizationalUnitException;
use App\Exceptions\Model\LDAP\DCNotFoundException;
use App\Exceptions\Model\LDAP\OrganizationalUnitExistException;
use App\Models\LDAP\Attributes\DistinguishedName;
use App\Models\LDAP\LDAP;
use App\Models\LDAP\OrganizationalUnitFactory;
use App\Models\LDAP\Roster;

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
     * @return \App\Models\LDAP\OrganizationalUnit[]|array
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

        return $this->getRosterAsArray($array, $roster);
    }

    /**
     * @param User[] $users
     * @param Roster $roster
     * @return \App\Models\LDAP\OrganizationalUnit[]|array
     * @throws OrganizationalUnitExistException
     * @throws CreateOrganizationalUnitException
     * @throws DCNotFoundException
     */
    private function getRosterAsArray($users, Roster $roster)
    {
        foreach ($users as $user) {
            $dn = DistinguishedName::createByDnString($user->getDn());
            $parentDn = $dn->getParentDn();
            $currentOu = OrganizationalUnitFactory::findOrCreateByDnString($parentDn);
            $currentOu->addUser($user);
        }

        return OrganizationalUnitFactory::findOrCreateByDnString($roster->roster_path)->getNested();
    }
}