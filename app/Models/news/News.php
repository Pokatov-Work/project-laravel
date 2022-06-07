<?php

namespace App\Models\news;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Support\Facades\Log;
use Kalnoy\Nestedset\NodeTrait;
use \Onessa5\Onessa5Core\Models\BaseModel;
use Onessa5\Onessa5Core\Models\SiteLayout;

class News extends BaseModel
{

    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use \Onessa5\Onessa5Core\Models\Traits\HasDynamicRelation;

    /**
     * Default View (если не задано) для отображения только контента
     */
    const SIMPLE_VIEW = 'pages.news.detail';

    /**
     * Default Model (если не задано) для отображения только контента
     */
    const SIMPLE_MODEL = '\App\Models\news\News';

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'news_date',
        'data',
        'lang',
        'form',
        'model',
        'view',
        'convertor',

        'data_config',
    ];

    /**
     * Значения по умолчанию для атрибутов модели.
     *
     * @var array
     */
    protected $attributes = [

    ];
    /**
     * Список преобразований
     * @var string[]
     */
    protected $casts = [
        'data' => 'object',
    ];


    /**
     * Получение конфигурации страницы (model,view,form, convertor)
     * @return string[]
     */
    public function getObjectConfig() {
        $pageView = (!empty($this->view)) ? $this->view : self::SIMPLE_VIEW;
        $pageModel = (!empty($this->model)) ? $this->model : self::SIMPLE_MODEL;

        return [
            'model' => $pageModel,
            'view' => $pageView,
            'form' => (string)$this->form,
            'convertor' => (string)$this->convertor,
        ];
    }

    /**
     * Получение данных для отображения страницы
     */
    public function getPageData() {

        $data = $this->data;

        $socialIcon = SiteLayout::getDataByName("socialFeed");
        $data->social = $socialIcon;

        return $data;
    }

    /**
     * Получить query для выборки всех новостей
     * @param string[] $fields - столбцы выборки
     * @param array $options - условия выборки where, вида [['is_active', 1], [...]]
     * @return mixed
     */
    public static function getAll($fields = ['*'], $options = []) {

        $res = self::select($fields)
            ->orderBy('news_date', 'desc')
            ->where($options['where'])
            ->paginate(9);

        return $res;
    }

    /**
     * Получить список новостей в нужном колличестве и по условиям $options
     * @param string[] $fields
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public static function getListAnounNews($fields = ['*'], $options = [], $limit = 9) {

        return self::select($fields)
            ->orderBy('news_date', 'desc')
            ->where($options)
            ->limit($limit)
            ->get();
    }
}
