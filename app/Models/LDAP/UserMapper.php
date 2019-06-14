<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 22.10.18
 * Time: 13:36
 */

namespace App\Models\LDAP;


use Adldap\Models\User;

class UserMapper
{
    /**
     * @param User[] $users
     * @param AliasesCollection $aliases
     * @return LdapUser[]
     */
    public static function map(array $users, AliasesCollection $aliases): array
    {
        $result = [];

        foreach ($users as $user) {
            $result[] = new LdapUser($user, $aliases);
        }

        return $result;
    }
}