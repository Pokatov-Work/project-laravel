<?php

namespace App\Models\layouts;

use Illuminate\Support\Facades\Log;
use Onessa5\Onessa5Core\Models\ILayoutModelModify;

/**
 * Class LayoutHeader
 * Класс для управления данными для Header
 * @package App\Models\layouts
 */

class LayoutHeader extends \Onessa5\Onessa5Core\Models\SiteLayout implements ILayoutModelModify {
    /**
     * Модификация модели из модулей (возможно не будет применяться), а заменится на trait
     */
    public static function modifyModel() {

    }

    /**
     * Получение данных для отображения
     */
    public function getData() {
        return $this->data;
    }
}
