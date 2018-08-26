<?php
/**
 * Created by PhpStorm.
 * User: box
 * Date: 20.08.18
 * Time: 12:50
 */

namespace App\Http\Controllers\LDAP;

use App\Http\Controllers\Controller;
use App\Http\Requests\LDAPServerRequest;
use App\Models\LDAP\Server;

class ServerController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = Server::paginate();

        return view('ldap.index', [
            'servers' => $servers,
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('ldap.create');
    }

    /**
     * @param LDAPServerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LDAPServerRequest $request)
    {
        Server::create($request->all());

        return redirect()->route('ldap.index');
    }

    /**
     * @param  \App\Models\LDAP\Server $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        return view('ldap.show', [
            'server' => $server,
        ]);
    }

    /**
     * @param  \App\Models\LDAP\Server $server
     * @return \Illuminate\Http\Response
     */
    public function edit(Server $server)
    {
        return view('ldap.edit', [
            'server' => $server,
        ]);
    }

    /**
     * @param \App\Http\Requests\LDAPServerRequest $request
     * @param \App\Models\LDAP\Server $server
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LDAPServerRequest $request, Server $server)
    {
        $server->update($request->all());

        return redirect()->route('ldap.show', $server);
    }

    /**
     * @param \App\Models\LDAP\Server $server
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Server $server)
    {
        $server->delete();

        return redirect()->route('ldap.index');
    }
}