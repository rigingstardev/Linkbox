<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('menus')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('menus')->insert(array(
            0 =>
            array(
                'id' => 1,
                'menu' => 'Question Sets (View Only)',
                'page' => 'questionset',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'menu' => 'Patients',
                'page' => 'patient',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),           
            2 =>
            array(
                'id' => 3,
                'menu' => 'Manage Administrative Staffs',
                'page' => 'manage_admin_staff',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }

}
