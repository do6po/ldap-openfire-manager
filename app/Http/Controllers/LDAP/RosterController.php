<?php
/**
 * Created by PhpStorm.
 * User: Boiko Sergii
 * Date: 28.08.2018
 * Time: 19:37
 */

namespace App\Http\Controllers\LDAP;

use App\Http\Controllers\Controller;
use App\Http\Requests\RosterRequest;
use App\Models\LDAP\LDAP;
use App\Models\LDAP\Roster;
use App\Services\LDAP\LDAPService;

class RosterController extends Controller
{
    /**
     * @var LDAPService
     */
    private $ldapService;

    public function __construct(LDAPService $ldapService)
    {
        $this->ldapService = $ldapService;
    }

    public function store(RosterRequest $request)
    {
        Roster::create($request->all());

        return back();
    }

    public function update(RosterRequest $request, Roster $roster)
    {
        $roster->update($request->all());

        return back();
    }

    /**
     * @param Roster $roster
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Roster $roster)
    {
        $roster->delete();

        return back();
    }

    public function show(Roster $roster)
    {
        return view('ldap.roster.show', [
            'roster' => $roster,
            'ldapServers' => LDAP::getAsArray(),
        ]);
    }

    /**
     * @param Roster $roster
     * @throws \App\Drivers\LDAP\LDAPConnectException
     */
    public function getRoster(Roster $roster)
    {
        dd($this->ldapService->getRoster($roster->ldap, $roster));
    }
}