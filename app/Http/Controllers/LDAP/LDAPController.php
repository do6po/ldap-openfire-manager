<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 20.08.18
 * Time: 12:50
 */

namespace App\Http\Controllers\LDAP;

use App\Http\Controllers\Controller;
use App\Http\Requests\LDAPRequest;
use App\Models\LDAP\LDAP;

class LDAPController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = LDAP::paginate();

        return view('ldap.ldap.index', [
            'servers' => $servers,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('ldap.ldap.create');
    }

    /**
     * @param LDAPRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LDAPRequest $request)
    {
        $server = LDAP::create($request->all());

        return redirect()->route('ldap.show', $server);
    }

    /**
     * @param  \App\Models\LDAP\LDAP $ldap
     * @return \Illuminate\Http\Response
     */
    public function show(LDAP $ldap)
    {
        return view('ldap.ldap.show', [
            'server' => $ldap,
            'rosters' => $ldap->rosters,
        ]);
    }

    /**
     * @param  \App\Models\LDAP\LDAP $ldap
     * @return \Illuminate\Http\Response
     */
    public function edit(LDAP $ldap)
    {
        return view('ldap.ldap.edit', [
            'server' => $ldap,
        ]);
    }

    /**
     * @param LDAPRequest $request
     * @param LDAP $ldap
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LDAPRequest $request, LDAP $ldap)
    {
        $ldap->update($request->all());

        return redirect()->route('ldap.show', $ldap);
    }

    /**
     * @param \App\Models\LDAP\LDAP $ldap
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(LDAP $ldap)
    {
        $ldap->delete();

        return redirect()->route('ldap.index');
    }
}