<?php

use Illuminate\Database\Seeder;

class CategoryNarrativeOutputTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('category_narrative_output')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('category_narrative_output')->insert(array(
            0 =>
            array(
                'id' => 1,
                'question_id' => 1,
                'narrative_output_p1' => 'The [CC] is located on [X]',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            1 =>
            array(
                'id' => 2,
                'question_id' => 2,
                'narrative_output_p1' => 'The [CC] begin on [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            2 =>
            array(
                'id' => 3,
                'question_id' => 3,
                'narrative_output_p1' => 'The [CC] has been present since [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            3 =>
            array(
                'id' => 4,
                'question_id' => 4,
                'narrative_output_p1' => 'The [CC] is [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            4 =>
            array(
                'id' => 5,
                'question_id' => 5,
                'narrative_output_p1' => 'The progress of [CC] is [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            5 =>
            array(
                'id' => 6,
                'question_id' => 6,
                'narrative_output_p1' => ' I have [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            6 =>
            array(
                'id' => 7,
                'question_id' => 7,
                'narrative_output_p1' => 'I was [X] when the [CC] begin.',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            7 =>
            array(
                'id' => 8,
                'question_id' => 8,
                'narrative_output_p1' => 'I think [CC] is due to the [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            8 =>
            array(
                'id' => 9,
                'question_id' => 9,
                'narrative_output_p1' => 'The [CC] is [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            9 =>
            array(
                'id' => 10,
                'question_id' => 10,
                'narrative_output_p1' => 'The [CC] is [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            10 =>
            array(
                'id' => 11,
                'question_id' => 11,
                'narrative_output_p1' => '[X] makes [CC] worse.',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            11 =>
            array(
                'id' => 12,
                'question_id' => 12,
                'narrative_output_p1' => 'other symptoms associated with the [CC] are [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            12 =>
            array(
                'id' => 13,
                'question_id' => 13,
                'narrative_output_p1' => 'also [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            13 =>
            array(
                'id' => 14,
                'question_id' => 14,
                'narrative_output_p1' => '[X] makes the [CC] better.',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            14 =>
            array(
                'id' => 15,
                'question_id' => 15,
                'narrative_output_p1' => 'My Comments on [CC] [X].',
                'narrative_output_p2' => '',
                'active' => 'Y',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }

}
