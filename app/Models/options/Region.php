<?php


namespace App\Models\options;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Onessa5\Onessa5Core\Models\BaseModel;
use Onessa5\Onessa5Core\Models\SiteLayout;

class Region extends BaseModel
{
    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use \Onessa5\Onessa5Core\Models\Traits\HasDynamicRelation;

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'data',
        'lang',
        'form',
        'model',
        'view',
        'convertor',
        'data_config'
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
        $pageView = $this->view;
        $pageModel = $this->model;

        return [
            'model' => $pageModel,
            'view' => $pageView,
            'form' => (string)$this->form,
            'convertor' => (string)$this->convertor,
        ];
    }

    /**
     * Модификация модели из модулей (возможно не будет применяться), а заменится на trait
     */
    public static function modifyModel()
    {

    }

    /**
     * Получение данных для отображения страницы
     */
    public function getPageData() {
        $data = $this->data;

        return $data;
    }

    /**
     * Функция для получения регионов
     * @param string[] $fields
     * @param array $options
     * @return mixed
     */
    public static function getRegion ($fields = ['*'], $options = []){
        $query = self::select($fields)
            ->where($options)
            ->get();
        return $query;
    }
}
