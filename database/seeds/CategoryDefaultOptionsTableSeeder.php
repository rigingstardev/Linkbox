<?php

use Illuminate\Database\Seeder;

class CategoryDefaultOptionsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('category_default_options')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('category_default_options')->insert(array(
            0 =>
            array(
                'id' => 3,
                'question_id' => 5,
                'default_option' => 'Worsening',
                'active' => 'Y',
            ),
            1 =>
            array(
                'id' => 4,
                'question_id' => 5,
                'default_option' => 'Stable',
                'active' => 'Y',
            ),
            2 =>
            array(
                'id' => 5,
                'question_id' => 5,
                'default_option' => 'Improving',
                'active' => 'Y',
            ),
            3 =>
            array(
                'id' => 6,
                'question_id' => 2,
                'default_option' => 'both',
                'active' => 'Y',
            ),
            4 =>
            array(
                'id' => 7,
                'question_id' => 4,
                'default_option' => 'Constant',
                'active' => 'Y',
            ),
            5 =>
            array(
                'id' => 8,
                'question_id' => 4,
                'default_option' => 'Intermittent',
                'active' => 'Y',
            ),
        ));
    }

}
