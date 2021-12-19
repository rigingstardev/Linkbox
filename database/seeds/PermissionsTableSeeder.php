<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('permissions')->insert(array(
            0 =>
            array(
                'id' => 1,
                'menu_id' => 1,
                'permission' => 'questionset_list',
            ),
            1 =>
            array(
                'id' => 2,
                'menu_id' => 2,
                'permission' => 'patient_list',
            ),
            2 =>
            array(
                'id' => 3,
                'menu_id' => 2,
                'permission' => 'patient_edit',
            ),
            3 =>
            array(
                'id' => 4,
                'menu_id' => 2,
                'permission' => 'patient_medicalRecordsList',
            ),            
            4 =>
            array(
                'id' => 5,
                'menu_id' => 2,
                'permission' => 'patient_summaryReportList',
            ),            
            5 =>
            array(
                'id' => 6,
                'menu_id' => 2,
                'permission' => 'patient_evaluationReportList',
            ),            
            6 =>
            array(
                'id' => 7,
                'menu_id' => 3,
                'permission' => 'admin_staff_list',
            ),
            7 =>
            array(
                'id' => 8,
                'menu_id' => 3,
                'permission' => 'admin_staff_edit',
            ),
            8 =>
            array(
                'id' => 9,
                'menu_id' => 3,
                'permission' => 'admin_staff_delete',
            ),
        ));
    }

}
