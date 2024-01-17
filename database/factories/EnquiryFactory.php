<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enquiry>
 */
class EnquiryFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     */

    public function definition()
    {
        $origin = ['MO', 'CN', 'HK','TW','FR'];
        $degree = ['B', 'M', 'D'];
        $admission = ['EXAM', 'RECOMMEND', 'TELENT', 'DIRECT', 'OTHER'];
        $profile = ['STD', 'PAR', 'TEA', 'EDU'];
        $areacode = ['86', '853', '852', '886', '1', '44', '61', '91', '81', '49', '33', '55', '52'];
        
     
        return [
            'department_id' =>'1',
            'origin' => $origin[rand(0, count($origin) -1)],
            'degree' =>$degree[rand(0,2)],
            'admission' =>$admission[rand(0,4)],
            'profile' =>$profile[rand(0,3)],
            'apply' =>'0',
            'surname' => $this->faker->name(),
            'givenname' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'areacode' =>$areacode[rand(0, count($areacode) -1)],
            'phone' => $this->faker->phoneNumber,
        ];
    }
}
