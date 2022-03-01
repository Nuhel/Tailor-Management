<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Master;
use App\Models\Service;
use App\Models\ServiceDesign;
use App\Models\ServiceDesignStyle;
use App\Models\ServiceMeasurement;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create();
        Customer::factory(112)->create();
        Employee::factory(12)->create();
        Master::factory(12)->create();
        $this->createServices();
        $this->createMeasurements();
        $this->createDesign();
        $this->createStyle();


    }

    public function createServices(){
        $names = [
            'Shirt',
            'Pant',
            //'Mujib Coat'
        ];
        $services = [];
        for($i = 0 ; $i<=1; $i++){
            $services[$i]['name'] = $names[$i];
            $services[$i]['created_at'] = now();
            $services[$i]['updated_at'] = now();
        }
        Service::insert($services);
    }


    public function createMeasurements(){
        $data = [
            [
                'name' => 'Neck to Shoulder',
                'service_id' => 1,
            ],[
                'name' => 'Sleeve length',
                'service_id' => 1,
            ],[
                'name' => 'Shoulder to Shoulder',
                'service_id' => 1,
            ],[
                'name' => 'Chest',
                'service_id' => 1,
            ],[
                'name' => 'Waist',
                'service_id' => 1,
            ],




            [
                'name' => 'Waist',
                'service_id' => 2,
            ],[
                'name' => 'Hips',
                'service_id' => 2,
            ],[
                'name' => 'Thigh',
                'service_id' => 2,
            ],[
                'name' => 'Knee',
                'service_id' => 2,
            ],[
                'name' => 'Instep',
                'service_id' => 2,
            ]
        ];

        foreach($data as $index=>$value){
            $data[$index]['created_at'] = now();
            $data[$index]['updated_at'] = now();
        }
        ServiceMeasurement::insert($data);
    }

    public function createDesign(){
        $data = [
            [
                'name' => 'Collar',
                'service_id' => 1,
            ],[
                'name' => 'Sleeve',
                'service_id' => 1,
            ],[
                'name' => 'Pocket',
                'service_id' => 2,
            ],[
                'name' => 'Loosen',
                'service_id' => 2,
            ],
        ];
        foreach($data as $index=>$value){
            $data[$index]['created_at'] = now();
            $data[$index]['updated_at'] = now();
        }
        ServiceDesign::insert($data);
    }


    public function createStyle(){
        $data = [
            [
                'name' => 'Plain Collar',
                'service_design_id' => 1,
            ],[
                'name' => 'Round Collar',
                'service_design_id' => 1,
            ],[
                'name' => 'Cup Collar',
                'service_design_id' => 1,
            ],[
                'name' => 'Half Sleeve',
                'service_design_id' => 2,
            ],[
                'name' => 'Full Sleeve',
                'service_design_id' => 2,
            ],


            [
                'name' => '2 Pocket',
                'service_design_id' => 3,
            ],
            [
                'name' => '4 Pocket',
                'service_design_id' => 3,
            ],

            [
                'name' => 'Narrow',
                'service_design_id' => 4,
            ],

            [
                'name' => 'Tight',
                'service_design_id' => 4,
            ],
        ];
        foreach($data as $index=>$value){
            $data[$index]['created_at'] = now();
            $data[$index]['updated_at'] = now();
        }
        ServiceDesignStyle::insert($data);
    }
}
