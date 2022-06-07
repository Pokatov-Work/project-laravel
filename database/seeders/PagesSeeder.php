<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use \Onessa5\Onessa5Core\Models\PageTree;
use \Onessa5\Onessa5Core\Models\BaseModel;
use \Onessa5\Onessa5Core\Models\Page;
use \Onessa5\Onessa5Core\Models\PageData;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $indexPage = Page::create([
            'name'     => 'index',
            'slug'    => '/',
            'title'    => 'index',
            'is_active' => true,
            'data_config' => [
                'form'=>'\App\Admin\Http\Sections\pages\SIndexPage',
                'model' =>'\App\Models\pages\IndexPage',
                'view' =>'pages.index',
                'convertor' =>''
            ],
            'meta_list' => [
                'seo' => ['description'=>'','keywords'=>''],
                'yandex_verification' => '',
                'google_site_verification' => '',
                'og' => [
                    'url' => '',
                    'title' => '',
                    'description' => '',
                    'image' => '',
                    'image_secure_url' => '',
                ],
                'twitter'=>[
                    'url' => '',
                    'title' => '',
                    'description' => '',
                    'image' => '',
                    'card' => '',
                ],
                'vk' => [
                    'image' => ''
                ],
                'name_list' =>[],
                'property_list' => []
            ],
            'data_value' => ['blocks'=>[]],
            'created_by' => 1
        ]);


        $indexPageData = PageData::create([
            'ulid_page' => $indexPage->ulid,
            'data'=> []
            ]);

         $indexTreePage = PageTree::create([
             'ulid_page' => $indexPage->ulid,
             'slug'    => ''
         ]);

    }
}
