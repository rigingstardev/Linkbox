<?php

use Illuminate\Database\Seeder;

class AllergyTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('allergy')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('allergy')->insert(array(
            0 =>
            array(
                'id' => 1,
                'allergy' => 'Food',
            ),
            1 =>
            array(
                'id' => 2,
                'allergy' => 'Skin',
            ),
            2 =>
            array(
                'id' => 3,
                'allergy' => 'Dust',
            ),
            3 =>
            array(
                'id' => 4,
                'allergy' => 'Insect Sting',
            ),
            4 =>
            array(
                'id' => 5,
                'allergy' => 'Pets',
            ),
            5 =>
            array(
                'id' => 6,
                'allergy' => 'Eyes',
            ),
            6 =>
            array(
                'id' => 7,
                'allergy' => 'Drug',
            ),
            7 =>
            array(
                'id' => 8,
                'allergy' => 'Latex',
            ),
            8 =>
            array(
                'id' => 9,
                'allergy' => 'Rhinitis',
            ),
            9 =>
            array(
                'id' => 10,
                'allergy' => 'Mold',
            ),
            10 =>
            array(
                'id' => 11,
                'allergy' => 'Sinus',
            ),
        ));
    }

}
