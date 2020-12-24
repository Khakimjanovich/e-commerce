<?php

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            'Namangan' => "Nam"
        ];

        collect($regions)->each(function ($code, $name) {
            Region::create([
                'code' => $code,
                'name' => $name
            ]);
        });
    }
}
