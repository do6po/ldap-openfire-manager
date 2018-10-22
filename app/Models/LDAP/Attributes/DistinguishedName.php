<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 17.10.18
 * Time: 11:59
 */

namespace App\Models\LDAP\Attributes;


use App\Exceptions\Model\LDAP\DCNotFoundException;
use App\Exceptions\Model\LDAP\OuNestedLevelException;

class DistinguishedName
{

    const CN_STRING = 'cn';
    const OU_STRING = 'ou';
    const DC_STRING = 'dc';

    /**
     * @var string
     */
    protected $dn;

    public static function createByDnString($dnString): self
    {
        $dn = new self();
        $dn->setDn($dnString);

        return $dn;
    }

    public function setDn(string $dn): self
    {
        $this->dn = $dn;

        return $this;
    }

    public function getDnString(): string
    {
        return $this->dn;
    }

    public function __toString(): string
    {
        return $this->getDnString();
    }

    public function countNestingLevel(): int
    {
        return substr_count(strtolower($this->getDnString()), 'ou=');
    }

    public function getOuAsArray(): array
    {
        $result = [];
        $reversedArray = array_reverse(
            array_filter(explode(',', $this->dn), function (string $string) {
                return preg_match('/ou=/i', $string);
            })
        );

        $level = 0;

        foreach ($reversedArray as $ou) {
            if (preg_match('/^ou=(?<ou>.*)$/i', $ou, $matches)) {
                $level++;
                $result[$level] = $matches['ou'];
            }
        }

        return $result;
    }

    /**
     * @return string
     * @throws DCNotFoundException
     */
    public function getRootDomainNamingContext(): string
    {
        if (preg_match('/\,(?<dcString>dc=.*)$/i', $this->getDnString(), $matches)) {
            return $matches['dcString'];
        }

        throw new DCNotFoundException('Not found domain components in dn: ' . $this->getDnString());
    }

    /**
     * @param $nestingLevel
     * @return string
     * @throws DCNotFoundException
     * @throws OuNestedLevelException
     */
    public function trimToNestingLevel($nestingLevel): string
    {
        if ($nestingLevel > $this->countNestingLevel()) {
            throw new OuNestedLevelException(sprintf('requested nesting level (%s) is greater than possible(%s)', $nestingLevel, $this->countNestingLevel()));
        }

        $result = $this->getRootDomainNamingContext();

        foreach ($this->getOuAsArray() as $level => $ouName) {
            if ($level <= $nestingLevel) {
                $result = sprintf('OU=%s,%s', $ouName, $result);
            } else {
                break;
            }
        }

        return $result;
    }

    public function getCommonName(): string
    {
        if (preg_match('/^cn=(?<cnString>.*?)\,/i', $this->getDnString(), $matches)) {
            return $matches['cnString'];
        }

        return '';
    }

    public function getCurrentOrganizationalUnit(): string
    {
        $ouArray = $this->getOuAsArray();
        return array_pop($ouArray);
    }

    /**
     * @return DistinguishedName
     * @throws DCNotFoundException
     */
    public function getParentDn(): self
    {
        if (preg_match('/\=.*?,(?<parentDn>.*$)/', $this->getDnString(), $matches)) {
            return self::createByDnString($matches['parentDn']);
        }

        throw new DCNotFoundException(sprintf('Not found parent dn in string: ', $this->getDnString()));
    }

    public function isOrganizationalUnit(): bool
    {
        return $this->validateType(self::OU_STRING);
    }

    public function isCommonName(): bool
    {
        return $this->validateType(self::CN_STRING);
    }

    public function isDomainComponent(): bool
    {
        return $this->validateType(self::DC_STRING);
    }

    private function validateType($string): bool
    {
        return preg_match("/^$string\=/i", $this->getDnString());
    }
}