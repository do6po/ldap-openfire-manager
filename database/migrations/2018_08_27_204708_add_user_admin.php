<?php

use App\Models\Users\User;
use Illuminate\Database\Migrations\Migration;

class AddUserAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if ($user = User::whereEmail('admin@example.com')) {
            $user->delete();
        }
    }
}
