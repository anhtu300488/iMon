<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            [
                'name' => 'administrator',
                'display_name' => 'Administrator Permission',
                'description' => 'All Permission'
            ],
            [
                'name' => 'admin',
                'display_name' => 'Admin Permission',
                'description' => 'Admin Permission '
            ],
            [
                'name' => 'customer_care',
                'display_name' => 'Customer Care Permission',
                'description' => 'Customer Care Permission'
            ],
            [
                'name' => 'cp',
                'display_name' => 'CP Permission',
                'description' => 'CP Permission'
            ],
            [
                'name' => 'investor',
                'display_name' => 'Investor Permission',
                'description' => 'Investor Permission'
            ],
            [
                'name' => 'content_web',
                'display_name' => 'Content Web Permission',
                'description' => 'Content Web Permission'
            ],
            [
                'name' => 'sms_lookup',
                'display_name' => 'SMS Lookup Permission',
                'description' => 'SMS Lookup Permission'
            ]
        ];

        foreach ($permission as $key => $value) {
            Permission::create($value);
        }
    }
}
