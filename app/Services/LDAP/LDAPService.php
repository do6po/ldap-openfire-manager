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
use App\Models\LDAP\LDAP;
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
     * @return null
     * @throws \App\Drivers\LDAP\LDAPConnectException
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
     * @return null
     */
    private function getRosterAsArray($users, Roster $roster)
    {
        $rosterArray = [];

        foreach ($users as $value) {
            $dnPathString = $this->getRawDnPath(
                $value->getDn(),
                $value->getName(),
                $roster->roster_path
            );

            $dnArray = $this->normalizeDn($dnPathString);
            $partOfRoster = $this->getNestedByDnPathString($dnArray);

            $rosterArray = $this->pushToRosterArray($rosterArray, $partOfRoster);
        }

        return $this->rosterSort($rosterArray);
    }

    private function getRawDnPath(string $dn, string $userName, string $rawFilter): string
    {
        $result = str_ireplace('CN=' . $userName, '', $dn);
        $result = str_ireplace($rawFilter, '', $result);

        return trim($result, ',');
    }

    private function normalizeDn(string $dnPathString): array
    {
        $array = explode(',', str_ireplace(['OU=', 'ou='], '', $dnPathString));

        return array_reverse($array);
    }

    private function getNestedByDnPathString(array $dnArray): array
    {
        $result = [];
        if (count($dnArray) > 0) {
            $ou = array_shift($dnArray);
            $result[$ou] = $this->getNestedByDnPathString($dnArray);
        }

        return $result;
    }

    private function pushToRosterArray(array $roster, array $partOfRoster): array
    {
        return array_merge_recursive($roster, $partOfRoster);
    }

    private function rosterSort(array &$roster): array
    {
        foreach ($roster as &$subRoster) {
            $this->rosterSort($subRoster);
        }

        ksort($roster, SORT_STRING);

        return $roster;
    }
}