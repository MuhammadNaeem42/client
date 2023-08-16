<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Country::truncate();
        $url_countries = 'https://raw.githubusercontent.com/amrsaeedhosny/countries/main/countries.json';
        $response = Http::get($url_countries);
        if ($response->successful()) {
            $countries = $response->json();
            foreach ($countries as $country) {
                $item = [
                    'name_en' => $country['english_name'],
                    'name_ar' => $country['arabic_name'],
                    'code' => $country['alpha2_code'],
                    'is_active' => 1,
                ];
                Country::updateOrCreate(['code' => $country['alpha2_code']], $item);

            }

        }
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');


    }
}
