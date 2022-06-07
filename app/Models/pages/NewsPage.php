<?php

namespace App\Models\pages;

use App\Models\layouts\LayoutSocialIcon;
use App\Models\news\News;

use \Onessa5\Onessa5Core\Models\PageData;
use \Onessa5\Onessa5Core\Models\IModelModify;
use \Onessa5\Onessa5Core\Models\Page;
use Illuminate\Support\Facades\Log;
use Onessa5\Onessa5Core\Models\SiteLayout;

/**
 * Class NewsPage
 * Расширение News Page
 * @package App\Models\pages
 */
class NewsPage extends \Onessa5\Onessa5Core\Models\Page implements IModelModify {

    const PAGE_SLUG = 'news';

    protected $table ="pages";

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * Модификация модели из модулей (возможно не будет применяться), а заменится на trait
     */
    public static function modifyModel() {

    }

    /**
     * Получение данных для отображения страницы
     */
    public function getPageData() {
        $requestPage = !empty($_GET['p']) ? intval($_GET['p']) : 0;
	    self::modifyModel();

        $data = $this->data_value;

        if(empty($data)) {
            $data = new \stdClass();
        }

        $lang = \App::getLocale();

        $content = $data->$lang->header;
        $content->meta = $data->$lang->meta;

        $content->header['title'] = $content->title;
        $content->header['image'] = $content->image;

        // получаем новости
        $options = [
            "where" => [
                ['is_active', 1],
                ['lang', $lang]
            ]
        ];
        $arNews = News::getAll('*', $options);

        $content->news['currentPage'] = $arNews->currentPage();
        $content->news['totalPages'] = $arNews->lastPage();

        foreach ($arNews as $newsKey => $newsValue) {

            $content->news['list'][] = [
                'news_date' => $newsValue->news_date,
                'slug' => $newsValue->slug,
                'data' => $newsValue->data,
            ];
        }

        $socialIcon = SiteLayout::getByName("socialFeed");
        $content->social = $socialIcon->data;

        return $content;
    }
}
