<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 27.08.18
 * Time: 12:33
 */

namespace App\Http\Controllers\LDAP;


use App\Helpers\FlashMessageHelper;
use App\Http\Controllers\Controller;
use App\Models\LDAP\LDAP;
use App\Services\LDAP\LDAPService;

class TestConnectionController extends Controller
{
    /**
     * @var LDAPService
     */
    private $LDAPService;

    public function __construct(LDAPService $LDAPService)
    {
        $this->LDAPService = $LDAPService;
    }

    /**
     * @param LDAP $server
     * @return \Illuminate\Http\RedirectResponse
     */
    public function test(LDAP $server)
    {
        if ($this->LDAPService->test($server)) {
            FlashMessageHelper::success(
                __('Connection successful.')
            );
        } else {
            FlashMessageHelper::error(
                __('Connection error.')
            );
        }

        return redirect()->route('ldap.show', $server);
    }
}