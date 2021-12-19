<?php

use Illuminate\Database\Seeder;

class BloodRelationsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('blood_relations')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('blood_relations')->insert(array(
            0 =>
            array(
                'id' => 1,
                'relations' => 'Father',
            ),
            1 =>
            array(
                'id' => 2,
                'relations' => 'Mother',
            ),
            2 =>
            array(
                'id' => 3,
                'relations' => 'Brother',
            ),
            3 =>
            array(
                'id' => 4,
                'relations' => 'Sister',
            ),
            4 =>
            array(
                'id' => 5,
                'relations' => 'Grand Father',
            ),
            5 =>
            array(
                'id' => 6,
                'relations' => 'Grand Mother',
            ),
        ));
    }

}
