<?php

namespace App\Models\pages;

use App\Models\news\News;
use App\Models\WbtCryptoList;
use \Onessa5\Onessa5Core\Models\PageData;
use \Onessa5\Onessa5Core\Models\IModelModify;
use \Onessa5\Onessa5Core\Models\Page;
use Illuminate\Support\Facades\Log;
use Onessa5\Onessa5Core\Models\SiteLayout;

/**
 * Class indexPage
 * Расширение index Page
 * @package App\Models\pages
 */
class IndexPage extends \Onessa5\Onessa5Core\Models\Page implements IModelModify {

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
//        self::addDynamicRelation('advantage_options', function ($model) {
//            return $model->hasManyJson('\Onessa5\Onessa5Core\Models\Page', "data_value->advantage_options", 'ulid');
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

        $data->products->apt->options = json_decode($data->products->apt->options);
        $data->products->apt->income = json_decode($data->products->apt->income);
        $data->products->wbt->options = json_decode($data->products->wbt->options);
        $data->products->wbt->income = json_decode($data->products->wbt->income);
        $data->products->bct->options = json_decode($data->products->bct->options);
        $data->products->bct->income = json_decode($data->products->bct->income);
        $data->cooperation->advantages = json_decode($data->cooperation->advantages);

        // получаем новости
        $options = [['is_active', 1], ['lang', $lang]];
        $arNews = News::getListAnounNews('*', $options, 3);
        $newsList = [];
        foreach ($arNews as $newsKey => $newsValue) {

            $newsList[] = [
                'news_date' => $newsValue->news_date,
                'slug' => $newsValue->slug,
                'data' => $newsValue->data,
            ];
        }
        $data->news_block->news = $newsList;

        //получаем соц сети
        $socialIcon = SiteLayout::getDataByName("socialFeed");
        $data->social = $socialIcon;

        return $data;
    }
}
