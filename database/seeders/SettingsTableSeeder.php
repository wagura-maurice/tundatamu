<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('settings')->delete();
        
        \DB::table('settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'item' => 'CUSTOMER_CARE_CALLER_ID',
                'default_value' => '+254 712 526 952',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-02-20 14:19:26',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'item' => 'MPESA_LNMO_CONSUMER_KEY',
                'default_value' => 'uKxU78Y9q2cFruO2fKRWuofRCObzMQh8',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:40',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'item' => 'MPESA_LNMO_CONSUMER_SECRET',
                'default_value' => 'By9NUqT7NGhzy5Pj',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:43',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'item' => 'MPESA_LNMO_ENVIRONMENT',
                'default_value' => 'sandbox',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:46',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'item' => 'MPESA_LNMO_INITIATOR_PASSWORD',
                'default_value' => 'HaVh3tgp',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:48',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'item' => 'MPESA_LNMO_INITIATOR_USERNAME',
                'default_value' => 'testapi779',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:51',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'item' => 'MPESA_LNMO_PASS_KEY',
                'default_value' => 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:53',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'item' => 'MPESA_LNMO_SHORT_CODE',
                'default_value' => '174379',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:56',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'item' => 'MPESA_LNMO_TILL_NUMBER',
                'default_value' => '174379',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:35:58',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'item' => 'ZETTA_TEL_MESSAGING_ENDPOINT',
                'default_value' => 'https://portal.zettatel.com/SMSApi/send',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:36:47',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'item' => 'ZETTA_TEL_DELIVERY_STATUS_ENDPOINT',
                'default_value' => 'https://portal.zettatel.com/SMSApi/report/status',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:36:50',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'item' => 'ZETTA_TEL_ACCOUNT_BALANCE_ENDPOINT',
                'default_value' => 'https://portal.zettatel.com/SMSApi/account/readstatus',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:36:53',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'item' => 'ZETTA_TEL_API_KEY',
                'default_value' => 'bb7a28b78f1dfaeabc14a7b7d058542cd8c2da93',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:36:55',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'item' => 'ZETTA_TEL_USER_ID',
                'default_value' => 'mhub1',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:36:58',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'item' => 'ZETTA_TEL_USER_PASSWORD',
                'default_value' => 'YbjVbjxe',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:37:00',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'item' => 'ZETTA_TEL_SENDER_ID',
                'default_value' => 'ZTSMS',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:37:02',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'item' => 'ZETTA_ACCOUNT_BALANCE',
                'default_value' => '0',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:37:05',
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'item' => 'USSD_CODE',
                'default_value' => '*384*67#',
                'current_value' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:37:07',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}