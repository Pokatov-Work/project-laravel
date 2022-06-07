<?php


namespace App\Models\layouts;

use App\Models\options\MainMenu;
use Illuminate\Support\Facades\Log;
use Onessa5\Onessa5Core\Models\ILayoutModelModify;
use Onessa5\Onessa5Core\Models\Page;
use Onessa5\Onessa5Core\Models\PageTree;

class LayoutMenu extends \Onessa5\Onessa5Core\Models\SiteLayout implements ILayoutModelModify {
    /**
     * Модификация модели из модулей (возможно не будет применяться), а заменится на trait
     */
    public static function modifyModel() {

    }

    /**
     * Получение данных для отображения
     */
    public function getData() {

        $data = MainMenu::getMenu();

        return $data;
    }
}
