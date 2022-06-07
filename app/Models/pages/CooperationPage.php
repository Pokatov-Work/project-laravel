<?php


namespace App\Models\pages;

use App\Models\options\Language;
use App\Models\options\Region;
use \Onessa5\Onessa5Core\Models\PageData;
use \Onessa5\Onessa5Core\Models\IModelModify;
use \Onessa5\Onessa5Core\Models\Page;
use Illuminate\Support\Facades\Log;
use Onessa5\Onessa5Core\Models\SiteLayout;

class CooperationPage extends \Onessa5\Onessa5Core\Models\Page implements IModelModify
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

        $data->specification->offer = json_decode($data->specification->offer);
        $data->specification->action = json_decode($data->specification->action);

        $socialIcon = SiteLayout::getDataByName("socialFeed");
        $data->social = $socialIcon;

        //Получение регионов для формы
        $langList = Language::getLanguage(['code', $lang]);
        $lang=[];
        foreach ($langList as $itemLang){
            $lang = $itemLang['ulid'];
        }

        $options = [['is_active', 1], ['lang', $lang]];
        $regionObj = Region::getRegion('*', $options);
        foreach ($regionObj as $region){
            $data->form->regionName = $region->name;
            $data->form->list = json_decode($region->data->main);
        }

        return $data;
    }
}
