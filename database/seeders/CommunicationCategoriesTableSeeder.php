<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommunicationCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('communication_categories')->delete();
        
        \DB::table('communication_categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Land Preparation',
                'slug' => 'land_preparation',
                'description' => NULL,
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Crop Planting',
                'slug' => 'crop_planting',
                'description' => 'Fertilization and Planting/Seed Rate/Spacing',
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Crop Management',
                'slug' => 'crop_management',
                'description' => 'Weed Management &Top Dressing, Disease and Pest Management

',
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Crop Harvesting',
                'slug' => 'crop_harvesting',
                'description' => 'Harvesting  / PHH
',
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Loan Application',
                'slug' => 'loan_application',
                'description' => NULL,
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Loan Re-Payment',
                'slug' => 'loan_repayment',
                'description' => NULL,
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Planting Inputs Request',
                'slug' => 'planting_inputs_request',
                'description' => NULL,
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Covid-19 Awearness',
                'slug' => 'covid19_awearness',
                'description' => NULL,
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'General Notification',
                'slug' => 'general_notification',
                'description' => 'for distribution ofrogram information',
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:38:03',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Onboarding Notification',
                'slug' => 'onboarding_notification',
                'description' => 'for new farmers onboarded via USSD',
                'template' => 'welcome {NAME} to GIZ yellow passion fruit, digital platform.',
                'deleted_at' => NULL,
                'created_at' => '2023-03-06 16:39:58',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}