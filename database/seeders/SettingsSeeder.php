<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use \Onessa5\Onessa5Core\Models\SiteSetting;

/**
 * Заполнение настроек сайта
 */
class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indexPage = SiteSetting::create([
            'analytics' =>'',
            'settings' => [
                'icon' => '',
                'apple_touch_icon' => '',
                'apple_touch_icon_precomposed' => ''
            ],

            'created_by' => 1
        ]);
    }
}
