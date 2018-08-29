<?php

use Illuminate\Database\Migrations\Migration;


class UpdateTableNameServersToLdapServers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('servers', 'ldap_servers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('ldap_servers', 'servers');
    }
}
