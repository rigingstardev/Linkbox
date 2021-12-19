<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('categories')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category' => 'Onset/Duration Questions',
                'active' => 'Y',
                'sort_order' => 1,
            ),
            1 =>
            array(
                'id' => 2,
                'category' => 'Body Location Questions',
                'active' => 'Y',
                'sort_order' => 2,
            ),
            2 =>
            array(
                'id' => 3,
                'category' => 'Context/Setting Questions',
                'active' => 'Y',
                'sort_order' => 3,
            ),
            3 =>
            array(
                'id' => 4,
                'category' => 'Timing/Progression Questions',
                'active' => 'Y',
                'sort_order' => 4,
            ),
            4 =>
            array(
                'id' => 5,
                'category' => 'Quality Questions',
                'active' => 'Y',
                'sort_order' => 5,
            ),
            5 =>
            array(
                'id' => 6,
                'category' => 'Quantity Questions',
                'active' => 'Y',
                'sort_order' => 6,
            ),
            6 =>
            array(
                'id' => 7,
                'category' => 'Aggravating Factors Questions',
                'active' => 'Y',
                'sort_order' => 7,
            ),
            7 =>
            array(
                'id' => 8,
                'category' => 'Alleviating Factors Questions',
                'active' => 'Y',
                'sort_order' => 8,
            ),
            8 =>
            array(
                'id' => 9,
                'category' => 'Associated Symptoms Questions',
                'active' => 'Y',
                'sort_order' => 9,
            ),
            9 =>
            array(
                'id' => 10,
                'category' => 'Others with [CC]',
                'active' => 'Y',
                'sort_order' => 10,
            ),
            10 =>
            array(
                'id' => 11,
                'category' => 'Category without [CC]',
                'active' => 'Y',
                'sort_order' => 11,
            ),
        ));
    }

}
