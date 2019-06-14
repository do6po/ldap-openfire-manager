<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 22.10.18
 * Time: 11:44
 */

namespace App\Models\LDAP;


class ProcessedRoster implements \Countable, \ArrayAccess
{
    /**
     * @var self[]
     */
    protected $roster = [];

    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * @param array $collection
     * @return ProcessedRoster
     */
    public static function create(array $collection)
    {
        $processedRoster = new self;

        foreach ($collection as $item) {
            if ($item->countUsers()) {
                $processedRoster->pushUsers($item->getUsers());
            }
        }

        return $processedRoster;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->roster);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->roster[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->roster[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->roster[$offset] = $value;
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        unset($this->roster[$offset]);
    }

    /**
     * @param LdapUser[] $users
     */
    private function pushUsers($users): void
    {
        foreach ($users as $user) {
            $this->roster[$user->getName()] = $user;
        }
    }
}