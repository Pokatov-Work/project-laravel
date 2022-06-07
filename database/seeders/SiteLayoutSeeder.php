<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use \Onessa5\Onessa5Core\Models\SiteLayout;

class SiteLayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $headerPage = SiteLayout::create([
            'name' => SiteLayout::HEADER,
            'is_active' => 0,
            'data' => [],
            'data_config' => [
                'form'=>'App\Admin\Http\Sections\layouts\SLayoutHeader',
                'model' =>'App\Models\layouts\LayoutHeader',
                'view' =>'layouts.header'
            ],
            'created_by' => 1
        ]);
        $menuPage = SiteLayout::create([
            'name' => SiteLayout::MENU,
            'is_active' => 0,
            'data' => [],
            'data_config' => [
                'form'=>'Onessa5\Onessa5Core\Admin\Http\Sections\layouts\SLayoutMenu',
                'model' =>'Onessa5\Onessa5Core\Models\layouts\LayoutMenu',
                'view' =>'layouts.menu'
            ],
            'created_by' => 1
        ]);
        $scriptsPage = SiteLayout::create([
            'name' => SiteLayout::SCRIPTS,
            'is_active' => 0,
            'data' => [],
            'data_config' => [
                'form'=>'Onessa5\Onessa5Core\Admin\Http\Sections\layouts\SLayoutScripts',
                'model' =>'Onessa5\Onessa5Core\Models\layouts\LayoutScripts',
                'view' =>'layouts.scripts'
            ],
            'created_by' => 1
        ]);

        $footerPage = SiteLayout::create([
            'name' => SiteLayout::FOOTER,
            'is_active' => 0,
            'data' => [],
            'data_config' => [
                'form'=>'App\Admin\Http\Sections\layouts\SLayoutFooter',
                'model' =>'App\Models\layouts\LayoutFooter',
                'view' =>'layouts.footer'
            ],
            'created_by' => 1
        ]);

        $formSubscribeNewsPage = SiteLayout::create([
            'name' => SiteLayout::FORM_NEWS,
            'is_active' => 0,
            'data' => [],
            'data_config' => [
                'form'=>'App\Admin\Http\Sections\layouts\SLayoutFormSubscribeNews',
                'model' =>'App\Models\layouts\LayoutFormSubscribeNews',
                'view' =>'layouts.form_news'
            ],
            'created_by' => 1
        ]);
    }
}
