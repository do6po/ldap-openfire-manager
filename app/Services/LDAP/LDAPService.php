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
use Illuminate\Support\Collection;

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
     * @return array
     * @throws NotFoundRosterPathException
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
     * @param User[]|Collection $users
     * @param Roster $roster
     * @return array
     * @throws NotFoundRosterPathException
     */
    private function getRosterAsArray($users, Roster $roster)
    {
        $rosterArray = [];

        foreach ($users as $user) {
            $dnPathString = $this->getRawDnPath(
                $user->getDn(),
                $user->getName(),
                $roster->roster_path
            );

            $dnPathArray = $this->normalizeDn($dnPathString);
            $partOfRoster = $this->getNestedByDnPathArray($dnPathArray);

            $this->pushUserToRoster($partOfRoster, $dnPathArray, $user->getName());

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

    private function getNestedByDnPathArray(array $dnArray): array
    {
        $result = [];
        if (count($dnArray) > 0) {
            $ou = array_shift($dnArray);
            $result[$ou] = $this->getNestedByDnPathArray($dnArray);
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
            if (is_array($subRoster)) {
                $this->rosterSort($subRoster);
            }
        }

        ksort($roster, SORT_STRING);

        return $roster;
    }

    /**
     * @param array $roster
     * @param array $path
     * @param string $userName
     * @return array
     * @throws NotFoundRosterPathException
     */
    public function pushUserToRoster(array &$roster, array $path, string $userName): array
    {
        if (count($path) == 0) {
            $roster[] = $userName;

            return $roster;
        }

        $pathname = array_shift($path);

        if (!isset($roster[$pathname])) {
            throw new NotFoundRosterPathException('Not found path with name: ' . $pathname);
        }

        $result = $this->pushToRosterArray(
            $roster,
            [$pathname => $this->pushUserToRoster($roster[$pathname], $path, $userName)]
        );

        return $result;
    }
}