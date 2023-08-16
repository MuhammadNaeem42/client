<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Language::truncate();
        $languages = getAvailLocaleLanguage();
        foreach ($languages as $key => $language) {
            $item = [
                'name_en' => $language['name'],
                'name_ar' => $language['native'],
                'code' => $key,
                'is_active' => 1,
            ];
            Language::updateOrCreate(['code' => $key], $item);

        }

        \DB::statement('SET FOREIGN_KEY_CHECKS=1');


    }
}
