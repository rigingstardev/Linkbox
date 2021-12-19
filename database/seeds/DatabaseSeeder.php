<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->call(AdminsTableSeeder::class);
        $this->call(AllergyTableSeeder::class);
        $this->call(BloodRelationsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryDefaultOptionsTableSeeder::class);
        $this->call(CategoryQuestionsTableSeeder::class);
        $this->call(ChiefComplaintsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(PatientsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(SpecialityTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryNarrativeOutputTableSeeder::class);
    }

}
