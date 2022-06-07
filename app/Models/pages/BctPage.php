<?php

namespace App\Models\pages;

use App\Models\CryptoPrice;
use \Onessa5\Onessa5Core\Models\PageData;
use \Onessa5\Onessa5Core\Models\IModelModify;
use \Onessa5\Onessa5Core\Models\Page;
use Illuminate\Support\Facades\Log;
use Onessa5\Onessa5Core\Models\SiteLayout;

/**
 * Class BctPage
 * Расширение Bct Page
 * @package App\Models\pages
 */
class BctPage extends \Onessa5\Onessa5Core\Models\Page implements IModelModify
{
    protected $table ="pages";

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [];

    /**
     * Модификация модели из модулей (возможно не будет применяться), а заменится на trait
     */
    public static function modifyModel() {
//        self::addDynamicRelation('productText', function ($model) {
//            return $model->hasManyJson('\Onessa5\Onessa5Core\Models\PageData', "data->productText", 'ulid');
//        });
    }

    /**
     * Получение данных для отображения страницы
     */
    public function getPageData() {

        self::modifyModel();

        $data = $this->data_value;
        if(empty($data)) {
            $data = new \stdClass();
        }

        $lang = \App::getLocale();

        $data = $data->$lang;

        /**
         *Получение котировки крипты
         */
        $cryptoPrice = CryptoPrice::getDataOnCryptoPrice(CryptoPrice::BCTUSD);

        $data->header->info->cols->percent->title = $cryptoPrice->index_value->dividendforbct . "%";;
        $data->header->info->cols->price->title = "$" . $cryptoPrice->index_value->bctusd;

        $data->questions->list = json_decode($data->questions->list);

        $socialIcon = SiteLayout::getDataByName("socialFeed");
        $data->social = $socialIcon;

        return $data;
    }
}
