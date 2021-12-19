<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('plans')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('plans')->insert(array(
            0 =>
            array(
                'id' => 1,
                'plan_id' => 'monthly',
                'name' => 'Monthly',
                'amount' => 49.0,
                'currency' => '$',
                'period' => '1 month',
                'plan_type' => 'monthly',
                'sortorder' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'plan_id' => 'yearly',
                'name' => 'Yearly',
                'amount' => 149.0,
                'currency' => '$',
                'period' => '1 year',
                'plan_type' => 'yearly',
                'sortorder' => 2,
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
    }

}
