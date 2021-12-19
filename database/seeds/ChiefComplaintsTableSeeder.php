<?php

use Illuminate\Database\Seeder;

class ChiefComplaintsTableSeeder extends Seeder {

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run() {


        Schema::disableForeignKeyConstraints();
        \DB::table('chief_complaints')->truncate();
        Schema::enableForeignKeyConstraints();

        \DB::table('chief_complaints')->insert(array(
            0 =>
            array(
                'id' => 1,
                'cc_text' => 'Abnormal gait (walking)',
            ),
            1 =>
            array(
                'id' => 2,
                'cc_text' => 'Abnormal muscle enlargement (hypertrophy)',
            ),
            2 =>
            array(
                'id' => 3,
                'cc_text' => 'Abnormally round face',
            ),
            3 =>
            array(
                'id' => 4,
                'cc_text' => 'Agitation',
            ),
            4 =>
            array(
                'id' => 5,
                'cc_text' => 'Anxiety',
            ),
            5 =>
            array(
                'id' => 6,
                'cc_text' => 'Apathy',
            ),
            6 =>
            array(
                'id' => 7,
                'cc_text' => 'Bad breath',
            ),
            7 =>
            array(
                'id' => 8,
                'cc_text' => 'Bad taste in mouth',
            ),
            8 =>
            array(
                'id' => 9,
                'cc_text' => 'Bald spots (hair)',
            ),
            9 =>
            array(
                'id' => 10,
                'cc_text' => 'Belching',
            ),
            10 =>
            array(
                'id' => 11,
                'cc_text' => 'Binge drinking (alcohol)',
            ),
            11 =>
            array(
                'id' => 12,
                'cc_text' => 'Binge eating',
            ),
            12 =>
            array(
                'id' => 13,
                'cc_text' => 'Bitter almond odor on breath',
            ),
            13 =>
            array(
                'id' => 14,
                'cc_text' => 'Black (tar) colored stools',
            ),
            14 =>
            array(
                'id' => 15,
                'cc_text' => 'Black colored skin',
            ),
            15 =>
            array(
                'id' => 16,
                'cc_text' => 'Blackouts (memory time loss)',
            ),
            16 =>
            array(
                'id' => 17,
                'cc_text' => 'Blank stare',
            ),
            17 =>
            array(
                'id' => 18,
                'cc_text' => 'Bleeding',
            ),
            18 =>
            array(
                'id' => 19,
                'cc_text' => 'Bleeding from nipple',
            ),
            19 =>
            array(
                'id' => 20,
                'cc_text' => 'Bleeding gums',
            ),
            20 =>
            array(
                'id' => 21,
                'cc_text' => 'Bleeding in eye',
            ),
            21 =>
            array(
                'id' => 22,
                'cc_text' => 'Blind spot in vision',
            ),
            22 =>
            array(
                'id' => 23,
                'cc_text' => 'Blindness',
            ),
            23 =>
            array(
                'id' => 24,
                'cc_text' => 'Blinking eyes',
            ),
            24 =>
            array(
                'id' => 25,
                'cc_text' => 'Bloating or fullness',
            ),
            25 =>
            array(
                'id' => 26,
                'cc_text' => 'Blood in toilet',
            ),
            26 =>
            array(
                'id' => 27,
                'cc_text' => 'Blood on stool surface',
            ),
            27 =>
            array(
                'id' => 28,
                'cc_text' => 'Blood on toilet tissue',
            ),
            28 =>
            array(
                'id' => 29,
                'cc_text' => 'Blood or red colored urine',
            ),
            29 =>
            array(
                'id' => 30,
                'cc_text' => 'Bloody or red colored stools',
            ),
            30 =>
            array(
                'id' => 31,
                'cc_text' => 'Bloody or red colored vomit',
            ),
            31 =>
            array(
                'id' => 32,
                'cc_text' => 'Blue colored skin',
            ),
            32 =>
            array(
                'id' => 33,
                'cc_text' => 'Blue coloured lips',
            ),
            33 =>
            array(
                'id' => 34,
                'cc_text' => 'Blurred vision',
            ),
            34 =>
            array(
                'id' => 35,
                'cc_text' => 'Body aches or pains',
            ),
            35 =>
            array(
                'id' => 36,
                'cc_text' => 'Brittle hair',
            ),
            36 =>
            array(
                'id' => 37,
                'cc_text' => 'Broken bone (single fracture)',
            ),
            37 =>
            array(
                'id' => 38,
                'cc_text' => 'Broken bones (multiple fractures)',
            ),
            38 =>
            array(
                'id' => 39,
                'cc_text' => 'Bruising or discoloration',
            ),
            39 =>
            array(
                'id' => 40,
                'cc_text' => 'Bulging eyes',
            ),
            40 =>
            array(
                'id' => 41,
                'cc_text' => 'Bulging neck veins',
            ),
            41 =>
            array(
                'id' => 42,
                'cc_text' => 'Bulging veins',
            ),
            42 =>
            array(
                'id' => 43,
                'cc_text' => 'Change in bowel habits',
            ),
            43 =>
            array(
                'id' => 44,
                'cc_text' => 'Change in hair texture',
            ),
            44 =>
            array(
                'id' => 45,
                'cc_text' => 'Change in stools',
            ),
            45 =>
            array(
                'id' => 46,
                'cc_text' => 'Change in vision',
            ),
            46 =>
            array(
                'id' => 47,
                'cc_text' => 'Chills',
            ),
            47 =>
            array(
                'id' => 48,
                'cc_text' => 'Choking',
            ),
            48 =>
            array(
                'id' => 49,
                'cc_text' => 'Choking on food',
            ),
            49 =>
            array(
                'id' => 50,
                'cc_text' => 'Clicking or popping sound from jaw',
            ),
            50 =>
            array(
                'id' => 51,
                'cc_text' => 'Cloudy urine with strong odor',
            ),
            51 =>
            array(
                'id' => 52,
                'cc_text' => 'Cloudy vision',
            ),
            52 =>
            array(
                'id' => 53,
                'cc_text' => 'Coarse hair',
            ),
            53 =>
            array(
                'id' => 54,
                'cc_text' => 'Coated or furry tongue',
            ),
            54 =>
            array(
                'id' => 55,
                'cc_text' => 'Coffee grounds colored vomit',
            ),
            55 =>
            array(
                'id' => 56,
                'cc_text' => 'Cold feet',
            ),
            56 =>
            array(
                'id' => 57,
                'cc_text' => 'Cold hands',
            ),
            57 =>
            array(
                'id' => 58,
                'cc_text' => 'Color change',
            ),
            58 =>
            array(
                'id' => 59,
                'cc_text' => 'Coma',
            ),
            59 =>
            array(
                'id' => 60,
                'cc_text' => 'Compulsive behavior',
            ),
            60 =>
            array(
                'id' => 61,
                'cc_text' => 'Confusion',
            ),
            61 =>
            array(
                'id' => 62,
                'cc_text' => 'Constipation',
            ),
            62 =>
            array(
                'id' => 63,
                'cc_text' => 'Cough',
            ),
            63 =>
            array(
                'id' => 64,
                'cc_text' => 'Cracks at corner of mouth',
            ),
            64 =>
            array(
                'id' => 65,
                'cc_text' => 'Craving alcohol',
            ),
            65 =>
            array(
                'id' => 66,
                'cc_text' => 'Craving to eat ice, dirt or paper',
            ),
            66 =>
            array(
                'id' => 67,
                'cc_text' => 'Crying during sleep',
            ),
            67 =>
            array(
                'id' => 68,
                'cc_text' => 'Curved fingernails',
            ),
            68 =>
            array(
                'id' => 69,
                'cc_text' => 'Curved or bent penis during erection',
            ),
            69 =>
            array(
                'id' => 70,
                'cc_text' => 'Curved spine',
            ),
            70 =>
            array(
                'id' => 71,
                'cc_text' => 'Damaged teeth enamel',
            ),
            71 =>
            array(
                'id' => 72,
                'cc_text' => 'Dark colored (brown) urine',
            ),
            72 =>
            array(
                'id' => 73,
                'cc_text' => 'Decreased appetite',
            ),
            73 =>
            array(
                'id' => 74,
                'cc_text' => 'Decreased night vision',
            ),
            74 =>
            array(
                'id' => 75,
                'cc_text' => 'Decreased school performance',
            ),
            75 =>
            array(
                'id' => 76,
                'cc_text' => 'Decreased smell',
            ),
            76 =>
            array(
                'id' => 77,
                'cc_text' => 'Decreased sweating',
            ),
            77 =>
            array(
                'id' => 78,
                'cc_text' => 'Decreased taste',
            ),
            78 =>
            array(
                'id' => 79,
                'cc_text' => 'Decreased tears when crying',
            ),
            79 =>
            array(
                'id' => 80,
                'cc_text' => 'Decreased urination',
            ),
            80 =>
            array(
                'id' => 81,
                'cc_text' => 'Delayed language skills',
            ),
            81 =>
            array(
                'id' => 82,
                'cc_text' => 'Delayed motor development',
            ),
            82 =>
            array(
                'id' => 83,
                'cc_text' => 'Delusions',
            ),
            83 =>
            array(
                'id' => 84,
                'cc_text' => 'Depressed mood',
            ),
            84 =>
            array(
                'id' => 85,
                'cc_text' => 'Developmental delays',
            ),
            85 =>
            array(
                'id' => 86,
                'cc_text' => 'Diarrhea',
            ),
            86 =>
            array(
                'id' => 87,
                'cc_text' => 'Difficult to wake from sleep',
            ),
            87 =>
            array(
                'id' => 88,
                'cc_text' => 'Difficulty breathing through nose',
            ),
            88 =>
            array(
                'id' => 89,
                'cc_text' => 'Difficulty concentrating',
            ),
            89 =>
            array(
                'id' => 90,
                'cc_text' => 'Difficulty falling asleep',
            ),
            90 =>
            array(
                'id' => 91,
                'cc_text' => 'Difficulty finding words',
            ),
            91 =>
            array(
                'id' => 92,
                'cc_text' => 'Difficulty learning new things',
            ),
            92 =>
            array(
                'id' => 93,
                'cc_text' => 'Difficulty moving arm',
            ),
            93 =>
            array(
                'id' => 94,
                'cc_text' => 'Difficulty opening mouth',
            ),
            94 =>
            array(
                'id' => 95,
                'cc_text' => 'Difficulty relaxing muscles after contracting them',
            ),
            95 =>
            array(
                'id' => 96,
                'cc_text' => 'Difficulty sleeping',
            ),
            96 =>
            array(
                'id' => 97,
                'cc_text' => 'Difficulty solving problems',
            ),
            97 =>
            array(
                'id' => 98,
                'cc_text' => 'Difficulty standing',
            ),
            98 =>
            array(
                'id' => 99,
                'cc_text' => 'Difficulty starting urine stream',
            ),
            99 =>
            array(
                'id' => 100,
                'cc_text' => 'Difficulty staying asleep',
            ),
            100 =>
            array(
                'id' => 101,
                'cc_text' => 'Difficulty staying awake during day',
            ),
            101 =>
            array(
                'id' => 102,
                'cc_text' => 'Difficulty stopping urine stream',
            ),
            102 =>
            array(
                'id' => 103,
                'cc_text' => 'Difficulty swallowing',
            ),
            103 =>
            array(
                'id' => 104,
                'cc_text' => 'Difficulty talking',
            ),
            104 =>
            array(
                'id' => 105,
                'cc_text' => 'Difficulty urinating',
            ),
            105 =>
            array(
                'id' => 106,
                'cc_text' => 'Discharge from nipple',
            ),
            106 =>
            array(
                'id' => 107,
                'cc_text' => 'Discharge from penis',
            ),
            107 =>
            array(
                'id' => 108,
                'cc_text' => 'Discharge or mucus in eyes',
            ),
            108 =>
            array(
                'id' => 109,
                'cc_text' => 'Dislikes change in daily routine',
            ),
            109 =>
            array(
                'id' => 110,
                'cc_text' => 'Disorientation',
            ),
            110 =>
            array(
                'id' => 111,
                'cc_text' => 'Distended stomach',
            ),
            111 =>
            array(
                'id' => 112,
                'cc_text' => 'Distorted body image',
            ),
            112 =>
            array(
                'id' => 113,
                'cc_text' => 'Distortion of part of visual field',
            ),
            113 =>
            array(
                'id' => 114,
                'cc_text' => 'Dizziness',
            ),
            114 =>
            array(
                'id' => 115,
                'cc_text' => 'Double vision (with one eye covered)',
            ),
            115 =>
            array(
                'id' => 116,
                'cc_text' => 'Double vision (without one eye covered)',
            ),
            116 =>
            array(
                'id' => 117,
                'cc_text' => 'Drainage or pus',
            ),
            117 =>
            array(
                'id' => 118,
                'cc_text' => 'Drinking excessive fluids',
            ),
            118 =>
            array(
                'id' => 119,
                'cc_text' => 'Drooling',
            ),
            119 =>
            array(
                'id' => 120,
                'cc_text' => 'Drooping eyelid',
            ),
            120 =>
            array(
                'id' => 121,
                'cc_text' => 'Drooping of one side of face',
            ),
            121 =>
            array(
                'id' => 122,
                'cc_text' => 'Drowsiness',
            ),
            122 =>
            array(
                'id' => 123,
                'cc_text' => 'Dry eyes',
            ),
            123 =>
            array(
                'id' => 124,
                'cc_text' => 'Dry mouth',
            ),
            124 =>
            array(
                'id' => 125,
                'cc_text' => 'Dry skin',
            ),
            125 =>
            array(
                'id' => 126,
                'cc_text' => 'Ear ache',
            ),
            126 =>
            array(
                'id' => 127,
                'cc_text' => 'Early breast development',
            ),
            127 =>
            array(
                'id' => 128,
                'cc_text' => 'Early morning waking',
            ),
            128 =>
            array(
                'id' => 129,
                'cc_text' => 'Easily distracted',
            ),
            129 =>
            array(
                'id' => 130,
                'cc_text' => 'Easy bleeding',
            ),
            130 =>
            array(
                'id' => 131,
                'cc_text' => 'Easy bruising',
            ),
            131 =>
            array(
                'id' => 132,
                'cc_text' => 'Emotional detachment',
            ),
            132 =>
            array(
                'id' => 133,
                'cc_text' => 'Enlarged (dilated) pupils',
            ),
            133 =>
            array(
                'id' => 134,
                'cc_text' => 'Enlarged (dilated) veins',
            ),
            134 =>
            array(
                'id' => 135,
                'cc_text' => 'Enlarged finger tips',
            ),
            135 =>
            array(
                'id' => 136,
                'cc_text' => 'Enlarged or swollen glands',
            ),
            136 =>
            array(
                'id' => 137,
                'cc_text' => 'Episodes of not breathing during sleep',
            ),
            137 =>
            array(
                'id' => 138,
                'cc_text' => 'Erectile dysfunction',
            ),
            138 =>
            array(
                'id' => 139,
                'cc_text' => 'Excessive body hair growth',
            ),
            139 =>
            array(
                'id' => 140,
                'cc_text' => 'Excessive crying',
            ),
            140 =>
            array(
                'id' => 141,
                'cc_text' => 'Excessive exercising',
            ),
            141 =>
            array(
                'id' => 142,
                'cc_text' => 'Excessive facial hair growth (female)',
            ),
            142 =>
            array(
                'id' => 143,
                'cc_text' => 'Excessive facial hair growth (male)',
            ),
            143 =>
            array(
                'id' => 144,
                'cc_text' => 'Excessive mouth watering',
            ),
            144 =>
            array(
                'id' => 145,
                'cc_text' => 'Excessive sweating',
            ),
            145 =>
            array(
                'id' => 146,
                'cc_text' => 'Excessively salty sweat or skin',
            ),
            146 =>
            array(
                'id' => 147,
                'cc_text' => 'Eye crusting with sleep',
            ),
            147 =>
            array(
                'id' => 148,
                'cc_text' => 'Eye irritation',
            ),
            148 =>
            array(
                'id' => 149,
                'cc_text' => 'Eyelashes falling out',
            ),
            149 =>
            array(
                'id' => 150,
                'cc_text' => 'Eyelid redness',
            ),
            150 =>
            array(
                'id' => 151,
                'cc_text' => 'Eyes do not track together',
            ),
            151 =>
            array(
                'id' => 152,
                'cc_text' => 'Eyes rolling back',
            ),
            152 =>
            array(
                'id' => 153,
                'cc_text' => 'Fainting',
            ),
            153 =>
            array(
                'id' => 154,
                'cc_text' => 'Fatigue',
            ),
            154 =>
            array(
                'id' => 155,
                'cc_text' => 'Fear of air',
            ),
            155 =>
            array(
                'id' => 156,
                'cc_text' => 'Fear of gaining weight',
            ),
            156 =>
            array(
                'id' => 157,
                'cc_text' => 'Fear of water',
            ),
            157 =>
            array(
                'id' => 158,
                'cc_text' => 'Fearful',
            ),
            158 =>
            array(
                'id' => 159,
                'cc_text' => 'Feeling faint',
            ),
            159 =>
            array(
                'id' => 160,
                'cc_text' => 'Feeling of being detached from reality',
            ),
            160 =>
            array(
                'id' => 161,
                'cc_text' => 'Feeling of not being able to get enough air',
            ),
            161 =>
            array(
                'id' => 162,
                'cc_text' => 'Feeling smothered',
            ),
            162 =>
            array(
                'id' => 163,
                'cc_text' => 'Fever',
            ),
            163 =>
            array(
                'id' => 164,
                'cc_text' => 'Fits of rage',
            ),
            164 =>
            array(
                'id' => 165,
                'cc_text' => 'Flaking skin',
            ),
            165 =>
            array(
                'id' => 166,
                'cc_text' => 'Flashbacks',
            ),
            166 =>
            array(
                'id' => 167,
                'cc_text' => 'Flickering lights in vision',
            ),
            167 =>
            array(
                'id' => 168,
                'cc_text' => 'Flickering uncolored zig-zag line in vision',
            ),
            168 =>
            array(
                'id' => 169,
                'cc_text' => 'Floating spots or strings in vision',
            ),
            169 =>
            array(
                'id' => 170,
                'cc_text' => 'Flushed skin',
            ),
            170 =>
            array(
                'id' => 171,
                'cc_text' => 'Food cravings',
            ),
            171 =>
            array(
                'id' => 172,
                'cc_text' => 'Food getting stuck (swallowing)',
            ),
            172 =>
            array(
                'id' => 173,
                'cc_text' => 'Forgetfulness',
            ),
            173 =>
            array(
                'id' => 174,
                'cc_text' => 'Foul smelling stools',
            ),
            174 =>
            array(
                'id' => 175,
                'cc_text' => 'Frequent bowel movements',
            ),
            175 =>
            array(
                'id' => 176,
                'cc_text' => 'Frequent changes in eye glass prescription',
            ),
            176 =>
            array(
                'id' => 177,
                'cc_text' => 'Frequent chewing',
            ),
            177 =>
            array(
                'id' => 178,
                'cc_text' => 'Frequent infections',
            ),
            178 =>
            array(
                'id' => 179,
                'cc_text' => 'Frequent laxative use',
            ),
            179 =>
            array(
                'id' => 180,
                'cc_text' => 'Frequent nighttime urination',
            ),
            180 =>
            array(
                'id' => 181,
                'cc_text' => 'Frequent squinting',
            ),
            181 =>
            array(
                'id' => 182,
                'cc_text' => 'Frequent urge to have bowel movement',
            ),
            182 =>
            array(
                'id' => 183,
                'cc_text' => 'Frequent urge to urinate',
            ),
            183 =>
            array(
                'id' => 184,
                'cc_text' => 'Frequent urination',
            ),
            184 =>
            array(
                'id' => 185,
                'cc_text' => 'Frightening dreams',
            ),
            185 =>
            array(
                'id' => 186,
                'cc_text' => 'Frightening thoughts',
            ),
            186 =>
            array(
                'id' => 187,
                'cc_text' => 'Fruity odor on breath',
            ),
            187 =>
            array(
                'id' => 188,
                'cc_text' => 'Gagging',
            ),
            188 =>
            array(
                'id' => 189,
                'cc_text' => 'Giddiness',
            ),
            189 =>
            array(
                'id' => 190,
                'cc_text' => 'Grinding teeth',
            ),
            190 =>
            array(
                'id' => 191,
                'cc_text' => 'Gritty or scratchy eyes',
            ),
            191 =>
            array(
                'id' => 192,
                'cc_text' => 'Grooved tongue',
            ),
            192 =>
            array(
                'id' => 193,
                'cc_text' => 'Guarding or favoring joint',
            ),
            193 =>
            array(
                'id' => 194,
                'cc_text' => 'Gum sores',
            ),
            194 =>
            array(
                'id' => 195,
                'cc_text' => 'Hair loss',
            ),
            195 =>
            array(
                'id' => 196,
                'cc_text' => 'Hallucinations',
            ),
            196 =>
            array(
                'id' => 197,
                'cc_text' => 'Headache',
            ),
            197 =>
            array(
                'id' => 198,
                'cc_text' => 'Headache (worst ever)',
            ),
            198 =>
            array(
                'id' => 199,
                'cc_text' => 'Hearing loss',
            ),
            199 =>
            array(
                'id' => 200,
                'cc_text' => 'Hearing voices',
            ),
            200 =>
            array(
                'id' => 201,
                'cc_text' => 'Heartburn',
            ),
            201 =>
            array(
                'id' => 202,
                'cc_text' => 'Heavy menstrual bleeding',
            ),
            202 =>
            array(
                'id' => 203,
                'cc_text' => 'High blood pressure',
            ),
            203 =>
            array(
                'id' => 204,
                'cc_text' => 'Hives',
            ),
            204 =>
            array(
                'id' => 205,
                'cc_text' => 'Hoarse voice',
            ),
            205 =>
            array(
                'id' => 206,
                'cc_text' => 'Holding bowel movements',
            ),
            206 =>
            array(
                'id' => 207,
                'cc_text' => 'Holding objects closer to read',
            ),
            207 =>
            array(
                'id' => 208,
                'cc_text' => 'Holding objects further away to read',
            ),
            208 =>
            array(
                'id' => 209,
                'cc_text' => 'Hot flashes',
            ),
            209 =>
            array(
                'id' => 210,
                'cc_text' => 'Hot, dry skin',
            ),
            210 =>
            array(
                'id' => 211,
                'cc_text' => 'Hunched or stooped posture',
            ),
            211 =>
            array(
                'id' => 212,
                'cc_text' => 'Hunger',
            ),
            212 =>
            array(
                'id' => 213,
                'cc_text' => 'Hyperactive behavior',
            ),
            213 =>
            array(
                'id' => 214,
                'cc_text' => 'Hyperventilating (rapid/deep breathing)',
            ),
            214 =>
            array(
                'id' => 215,
                'cc_text' => 'Impaired color vision',
            ),
            215 =>
            array(
                'id' => 216,
                'cc_text' => 'Impaired judgement',
            ),
            216 =>
            array(
                'id' => 217,
                'cc_text' => 'Impaired social skills',
            ),
            217 =>
            array(
                'id' => 218,
                'cc_text' => 'Impulsive behavior',
            ),
            218 =>
            array(
                'id' => 219,
                'cc_text' => 'Inability to care for self',
            ),
            219 =>
            array(
                'id' => 220,
                'cc_text' => 'Inability to move',
            ),
            220 =>
            array(
                'id' => 221,
                'cc_text' => 'Inappropriate behavior',
            ),
            221 =>
            array(
                'id' => 222,
                'cc_text' => 'Increased passing gas',
            ),
            222 =>
            array(
                'id' => 223,
                'cc_text' => 'Increased sensitivity to cold',
            ),
            223 =>
            array(
                'id' => 224,
                'cc_text' => 'Increased sensitivity to heat',
            ),
            224 =>
            array(
                'id' => 225,
                'cc_text' => 'Increased speech volume',
            ),
            225 =>
            array(
                'id' => 226,
                'cc_text' => 'Increased talkativeness',
            ),
            226 =>
            array(
                'id' => 227,
                'cc_text' => 'Increased thirst',
            ),
            227 =>
            array(
                'id' => 228,
                'cc_text' => 'Intentional vomiting (purging)',
            ),
            228 =>
            array(
                'id' => 229,
                'cc_text' => 'Involuntary head turning or twisting',
            ),
            229 =>
            array(
                'id' => 230,
                'cc_text' => 'Involuntary movements (picking, lip smacking etc.)',
            ),
            230 =>
            array(
                'id' => 231,
                'cc_text' => 'Irregular heartbeat',
            ),
            231 =>
            array(
                'id' => 232,
                'cc_text' => 'Irregular menstrual periods',
            ),
            232 =>
            array(
                'id' => 233,
                'cc_text' => 'Itching or burning',
            ),
            233 =>
            array(
                'id' => 234,
                'cc_text' => 'Jaw locking',
            ),
            234 =>
            array(
                'id' => 235,
                'cc_text' => 'Jerking eye movements',
            ),
            235 =>
            array(
                'id' => 236,
                'cc_text' => 'Joint aches',
            ),
            236 =>
            array(
                'id' => 237,
                'cc_text' => 'Joint instability',
            ),
            237 =>
            array(
                'id' => 238,
                'cc_text' => 'Joint locking or catching',
            ),
            238 =>
            array(
                'id' => 239,
                'cc_text' => 'Joint pain',
            ),
            239 =>
            array(
                'id' => 240,
                'cc_text' => 'Jumpiness or easily startled',
            ),
            240 =>
            array(
                'id' => 241,
                'cc_text' => 'Labored breathing',
            ),
            241 =>
            array(
                'id' => 242,
                'cc_text' => 'Lack of emotion',
            ),
            242 =>
            array(
                'id' => 243,
                'cc_text' => 'Lack of motivation',
            ),
            243 =>
            array(
                'id' => 244,
                'cc_text' => 'Lack of pleasure',
            ),
            244 =>
            array(
                'id' => 245,
                'cc_text' => 'Lightheadedness',
            ),
            245 =>
            array(
                'id' => 246,
                'cc_text' => 'Loss of balance',
            ),
            246 =>
            array(
                'id' => 247,
                'cc_text' => 'Loss of consciousness',
            ),
            247 =>
            array(
                'id' => 248,
                'cc_text' => 'Loss of coordination',
            ),
            248 =>
            array(
                'id' => 249,
                'cc_text' => 'Loss of height',
            ),
            249 =>
            array(
                'id' => 250,
                'cc_text' => 'Loss of outside 1/3 of eyebrow (unintentional)',
            ),
            250 =>
            array(
                'id' => 251,
                'cc_text' => 'Loss of side vision',
            ),
            251 =>
            array(
                'id' => 252,
                'cc_text' => 'Loss of voice',
            ),
            252 =>
            array(
                'id' => 253,
                'cc_text' => 'Low blood pressure',
            ),
            253 =>
            array(
                'id' => 254,
                'cc_text' => 'Low self-esteem',
            ),
            254 =>
            array(
                'id' => 255,
                'cc_text' => 'Lump or bulge',
            ),
            255 =>
            array(
                'id' => 256,
                'cc_text' => 'Memory problems',
            ),
            256 =>
            array(
                'id' => 257,
                'cc_text' => 'Metallic taste in mouth',
            ),
            257 =>
            array(
                'id' => 258,
                'cc_text' => 'Missed or late menstrual period',
            ),
            258 =>
            array(
                'id' => 259,
                'cc_text' => 'Mood swings',
            ),
            259 =>
            array(
                'id' => 260,
                'cc_text' => 'Morning alcohol drinking (eye-opener)',
            ),
            260 =>
            array(
                'id' => 261,
                'cc_text' => 'Morning joint stiffness',
            ),
            261 =>
            array(
                'id' => 262,
                'cc_text' => 'Mouth sores',
            ),
            262 =>
            array(
                'id' => 263,
                'cc_text' => 'Muffled voice',
            ),
            263 =>
            array(
                'id' => 264,
                'cc_text' => 'Multiple bruises of different ages',
            ),
            264 =>
            array(
                'id' => 265,
                'cc_text' => 'Muscle cramps or spasms (painful)',
            ),
            265 =>
            array(
                'id' => 266,
                'cc_text' => 'Muscle stiffness (rigidity)',
            ),
            266 =>
            array(
                'id' => 267,
                'cc_text' => 'Muscle twitching (painless)',
            ),
            267 =>
            array(
                'id' => 268,
                'cc_text' => 'Muscle wasting',
            ),
            268 =>
            array(
                'id' => 269,
                'cc_text' => 'Muscle weakness',
            ),
            269 =>
            array(
                'id' => 270,
                'cc_text' => 'Nasal congestion',
            ),
            270 =>
            array(
                'id' => 271,
                'cc_text' => 'Nasal symptoms and one red eye',
            ),
            271 =>
            array(
                'id' => 272,
                'cc_text' => 'Nausea or vomiting',
            ),
            272 =>
            array(
                'id' => 273,
                'cc_text' => 'Need brighter light to read',
            ),
            273 =>
            array(
                'id' => 274,
                'cc_text' => 'Nervousness',
            ),
            274 =>
            array(
                'id' => 275,
                'cc_text' => 'New onset asthma',
            ),
            275 =>
            array(
                'id' => 276,
                'cc_text' => 'Night sweats',
            ),
            276 =>
            array(
                'id' => 277,
                'cc_text' => 'Nighttime wheezing',
            ),
            277 =>
            array(
                'id' => 278,
                'cc_text' => 'No menstrual periods',
            ),
            278 =>
            array(
                'id' => 279,
                'cc_text' => 'Noisy breathing',
            ),
            279 =>
            array(
                'id' => 280,
                'cc_text' => 'Nosebleed',
            ),
            280 =>
            array(
                'id' => 281,
                'cc_text' => 'Numbness or tingling',
            ),
            281 =>
            array(
                'id' => 282,
                'cc_text' => 'Overweight',
            ),
            282 =>
            array(
                'id' => 283,
                'cc_text' => 'Pain during erection',
            ),
            283 =>
            array(
                'id' => 284,
                'cc_text' => 'Pain or discomfort',
            ),
            284 =>
            array(
                'id' => 285,
                'cc_text' => 'Pain when moving eyes',
            ),
            285 =>
            array(
                'id' => 286,
                'cc_text' => 'Pain when swallowing',
            ),
            286 =>
            array(
                'id' => 287,
                'cc_text' => 'Pain with sexual intercourse (female)',
            ),
            287 =>
            array(
                'id' => 288,
                'cc_text' => 'Pain with sexual intercourse (male)',
            ),
            288 =>
            array(
                'id' => 289,
                'cc_text' => 'Pain with urination',
            ),
            289 =>
            array(
                'id' => 290,
                'cc_text' => 'Painful bowel movements',
            ),
            290 =>
            array(
                'id' => 291,
                'cc_text' => 'Painful ejaculation',
            ),
            291 =>
            array(
                'id' => 292,
                'cc_text' => 'Painful red lump on eyelid',
            ),
            292 =>
            array(
                'id' => 293,
                'cc_text' => 'Pale skin',
            ),
            293 =>
            array(
                'id' => 294,
                'cc_text' => 'Palpitations (fluttering in chest)',
            ),
            294 =>
            array(
                'id' => 295,
                'cc_text' => 'Paranoid behavior',
            ),
            295 =>
            array(
                'id' => 296,
                'cc_text' => 'Partial vision loss',
            ),
            296 =>
            array(
                'id' => 297,
                'cc_text' => 'Personality changes',
            ),
            297 =>
            array(
                'id' => 298,
                'cc_text' => 'Poor concentration',
            ),
            298 =>
            array(
                'id' => 299,
                'cc_text' => 'Poor personal hygiene',
            ),
            299 =>
            array(
                'id' => 300,
                'cc_text' => 'Popping or snapping sound from joint',
            ),
            300 =>
            array(
                'id' => 301,
                'cc_text' => 'Post nasal drip',
            ),
            301 =>
            array(
                'id' => 302,
                'cc_text' => 'Pounding heart (pulse)',
            ),
            302 =>
            array(
                'id' => 303,
                'cc_text' => 'Premature ejaculation',
            ),
            303 =>
            array(
                'id' => 304,
                'cc_text' => 'Pressure or fullness',
            ),
            304 =>
            array(
                'id' => 305,
                'cc_text' => 'Pressure or heaviness',
            ),
            305 =>
            array(
                'id' => 306,
                'cc_text' => 'Prolonged bleeding',
            ),
            306 =>
            array(
                'id' => 307,
                'cc_text' => 'Prolonged breathing pauses',
            ),
            307 =>
            array(
                'id' => 308,
                'cc_text' => 'Protruding rectal material',
            ),
            308 =>
            array(
                'id' => 309,
                'cc_text' => 'Protruding vaginal material',
            ),
            309 =>
            array(
                'id' => 310,
                'cc_text' => 'Puffy eyelids',
            ),
            310 =>
            array(
                'id' => 311,
                'cc_text' => 'Pulling out beard',
            ),
            311 =>
            array(
                'id' => 312,
                'cc_text' => 'Pulling out eyebrows',
            ),
            312 =>
            array(
                'id' => 313,
                'cc_text' => 'Pulling out eyelashes',
            ),
            313 =>
            array(
                'id' => 314,
                'cc_text' => 'Pulling out hair',
            ),
            314 =>
            array(
                'id' => 315,
                'cc_text' => 'Pulsating sensation',
            ),
            315 =>
            array(
                'id' => 316,
                'cc_text' => 'Punching or kicking in sleep',
            ),
            316 =>
            array(
                'id' => 317,
                'cc_text' => 'Rapid breathing',
            ),
            317 =>
            array(
                'id' => 318,
                'cc_text' => 'Rapid heart rate (pulse)',
            ),
            318 =>
            array(
                'id' => 319,
                'cc_text' => 'Rapid speech',
            ),
            319 =>
            array(
                'id' => 320,
                'cc_text' => 'Recent (short-term) memory loss',
            ),
            320 =>
            array(
                'id' => 321,
                'cc_text' => 'Red (bloodshot) eyes',
            ),
            321 =>
            array(
                'id' => 322,
                'cc_text' => 'Red (strawberry) tongue',
            ),
            322 =>
            array(
                'id' => 323,
                'cc_text' => 'Red eye (single)',
            ),
            323 =>
            array(
                'id' => 324,
                'cc_text' => 'Red gums',
            ),
            324 =>
            array(
                'id' => 325,
                'cc_text' => 'Red or black spots on fingernails',
            ),
            325 =>
            array(
                'id' => 326,
                'cc_text' => 'Red spots',
            ),
            326 =>
            array(
                'id' => 327,
                'cc_text' => 'Red spots inside lower eyelid',
            ),
            327 =>
            array(
                'id' => 328,
                'cc_text' => 'Reduced productivity at work',
            ),
            328 =>
            array(
                'id' => 329,
                'cc_text' => 'Regurgitation of food or liquid',
            ),
            329 =>
            array(
                'id' => 330,
                'cc_text' => 'Repeats phrases',
            ),
            330 =>
            array(
                'id' => 331,
                'cc_text' => 'Repetitive behaviors',
            ),
            331 =>
            array(
                'id' => 332,
                'cc_text' => 'Restless (tossing and turning) sleep',
            ),
            332 =>
            array(
                'id' => 333,
                'cc_text' => 'Restless (urge to move) legs',
            ),
            333 =>
            array(
                'id' => 334,
                'cc_text' => 'Restless or irritability',
            ),
            334 =>
            array(
                'id' => 335,
                'cc_text' => 'Restrictive dieting',
            ),
            335 =>
            array(
                'id' => 336,
                'cc_text' => 'Ringing in ears',
            ),
            336 =>
            array(
                'id' => 337,
                'cc_text' => 'Runny nose',
            ),
            337 =>
            array(
                'id' => 338,
                'cc_text' => 'Sadness',
            ),
            338 =>
            array(
                'id' => 339,
                'cc_text' => 'Scaley skin on eyelids',
            ),
            339 =>
            array(
                'id' => 340,
                'cc_text' => 'See letters, numbers or musical notes as colors',
            ),
            340 =>
            array(
                'id' => 341,
                'cc_text' => 'Seizures (uncontrollable jerking of limbs)',
            ),
            341 =>
            array(
                'id' => 342,
                'cc_text' => 'Sensation of something in eye',
            ),
            342 =>
            array(
                'id' => 343,
                'cc_text' => 'Sense of impending doom',
            ),
            343 =>
            array(
                'id' => 344,
                'cc_text' => 'Sensitive to light',
            ),
            344 =>
            array(
                'id' => 345,
                'cc_text' => 'Sensitive to noise',
            ),
            345 =>
            array(
                'id' => 346,
                'cc_text' => 'Shadow over part of vision',
            ),
            346 =>
            array(
                'id' => 347,
                'cc_text' => 'Shaking',
            ),
            347 =>
            array(
                'id' => 348,
                'cc_text' => 'Shaking chills (rigors)',
            ),
            348 =>
            array(
                'id' => 349,
                'cc_text' => 'Shaking hands or tremor',
            ),
            349 =>
            array(
                'id' => 350,
                'cc_text' => 'Short arms and legs',
            ),
            350 =>
            array(
                'id' => 351,
                'cc_text' => 'Short attention span',
            ),
            351 =>
            array(
                'id' => 352,
                'cc_text' => 'Short stature',
            ),
            352 =>
            array(
                'id' => 353,
                'cc_text' => 'Short, wide neck',
            ),
            353 =>
            array(
                'id' => 354,
                'cc_text' => 'Shortening of limb',
            ),
            354 =>
            array(
                'id' => 355,
                'cc_text' => 'Shortness of breath',
            ),
            355 =>
            array(
                'id' => 356,
                'cc_text' => 'Shuffling gait (feet)',
            ),
            356 =>
            array(
                'id' => 357,
                'cc_text' => 'Single palm crease',
            ),
            357 =>
            array(
                'id' => 358,
                'cc_text' => 'Skin blisters',
            ),
            358 =>
            array(
                'id' => 359,
                'cc_text' => 'Skin bumps',
            ),
            359 =>
            array(
                'id' => 360,
                'cc_text' => 'Skin darkening',
            ),
            360 =>
            array(
                'id' => 361,
                'cc_text' => 'Skin hardening',
            ),
            361 =>
            array(
                'id' => 362,
                'cc_text' => 'Skin irritation',
            ),
            362 =>
            array(
                'id' => 363,
                'cc_text' => 'Skin open sore',
            ),
            363 =>
            array(
                'id' => 364,
                'cc_text' => 'Skin peeling, cracking or scaling',
            ),
            364 =>
            array(
                'id' => 365,
                'cc_text' => 'Skin rash',
            ),
            365 =>
            array(
                'id' => 366,
                'cc_text' => 'Skin redness',
            ),
            366 =>
            array(
                'id' => 367,
                'cc_text' => 'Skin thickening',
            ),
            367 =>
            array(
                'id' => 368,
                'cc_text' => 'Sleep walking',
            ),
            368 =>
            array(
                'id' => 369,
                'cc_text' => 'Slow growth (failure to thrive)',
            ),
            369 =>
            array(
                'id' => 370,
                'cc_text' => 'Slow heart rate (pulse)',
            ),
            370 =>
            array(
                'id' => 371,
                'cc_text' => 'Slow or irregular breathing',
            ),
            371 =>
            array(
                'id' => 372,
                'cc_text' => 'Slow or weak urine stream',
            ),
            372 =>
            array(
                'id' => 373,
                'cc_text' => 'Slow thinking',
            ),
            373 =>
            array(
                'id' => 374,
                'cc_text' => 'Slurred speech',
            ),
            374 =>
            array(
                'id' => 375,
                'cc_text' => 'Small (constricted) pupils',
            ),
            375 =>
            array(
                'id' => 376,
                'cc_text' => 'Smooth tongue',
            ),
            376 =>
            array(
                'id' => 377,
                'cc_text' => 'Sneezing',
            ),
            377 =>
            array(
                'id' => 378,
                'cc_text' => 'Snoring',
            ),
            378 =>
            array(
                'id' => 379,
                'cc_text' => 'Socially withdrawn',
            ),
            379 =>
            array(
                'id' => 380,
                'cc_text' => 'Sore or burning eyes',
            ),
            380 =>
            array(
                'id' => 381,
                'cc_text' => 'Sore throat',
            ),
            381 =>
            array(
                'id' => 382,
                'cc_text' => 'Sore tongue',
            ),
            382 =>
            array(
                'id' => 383,
                'cc_text' => 'Soreness or burning inside of mouth',
            ),
            383 =>
            array(
                'id' => 384,
                'cc_text' => 'Spinning sensation',
            ),
            384 =>
            array(
                'id' => 385,
                'cc_text' => 'Spots on throat',
            ),
            385 =>
            array(
                'id' => 386,
                'cc_text' => 'Spots on tonsils',
            ),
            386 =>
            array(
                'id' => 387,
                'cc_text' => 'Squatting',
            ),
            387 =>
            array(
                'id' => 388,
                'cc_text' => 'Squinting eyes',
            ),
            388 =>
            array(
                'id' => 389,
                'cc_text' => 'Stiff neck',
            ),
            389 =>
            array(
                'id' => 390,
                'cc_text' => 'Stiffness or decreased movement',
            ),
            390 =>
            array(
                'id' => 391,
                'cc_text' => 'Stomach cramps',
            ),
            391 =>
            array(
                'id' => 392,
                'cc_text' => 'Stool leaking (incontinence)',
            ),
            392 =>
            array(
                'id' => 393,
                'cc_text' => 'Straining with bowel movements',
            ),
            393 =>
            array(
                'id' => 394,
                'cc_text' => 'Strange smell or taste',
            ),
            394 =>
            array(
                'id' => 395,
                'cc_text' => 'Sudden flash of lights',
            ),
            395 =>
            array(
                'id' => 396,
                'cc_text' => 'Sudden numbness or weakness on one side of body',
            ),
            396 =>
            array(
                'id' => 397,
                'cc_text' => 'Sudden urge to urinate',
            ),
            397 =>
            array(
                'id' => 398,
                'cc_text' => 'Sunken eyes',
            ),
            398 =>
            array(
                'id' => 399,
                'cc_text' => 'Sunken soft spot on top of head',
            ),
            399 =>
            array(
                'id' => 400,
                'cc_text' => 'Swelling',
            ),
            400 =>
            array(
                'id' => 401,
                'cc_text' => 'Swollen gums',
            ),
            401 =>
            array(
                'id' => 402,
                'cc_text' => 'Swollen lips',
            ),
            402 =>
            array(
                'id' => 403,
                'cc_text' => 'Swollen tongue',
            ),
            403 =>
            array(
                'id' => 404,
                'cc_text' => 'Swollen tonsils',
            ),
            404 =>
            array(
                'id' => 405,
                'cc_text' => 'Taste of acid in mouth',
            ),
            405 =>
            array(
                'id' => 406,
                'cc_text' => 'Taste words when they are heard',
            ),
            406 =>
            array(
                'id' => 407,
                'cc_text' => 'Tearing in one eye',
            ),
            407 =>
            array(
                'id' => 408,
                'cc_text' => 'Teeth do not fit like they used to',
            ),
            408 =>
            array(
                'id' => 409,
                'cc_text' => 'Tender glands',
            ),
            409 =>
            array(
                'id' => 410,
                'cc_text' => 'Tenderness to touch',
            ),
            410 =>
            array(
                'id' => 411,
                'cc_text' => 'Testicles shrinkage',
            ),
            411 =>
            array(
                'id' => 412,
                'cc_text' => 'Testicular pain',
            ),
            412 =>
            array(
                'id' => 413,
                'cc_text' => 'Thick saliva or mucus',
            ),
            413 =>
            array(
                'id' => 414,
                'cc_text' => 'Thin (pencil) stools',
            ),
            414 =>
            array(
                'id' => 415,
                'cc_text' => 'Throat tightness',
            ),
            415 =>
            array(
                'id' => 416,
                'cc_text' => 'Tightness',
            ),
            416 =>
            array(
                'id' => 417,
                'cc_text' => 'Tilts head to look at something',
            ),
            417 =>
            array(
                'id' => 418,
                'cc_text' => 'Tires quickly',
            ),
            418 =>
            array(
                'id' => 419,
                'cc_text' => 'Trembling',
            ),
            419 =>
            array(
                'id' => 420,
                'cc_text' => 'Trouble distinguishing color shades',
            ),
            420 =>
            array(
                'id' => 421,
                'cc_text' => 'Twisting or rotation of limb',
            ),
            421 =>
            array(
                'id' => 422,
                'cc_text' => 'Unable to bear weight',
            ),
            422 =>
            array(
                'id' => 423,
                'cc_text' => 'Unable to bend foot down',
            ),
            423 =>
            array(
                'id' => 424,
                'cc_text' => 'Unable to blink or close eyelid',
            ),
            424 =>
            array(
                'id' => 425,
                'cc_text' => 'Unable to grip (hands)',
            ),
            425 =>
            array(
                'id' => 426,
                'cc_text' => 'Unable to move arm',
            ),
            426 =>
            array(
                'id' => 427,
                'cc_text' => 'Unable to move joint',
            ),
            427 =>
            array(
                'id' => 428,
                'cc_text' => 'Unable to move leg',
            ),
            428 =>
            array(
                'id' => 429,
                'cc_text' => 'Unable to obtain or maintain erection',
            ),
            429 =>
            array(
                'id' => 430,
                'cc_text' => 'Unable to open mouth (jaw)',
            ),
            430 =>
            array(
                'id' => 431,
                'cc_text' => 'Uncontrollable verbal outbursts',
            ),
            431 =>
            array(
                'id' => 432,
                'cc_text' => 'Unequal pupils (size)',
            ),
            432 =>
            array(
                'id' => 433,
                'cc_text' => 'Unusual behavior',
            ),
            433 =>
            array(
                'id' => 434,
                'cc_text' => 'Unusual facial expression',
            ),
            434 =>
            array(
                'id' => 435,
                'cc_text' => 'Unusual or suspicious mole',
            ),
            435 =>
            array(
                'id' => 436,
                'cc_text' => 'Unusual taste in mouth',
            ),
            436 =>
            array(
                'id' => 437,
                'cc_text' => 'Unusually short forth fingers',
            ),
            437 =>
            array(
                'id' => 438,
                'cc_text' => 'Upset stomach',
            ),
            438 =>
            array(
                'id' => 439,
                'cc_text' => 'Upward curving (spooning) of nails',
            ),
            439 =>
            array(
                'id' => 440,
                'cc_text' => 'Urine leaking (incontinence)',
            ),
            440 =>
            array(
                'id' => 441,
                'cc_text' => 'Vaginal bleeding',
            ),
            441 =>
            array(
                'id' => 442,
                'cc_text' => 'Vaginal bleeding after menopause',
            ),
            442 =>
            array(
                'id' => 443,
                'cc_text' => 'Vaginal bleeding between periods',
            ),
            443 =>
            array(
                'id' => 444,
                'cc_text' => 'Vaginal discharge',
            ),
            444 =>
            array(
                'id' => 445,
                'cc_text' => 'Vaginal dryness',
            ),
            445 =>
            array(
                'id' => 446,
                'cc_text' => 'Vaginal odor',
            ),
            446 =>
            array(
                'id' => 447,
                'cc_text' => 'Visible bugs or parasites',
            ),
            447 =>
            array(
                'id' => 448,
                'cc_text' => 'Visible deformity',
            ),
            448 =>
            array(
                'id' => 449,
                'cc_text' => 'Visible pulsations',
            ),
            449 =>
            array(
                'id' => 450,
                'cc_text' => 'Vision fading of colors',
            ),
            450 =>
            array(
                'id' => 451,
                'cc_text' => 'Visual halos around lights',
            ),
            451 =>
            array(
                'id' => 452,
                'cc_text' => 'Warm to touch',
            ),
            452 =>
            array(
                'id' => 453,
                'cc_text' => 'Watery eyes',
            ),
            453 =>
            array(
                'id' => 454,
                'cc_text' => 'Weakness',
            ),
            454 =>
            array(
                'id' => 455,
                'cc_text' => 'Weakness (generalized)',
            ),
            455 =>
            array(
                'id' => 456,
                'cc_text' => 'Weight gain',
            ),
            456 =>
            array(
                'id' => 457,
                'cc_text' => 'Weight loss (intentional)',
            ),
            457 =>
            array(
                'id' => 458,
                'cc_text' => 'Weight loss (unintentional)',
            ),
            458 =>
            array(
                'id' => 459,
                'cc_text' => 'Welts',
            ),
            459 =>
            array(
                'id' => 460,
                'cc_text' => 'Wheezing',
            ),
            460 =>
            array(
                'id' => 461,
                'cc_text' => 'White patches inside mouth',
            ),
            461 =>
            array(
                'id' => 462,
                'cc_text' => 'White patches on tongue',
            ),
            462 =>
            array(
                'id' => 463,
                'cc_text' => 'Worms in stool',
            ),
            463 =>
            array(
                'id' => 464,
                'cc_text' => 'Yelling out during sleep',
            ),
            464 =>
            array(
                'id' => 465,
                'cc_text' => 'Yellow eyes',
            ),
            465 =>
            array(
                'id' => 466,
                'cc_text' => 'Yellow skin',
            ),
        ));
    }

}
