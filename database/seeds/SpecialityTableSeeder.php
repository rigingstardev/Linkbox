<?php

use Illuminate\Database\Seeder;

class SpecialityTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {

        Schema::disableForeignKeyConstraints();
        \DB::table('speciality')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('speciality')->insert(array(
            0 =>
            array(
                'id' => 1,
                'name' => 'Allergy & Immunology',
                'code' => NULL,
            ),
            1 =>
            array(
                'id' => 2,
                'name' => 'Anesthesiology',
                'code' => NULL,
            ),
            2 =>
            array(
                'id' => 3,
                'name' => 'Cardiology',
                'code' => NULL,
            ),
            3 =>
            array(
                'id' => 4,
                'name' => 'Child Neurology',
                'code' => NULL,
            ),
            4 =>
            array(
                'id' => 5,
                'name' => 'Colon & Rectal Surgery',
                'code' => NULL,
            ),
            5 =>
            array(
                'id' => 6,
                'name' => 'Dermatology',
                'code' => NULL,
            ),
            6 =>
            array(
                'id' => 7,
                'name' => 'Emergency Medicine',
                'code' => NULL,
            ),
            7 =>
            array(
                'id' => 8,
                'name' => 'Endocrinology',
                'code' => NULL,
            ),
            8 =>
            array(
                'id' => 9,
                'name' => 'Family Medicine',
                'code' => NULL,
            ),
            9 =>
            array(
                'id' => 10,
                'name' => 'Gastroenterology',
                'code' => NULL,
            ),
            10 =>
            array(
                'id' => 11,
                'name' => 'General Surgery',
                'code' => NULL,
            ),
            11 =>
            array(
                'id' => 12,
                'name' => 'Geriatrics',
                'code' => NULL,
            ),
            12 =>
            array(
                'id' => 13,
                'name' => 'Hematology',
                'code' => NULL,
            ),
            13 =>
            array(
                'id' => 14,
                'name' => 'Infectious Disease',
                'code' => NULL,
            ),
            14 =>
            array(
                'id' => 15,
                'name' => 'Internal Medicine',
                'code' => NULL,
            ),
            15 =>
            array(
                'id' => 16,
                'name' => 'Medical Genetics',
                'code' => NULL,
            ),
            16 =>
            array(
                'id' => 17,
                'name' => 'Medicine/Pediatrics',
                'code' => NULL,
            ),
            17 =>
            array(
                'id' => 18,
                'name' => 'Neonat/Perinatology',
                'code' => NULL,
            ),
            18 =>
            array(
                'id' => 19,
                'name' => 'Nephrology',
                'code' => NULL,
            ),
            19 =>
            array(
                'id' => 20,
                'name' => 'Neurology',
                'code' => NULL,
            ),
            20 =>
            array(
                'id' => 21,
                'name' => 'Neurosurgery',
                'code' => NULL,
            ),
            21 =>
            array(
                'id' => 22,
                'name' => 'Nuclear Medicine',
                'code' => NULL,
            ),
            22 =>
            array(
                'id' => 23,
                'name' => 'Obstetrics & Gynecology',
                'code' => NULL,
            ),
            23 =>
            array(
                'id' => 24,
                'name' => 'Occupational Medicine',
                'code' => NULL,
            ),
            24 =>
            array(
                'id' => 25,
                'name' => 'Oncology',
                'code' => NULL,
            ),
            25 =>
            array(
                'id' => 26,
                'name' => 'Ophthalmology',
                'code' => NULL,
            ),
            26 =>
            array(
                'id' => 27,
                'name' => 'Oral & Maxillofacial Surgery',
                'code' => NULL,
            ),
            27 =>
            array(
                'id' => 28,
                'name' => 'Orthopaedic Surgery',
                'code' => NULL,
            ),
            28 =>
            array(
                'id' => 29,
                'name' => 'Other MD/DO',
                'code' => NULL,
            ),
            29 =>
            array(
                'id' => 30,
                'name' => 'Otolaryngology (ENT)',
                'code' => NULL,
            ),
            30 =>
            array(
                'id' => 31,
                'name' => 'Pathology',
                'code' => NULL,
            ),
            31 =>
            array(
                'id' => 32,
                'name' => 'Pediatric Cardiology',
                'code' => NULL,
            ),
            32 =>
            array(
                'id' => 33,
                'name' => 'Pediatric Emergency Medicine',
                'code' => NULL,
            ),
            33 =>
            array(
                'id' => 34,
                'name' => 'Pediatric Endocrinology',
                'code' => NULL,
            ),
            34 =>
            array(
                'id' => 35,
                'name' => 'Pediatric Gastroenterology',
                'code' => NULL,
            ),
            35 =>
            array(
                'id' => 36,
                'name' => 'Pediatric Hematology & Oncology',
                'code' => NULL,
            ),
            36 =>
            array(
                'id' => 37,
                'name' => 'Pediatric Infectious Disease',
                'code' => NULL,
            ),
            37 =>
            array(
                'id' => 38,
                'name' => 'Pediatric Nephrology',
                'code' => NULL,
            ),
            38 =>
            array(
                'id' => 39,
                'name' => 'Pediatric Pulmonology',
                'code' => NULL,
            ),
            39 =>
            array(
                'id' => 40,
                'name' => 'Pediatric Rheumatology',
                'code' => NULL,
            ),
            40 =>
            array(
                'id' => 41,
                'name' => 'Pediatrics',
                'code' => NULL,
            ),
            41 =>
            array(
                'id' => 42,
                'name' => 'Physical Medicine/Rehab',
                'code' => NULL,
            ),
            42 =>
            array(
                'id' => 43,
                'name' => 'Plastic Surgery',
                'code' => NULL,
            ),
            43 =>
            array(
                'id' => 44,
                'name' => 'Preventive Medicine',
                'code' => NULL,
            ),
            44 =>
            array(
                'id' => 45,
                'name' => 'Psychiatry',
                'code' => NULL,
            ),
            45 =>
            array(
                'id' => 46,
                'name' => 'Pulmonology',
                'code' => NULL,
            ),
            46 =>
            array(
                'id' => 47,
                'name' => 'Radiation Oncology',
                'code' => NULL,
            ),
            47 =>
            array(
                'id' => 48,
                'name' => 'Radiology',
                'code' => NULL,
            ),
            48 =>
            array(
                'id' => 49,
                'name' => 'Research',
                'code' => NULL,
            ),
            49 =>
            array(
                'id' => 50,
                'name' => 'Resident Physician',
                'code' => NULL,
            ),
            50 =>
            array(
                'id' => 51,
                'name' => 'Rheumatology',
                'code' => NULL,
            ),
            51 =>
            array(
                'id' => 52,
                'name' => 'Thoracic Surgery',
                'code' => NULL,
            ),
            52 =>
            array(
                'id' => 53,
                'name' => 'Urology',
                'code' => NULL,
            ),
            53 =>
            array(
                'id' => 54,
                'name' => 'Vascular Surgery',
                'code' => NULL,
            ),
            54 =>
            array(
                'id' => 55,
                'name' => 'Acute Care Nurse Practitioner',
                'code' => NULL,
            ),
            55 =>
            array(
                'id' => 56,
                'name' => 'Adult Care Nurse Practitioner',
                'code' => NULL,
            ),
            56 =>
            array(
                'id' => 57,
                'name' => 'Certified Nurse Midwife',
                'code' => NULL,
            ),
            57 =>
            array(
                'id' => 58,
                'name' => 'Certified Registered Nurse Anesthetist',
                'code' => NULL,
            ),
            58 =>
            array(
                'id' => 59,
                'name' => 'Family Nurse Practitioner',
                'code' => NULL,
            ),
            59 =>
            array(
                'id' => 60,
                'name' => 'Geriatric Nurse Practitioner',
                'code' => NULL,
            ),
            60 =>
            array(
                'id' => 61,
                'name' => 'Neonatal Nurse Practitioner',
                'code' => NULL,
            ),
            61 =>
            array(
                'id' => 62,
                'name' => 'Nurse Practitioner',
                'code' => NULL,
            ),
            62 =>
            array(
                'id' => 63,
                'name' => 'Occupational Health Nurse Practitioner',
                'code' => NULL,
            ),
            63 =>
            array(
                'id' => 64,
                'name' => 'Pediatric Nurse Practitioner',
                'code' => NULL,
            ),
            64 =>
            array(
                'id' => 65,
                'name' => 'Psychiatric-Mental Health Nurse Practitioner',
                'code' => NULL,
            ),
            65 =>
            array(
                'id' => 66,
                'name' => 'Women\'s Health Nurse Practitioner',
                'code' => NULL,
            ),
            66 =>
            array(
                'id' => 67,
                'name' => 'Clinical Pharmacist',
                'code' => NULL,
            ),
            67 =>
            array(
                'id' => 68,
                'name' => 'Pharmacist',
                'code' => NULL,
            ),
            68 =>
            array(
                'id' => 69,
                'name' => 'Chiropractor',
                'code' => NULL,
            ),
            69 =>
            array(
                'id' => 70,
                'name' => 'Dentist',
                'code' => NULL,
            ),
            70 =>
            array(
                'id' => 71,
                'name' => 'Diet/Nutritionist',
                'code' => NULL,
            ),
            71 =>
            array(
                'id' => 72,
                'name' => 'Genetic Counselor',
                'code' => NULL,
            ),
            72 =>
            array(
                'id' => 73,
                'name' => 'Optometrist',
                'code' => NULL,
            ),
            73 =>
            array(
                'id' => 74,
                'name' => 'Other Healthcare Professional',
                'code' => NULL,
            ),
            74 =>
            array(
                'id' => 75,
                'name' => 'Physical Therapist',
                'code' => NULL,
            ),
            75 =>
            array(
                'id' => 76,
                'name' => 'Podiatrist',
                'code' => NULL,
            ),
            76 =>
            array(
                'id' => 77,
                'name' => 'Psychologist',
                'code' => NULL,
            ),
            77 =>
            array(
                'id' => 78,
                'name' => 'Registered Nurse',
                'code' => NULL,
            ),
            78 =>
            array(
                'id' => 79,
                'name' => 'Social Worker',
                'code' => NULL,
            )
        ));
    }

}
