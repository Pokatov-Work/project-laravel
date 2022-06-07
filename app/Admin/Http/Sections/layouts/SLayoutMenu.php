<?php


namespace App\Admin\Http\Sections\layouts;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

use \Onessa5\Onessa5Core\Admin\Http\Sections\ISectionExt;

class SLayoutMenu implements ISectionExt
{
    public  function getModelClass() {
        return \App\Models\layouts\LayoutMenu::class;
    }

    public static function modifyModel() {
        return \App\Models\layouts\LayoutMenu::modifyModel();
    }

    public function getDisplay($model) {
        return null;
    }

    /**
     * Формирование структуры меню
     * @param $lang
     * @return mixed
     */
    public function getFieldsMenu ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::html('<h5>Пункты меню</h5><hr>'),
                    AdminFormElement::hasManyLocal('data->'.$lang.'->menu', [
                        AdminFormElement::text('title', 'Пункт меню'),
                        AdminFormElement::text('url', 'Ссылка на страницу'),
                    ])
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6);
    }

    /**
     * @param Model $model
     * @return mixed|\SleepingOwl\Admin\Form\FormElements[][]
     */
    public function getEdit($model) {

        $langList = config('onessa5.adminLanguages');

        $contentLang =[];
        foreach ($langList as $lang => $langTitle) {

            $menuTab = new \SleepingOwl\Admin\Form\FormElements([$this->getFieldsMenu($lang)]);

            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([$menuTab]);
        }

        return $contentLang;
    }
}
