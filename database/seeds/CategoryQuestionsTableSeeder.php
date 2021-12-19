<?php

use Illuminate\Database\Seeder;

class CategoryQuestionsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('category_questions')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('category_questions')->insert(array(
            0 =>
            array(
                'id' => 1,
                'category_id' => 2,
                'question' => 'Where was the [CC] located?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'The [CC] is located on [X]',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            1 =>
            array(
                'id' => 2,
                'category_id' => 1,
                'question' => 'When did [CC] begin?',
                'answer_type' => 'dateT',
                'narrative_output_p1' => 'The [CC] begin on [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            2 =>
            array(
                'id' => 3,
                'category_id' => 1,
                'question' => 'How long was the [CC] present?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'The [CC] has been present since [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            3 =>
            array(
                'id' => 4,
                'category_id' => 4,
                'question' => 'Was the [CC] constant or intermittent?',
                'answer_type' => 'dropDown',
                'narrative_output_p1' => 'The [CC] is [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            4 =>
            array(
                'id' => 5,
                'category_id' => 4,
                'question' => 'What was the progression of the [CC]? ',
                'answer_type' => 'dropDown',
                'narrative_output_p1' => 'The progress of [CC] is [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            5 =>
            array(
                'id' => 6,
                'category_id' => 3,
                'question' => 'Why do you think you have the [CC]?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => ' I have [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            6 =>
            array(
                'id' => 7,
                'category_id' => 3,
                'question' => 'Where were you when the [CC] began?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'I was [X] when the [CC] begin.',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            7 =>
            array(
                'id' => 8,
                'category_id' => 3,
                'question' => 'What do you think caused the [CC]?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'I think [CC] is due to the [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            8 =>
            array(
                'id' => 9,
                'category_id' => 5,
                'question' => 'How would you describe the [CC]?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'The [CC] is [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            9 =>
            array(
                'id' => 10,
                'category_id' => 6,
                'question' => 'How severe is the [CC]?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'The [CC] is [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            10 =>
            array(
                'id' => 11,
                'category_id' => 7,
                'question' => 'What makes the [CC] worse?',
                'answer_type' => 'mcq',
                'narrative_output_p1' => '[X] makes [CC] worse.',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            11 =>
            array(
                'id' => 12,
                'category_id' => 9,
                'question' => 'What other symptoms are associate with the [CC]?',
                'answer_type' => 'dropDown',
                'narrative_output_p1' => 'other symptoms associated with the [CC] are [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            12 =>
            array(
                'id' => 13,
                'category_id' => 10,
                'question' => 'Is there anything else you would like to add about the [CC]?',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'also [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            13 =>
            array(
                'id' => 14,
                'category_id' => 8,
                'question' => 'What makes the [CC] better?',
                'answer_type' => 'dropDown',
                'narrative_output_p1' => '[X] makes the [CC] better.',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => '2017-02-09 01:12:25',
                'updated_at' => '2017-02-09 01:12:25',
            ),
            14 =>
            array(
                'id' => 15,
                'category_id' => 11,
                'question' => 'Specify your comments',
                'answer_type' => 'textBox',
                'narrative_output_p1' => 'My Comments on [CC] [X].',
                'narrative_output_p2' => '',
                'comments' => NULL,
                'active' => 'Y',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
    }

}
