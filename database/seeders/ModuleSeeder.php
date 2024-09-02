<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $module_array = array(
            0 => "User",
            1 => "Service",
            2 => "Business",
            3 => "Category",
            4 => "Sub_category",
            5 => "Booking",
            6 => "Coupon",
            7 => "Advertisement",
        );

        for ($i = 0; $i < count($module_array); $i++) {
            Module::create([
                "name" => $module_array[$i],
            ]);
        }

    }
}
