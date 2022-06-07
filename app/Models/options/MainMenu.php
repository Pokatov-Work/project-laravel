<?php


namespace App\Models\options;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Onessa5\Onessa5Core\Models\BaseModel;
use Onessa5\Onessa5Core\Models\SiteLayout;

class MainMenu extends BaseModel
{

    use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
    use \Onessa5\Onessa5Core\Models\Traits\HasDynamicRelation;

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * Список преобразований
     * @var string[]
     */
    protected $casts = [
        'data' => 'object',
        'data_config' => 'object',
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
     * Функция получения и формирования мультиязычного меню
     * @param array $options
     * @param bool $treeCheck
     * @return mixed
     */
    public static function getMenu($options = [], $treeCheck = true)
    {
        $lang = \App::getLocale();
        $menuLists = self::select('*')
            ->get();

        if ($treeCheck) {
            foreach ($menuLists as $menuObj) {
                if ($menuObj->parent_id != 0) {
                    $children[] = [
                        'id' => $menuObj->id,
                        'ulid' => $menuObj->ulid,
                        'title' => $menuObj->data->$lang->menu->title,
                        'url' => $menuObj->data->$lang->menu->url,
                        'parent_id' => $menuObj->parent_id,
                    ];
                } else {
                    $parent[] = [
                        'id' => $menuObj->id,
                        'ulid' => $menuObj->ulid,
                        'title' => $menuObj->data->$lang->menu->title,
                        'url' => $menuObj->data->$lang->menu->url,
                        'parent_id' => $menuObj->parent_id,
                    ];
                }
            }

            foreach ($parent as $key => $itemParent) {
                foreach ($children as $cild) {
                    if ($itemParent['id'] == $cild['parent_id']) {
                        $itemParent['child'][] = $cild;
                    }
                }
                $treeList[] = $itemParent;
            }

            return $treeList;
        }else{
            return $menuLists;
        }
    }

}
