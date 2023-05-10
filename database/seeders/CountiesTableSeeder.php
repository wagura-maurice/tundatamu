<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('counties')->delete();
        
        \DB::table('counties')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => 1,
                'name' => 'mombasa',
                'province' => 'coast',
                'headquarter' => 'mombasa',
                'abbreviation' => 'msa',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'code' => 2,
                'name' => 'kwale',
                'province' => 'coast',
                'headquarter' => 'kwale',
                'abbreviation' => 'kwl',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'code' => 3,
                'name' => 'kilifi',
                'province' => 'coast',
                'headquarter' => 'kilifi',
                'abbreviation' => 'klf',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'code' => 4,
                'name' => 'tana river',
                'province' => 'coast',
                'headquarter' => 'hola',
                'abbreviation' => 'trv',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'code' => 5,
                'name' => 'lamu',
                'province' => 'coast',
                'headquarter' => 'lamu',
                'abbreviation' => 'lmu',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'code' => 6,
                'name' => 'taita–taveta',
                'province' => 'coast',
                'headquarter' => 'wundanyi',
                'abbreviation' => 'tvt',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'code' => 7,
                'name' => 'garissa',
                'province' => 'north eastern',
                'headquarter' => 'garissa',
                'abbreviation' => 'grs',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'code' => 8,
                'name' => 'wajir',
                'province' => 'north eastern',
                'headquarter' => 'wajir',
                'abbreviation' => 'wjr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'code' => 9,
                'name' => 'mandera',
                'province' => 'north eastern',
                'headquarter' => 'mandera',
                'abbreviation' => 'mdr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'code' => 10,
                'name' => 'marsabit',
                'province' => 'eastern',
                'headquarter' => 'marsabit',
                'abbreviation' => 'mrs',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'code' => 11,
                'name' => 'isiolo',
                'province' => 'eastern',
                'headquarter' => 'isiolo',
                'abbreviation' => 'isl',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'code' => 12,
                'name' => 'meru',
                'province' => 'eastern',
                'headquarter' => 'meru',
                'abbreviation' => 'mru',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'code' => 13,
                'name' => 'tharaka-nithi',
                'province' => 'eastern',
                'headquarter' => 'kathwana',
                'abbreviation' => 'tnt',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'code' => 14,
                'name' => 'embu',
                'province' => 'eastern',
                'headquarter' => 'embu',
                'abbreviation' => 'emb',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'code' => 15,
                'name' => 'kitui',
                'province' => 'eastern',
                'headquarter' => 'kitui',
                'abbreviation' => 'ktu',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'code' => 16,
                'name' => 'machakos',
                'province' => 'eastern',
                'headquarter' => 'machakos',
                'abbreviation' => 'mck',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'code' => 17,
                'name' => 'makueni',
                'province' => 'eastern',
                'headquarter' => 'wote',
                'abbreviation' => 'mkn',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'code' => 18,
                'name' => 'nyandarua',
                'province' => 'central',
                'headquarter' => 'ol kalou',
                'abbreviation' => 'ndr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'code' => 19,
                'name' => 'nyeri',
                'province' => 'central',
                'headquarter' => 'nyeri',
                'abbreviation' => 'nyr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'code' => 20,
                'name' => 'kirinyaga',
                'province' => 'central',
                'headquarter' => 'kerugoya',
                'abbreviation' => 'krg',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'code' => 21,
                'name' => 'muranga',
                'province' => 'central',
                'headquarter' => 'muranga',
                'abbreviation' => 'mrg',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'code' => 22,
                'name' => 'kiambu',
                'province' => 'central',
                'headquarter' => 'kiambu',
                'abbreviation' => 'kmb',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'code' => 23,
                'name' => 'turkana',
                'province' => 'rift valley',
                'headquarter' => 'lodwar',
                'abbreviation' => 'trk',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'code' => 24,
                'name' => 'west pokot',
                'province' => 'rift valley',
                'headquarter' => 'kapenguria',
                'abbreviation' => 'wpk',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'code' => 25,
                'name' => 'samburu',
                'province' => 'rift valley',
                'headquarter' => 'maralal',
                'abbreviation' => 'sbr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 26,
                'code' => 26,
                'name' => 'trans-nzoia',
                'province' => 'rift valley',
                'headquarter' => 'kitale',
                'abbreviation' => 'tnz',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 27,
                'code' => 27,
                'name' => 'uasin gishu',
                'province' => 'rift valley',
                'headquarter' => 'eldoret',
                'abbreviation' => 'ugs',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 28,
                'code' => 28,
                'name' => 'elgeyo-marakwet',
                'province' => 'rift valley',
                'headquarter' => 'iten',
                'abbreviation' => 'emk',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 29,
                'code' => 29,
                'name' => 'nandi',
                'province' => 'rift valley',
                'headquarter' => 'kapsabet',
                'abbreviation' => 'ndi',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 30,
                'code' => 30,
                'name' => 'baringo',
                'province' => 'rift valley',
                'headquarter' => 'kabarnet',
                'abbreviation' => 'brg',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 31,
                'code' => 31,
                'name' => 'laikipia',
                'province' => 'rift valley',
                'headquarter' => 'rumuruti',
                'abbreviation' => 'lkp',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 32,
                'code' => 32,
                'name' => 'nakuru',
                'province' => 'rift valley',
                'headquarter' => 'nakuru',
                'abbreviation' => 'nkr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 33,
                'code' => 33,
                'name' => 'narok',
                'province' => 'rift valley',
                'headquarter' => 'narok',
                'abbreviation' => 'nrk',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 34,
                'code' => 34,
                'name' => 'kajiado',
                'province' => 'rift valley',
                'headquarter' => 'kajiado',
                'abbreviation' => 'kjd',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 35,
                'code' => 35,
                'name' => 'kericho',
                'province' => 'rift valley',
                'headquarter' => 'kericho',
                'abbreviation' => 'krc',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 36,
                'code' => 36,
                'name' => 'bomet',
                'province' => 'rift valley',
                'headquarter' => 'bomet',
                'abbreviation' => 'bmt',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 37,
                'code' => 37,
                'name' => 'kakamega',
                'province' => 'western',
                'headquarter' => 'kakamega',
                'abbreviation' => 'kkg',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 38,
                'code' => 38,
                'name' => 'vihiga',
                'province' => 'western',
                'headquarter' => 'mbale',
                'abbreviation' => 'vhg',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 39,
                'code' => 39,
                'name' => 'bungoma',
                'province' => 'western',
                'headquarter' => 'bungoma',
                'abbreviation' => 'bgm',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 40,
                'code' => 40,
                'name' => 'busia',
                'province' => 'western',
                'headquarter' => 'busia',
                'abbreviation' => 'bsa',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 41,
                'code' => 41,
                'name' => 'siaya',
                'province' => 'nyanza',
                'headquarter' => 'siaya',
                'abbreviation' => 'sya',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 42,
                'code' => 42,
                'name' => 'kisumu',
                'province' => 'nyanza',
                'headquarter' => 'kisumu',
                'abbreviation' => 'ksm',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 43,
                'code' => 43,
                'name' => 'homa bay',
                'province' => 'nyanza',
                'headquarter' => 'homa bay',
                'abbreviation' => 'hby',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 44,
                'code' => 44,
                'name' => 'migori',
                'province' => 'nyanza',
                'headquarter' => 'migori',
                'abbreviation' => 'mgr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 45,
                'code' => 45,
                'name' => 'kisii',
                'province' => 'nyanza',
                'headquarter' => 'kisii',
                'abbreviation' => 'ksi',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 46,
                'code' => 46,
                'name' => 'nyamira',
                'province' => 'nyanza',
                'headquarter' => 'nyamira',
                'abbreviation' => 'nmr',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 47,
                'code' => 47,
                'name' => 'nairobi',
                'province' => 'nairobi',
                'headquarter' => 'nairobi',
                'abbreviation' => 'nbo',
                'created_at' => '2023-03-08 09:23:44',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}