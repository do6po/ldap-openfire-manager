<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 25.09.18
 * Time: 12:25
 */

namespace Tests\Unit\app\Services\LDAP;


use App\Services\LDAP\LDAPService;
use app\Services\LDAP\NotFoundRosterPathException;
use Tests\Helpers\PrivateMethodTrait;
use Tests\TestCase;

class LDAPServiceTest extends TestCase
{
    use PrivateMethodTrait;

    /**
     * @var LDAPService
     */
    protected $service;


    public function setUp()
    {
        parent::setUp();
        $this->service = app()->make(LDAPService::class);
    }

    /**
     * @param $dn
     * @param $userName
     * @param $rawFilter
     * @param $rawDnPath
     * @throws \ReflectionException
     * @dataProvider getRawDnPathDataProvider
     */
    public function testGetRawDnPath($dn, $userName, $rawFilter, $rawDnPath)
    {
        $method = $this->makePublicMethod(LDAPService::class, 'getRawDnPath');

        $this->assertEquals(
            $rawDnPath,
            $method->invoke($this->service, $dn, $userName, $rawFilter)
        );
    }

    public function getRawDnPathDataProvider()
    {
        return [
            [
                'CN=test_user,OU=Бюро тестов,OU=Отдел тестирования,OU=Программисты,OU=Текущий ростер,DC=domain,DC=local',
                'test_user',
                'OU=Текущий ростер,DC=domain,DC=local',
                'OU=Бюро тестов,OU=Отдел тестирования,OU=Программисты',
            ],
            [
                'CN=test_user2,OU=Бюро верстальщиков,OU=Отдел программирования,OU=Программисты,OU=Текущий ростер,DC=domain,DC=local',
                'test_user2',
                'OU=Текущий ростер,DC=domain,DC=local',
                'OU=Бюро верстальщиков,OU=Отдел программирования,OU=Программисты',
            ],
            'with different register' => [
                'CN=test_user2,OU=Бюро верстальщиков,OU=Отдел программирования,OU=Программисты,OU=Текущий ростер,DC=domain,DC=local',
                'test_user2',
                'ou=Текущий ростер,dc=domain,dc=local',
                'OU=Бюро верстальщиков,OU=Отдел программирования,OU=Программисты',
            ],
        ];
    }

    /**
     * @param $dnPathString
     * @param $expected
     * @throws \ReflectionException
     * @dataProvider getNestedByDnPathArrayDataProvider
     */
    public function testGetNestedByDnPathArray($dnPathString, $expected)
    {
        $method = $this->makePublicMethod(LDAPService::class, 'getNestedByDnPathArray');

        $this->assertEquals(
            $expected,
            $method->invoke($this->service, $dnPathString)
        );
    }

    public function getNestedByDnPathArrayDataProvider()
    {
        return [
            [
                [
                    'Программисты',
                    'Отдел тестирования',
                    'Бюро тестов',
                ],
                [
                    'Программисты' => [
                        'Отдел тестирования' => [
                            'Бюро тестов' => [],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $dn
     * @param $expected
     * @throws \ReflectionException
     * @dataProvider normalizeDnDataProvider
     */
    public function testNormalizeDn($dn, $expected)
    {
        $method = $this->makePublicMethod(LDAPService::class, 'normalizeDn');

        $this->assertEquals(
            $expected,
            $method->invoke($this->service, $dn)
        );
    }

    public function normalizeDnDataProvider()
    {
        return [
            [
                'OU=Бюро тестов,OU=Отдел тестирования,OU=Программисты',
                [
                    'Программисты',
                    'Отдел тестирования',
                    'Бюро тестов',
                ],
            ],
            [
                'OU=Бюро верстальщиков,OU=Отдел программирования,OU=Программисты',
                [
                    'Программисты',
                    'Отдел программирования',
                    'Бюро верстальщиков',
                ],
            ],
        ];
    }

    /**
     * @param $rosterArray
     * @param $partOfRoster
     * @param $expected
     * @throws \ReflectionException
     * @dataProvider pushToRosterArrayDataProvider
     */
    public function testPushToRosterArray($rosterArray, $partOfRoster, $expected)
    {
        $method = $this->makePublicMethod(LDAPService::class, 'pushToRosterArray');

        $this->assertEquals(
            $expected,
            $method->invoke($this->service, $rosterArray, $partOfRoster)
        );
    }

    public function pushToRosterArrayDataProvider()
    {
        return [
            [
                [
                    'Программисты' => [],
                ],
                [
                    'HR менеджеры' => [],
                ],
                [
                    'Программисты' => [],
                    'HR менеджеры' => [],
                ],
            ],
            [
                [
                    'Программисты' => [
                        'Отдел программирования' => [
                            'Бюро верстальщиков' => [],
                        ],
                        'Отдел тестирования' => [
                            'Бюро тестов' => [],
                        ],
                    ],
                ],
                [
                    'Программисты' => [
                        'Отдел программирования' => [
                            'Бюро архитекторов' => [],
                        ],
                    ],
                ],
                [
                    'Программисты' => [
                        'Отдел программирования' => [
                            'Бюро верстальщиков' => [],
                            'Бюро архитекторов' => [],
                        ],
                        'Отдел тестирования' => [
                            'Бюро тестов' => [],
                        ],
                    ],
                ],

            ],
        ];
    }

    /**
     * @param $roster
     * @param $path
     * @param $value
     * @param $expected
     * @throws NotFoundRosterPathException
     * @dataProvider pushUserToRosterDataProvider
     */
    public function testPushUserToRoster($roster, $path, $value, $expected)
    {
        $this->assertEquals($expected, $this->service->pushUserToRoster($roster, $path, $value));
    }

    public function pushUserToRosterDataProvider()
    {
        return [
            [
                [], [], 'user1(Юзервой Юзерий Юзерович)', ['user1(Юзервой Юзерий Юзерович)'],
            ],
            [
                ['Программисты' => []],
                [
                    'Программисты'
                ],
                'user1(Юзервой Юзерий Юзерович)',
                [
                    'Программисты' => [
                        'user1(Юзервой Юзерий Юзерович)',
                    ],
                ],
            ],
            [
                [
                    'Программисты' => [
                        'Отдел программирования' => [
                            'Бюро верстальщиков' => [],
                            'Бюро архитекторов' => [],
                        ],
                        'Отдел тестирования' => [
                            'Бюро тестов' => [],
                        ],
                    ],
                ],
                [
                    'Программисты',
                    'Отдел программирования',
                    'Бюро верстальщиков',
                ],
                'user1(Юзервой Юзерий Юзерович)',
                [
                    'Программисты' => [
                        'Отдел программирования' => [
                            'Бюро верстальщиков' => [
                                'user1(Юзервой Юзерий Юзерович)',
                            ],
                            'Бюро архитекторов' => [],
                        ],
                        'Отдел тестирования' => [
                            'Бюро тестов' => [],
                        ],
                    ],
                ],

            ],
        ];
    }
}