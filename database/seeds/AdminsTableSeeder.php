<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {

        Schema::disableForeignKeyConstraints();
        \DB::table('admins')->truncate();
        Schema::enableForeignKeyConstraints();


        \DB::table('admins')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@linkbox.com',
                'password' => '$2y$10$HZj5r.qFlI.Hmrwm7wtQNe/t7yrOH24LNQluVjHDSMBDeNQaPVx5O',
                'left_menu_display_type' => '0',
                'remember_token' => '7DRcHR5J9HsCeFkpOuPezhwVNwkRhEhViEhdnK6vALIiu1QIXTSYCDjF3yv3',
                'created_at' => '2017-02-24 04:00:03',
                'updated_at' => '2017-03-21 08:58:21',
            ),
        ));
    }

}
