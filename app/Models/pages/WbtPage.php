<?php

namespace App\Models\pages;


use App\Models\CryptoPrice;
use App\Models\WbtCryptoGraph;
use App\Models\WbtCryptoList;
use \Onessa5\Onessa5Core\Models\PageData;
use \Onessa5\Onessa5Core\Models\IModelModify;
use \Onessa5\Onessa5Core\Models\Page;
use Illuminate\Support\Facades\Log;
use Onessa5\Onessa5Core\Models\SiteLayout;

/**
 * Class WbtPage
 * Расширение Wbt Page
 * @package App\Models\pages
 */
class WbtPage extends \Onessa5\Onessa5Core\Models\Page implements IModelModify
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
         *Получение списка криптовалют
         */
        $cryptoList = WbtCryptoList::getOnCryptoList('index_value');

        /**
         *Получение значений крипты для графика
         */
        $cryptoGraph = WbtCryptoGraph::getOnCryptoGraph();

        /**
         *Получение котировки крипты
         */
        $cryptoPrice = CryptoPrice::getDataOnCryptoPrice(CryptoPrice::WBTUSD);

        $data->questions->list = json_decode($data->questions->list);
        $data->work->options = json_decode($data->work->options);
        foreach ($data->work->options as $item){
            if ($item->image){
                $item->image = "/" . $item->image;
            }
        }

        $data->cryptoList = $cryptoList;
        $data->cryptoGraph = $cryptoGraph;
        $data->header->info->cols->percent->title = $cryptoPrice->index_value->percentWBT . "USD";
        $data->header->info->cols->price->title = "$" . $cryptoPrice->index_value->wbtusd;


        $socialIcon = SiteLayout::getDataByName("socialFeed");
        $data->social = $socialIcon;


        return $data;
    }
}
