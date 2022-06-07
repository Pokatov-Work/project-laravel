<?php
namespace App\Admin\Http\Sections\pages;

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
use SleepingOwl\Admin\Display\Tree\KalnoyNestedsetType;
//use SleepingOwl\Admin\Display\Tree\OrderTreeType;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;

use \Onessa5\Onessa5Core\Admin\Http\Sections\ISectionExt;

class SNewsPage implements ISectionExt {
    const modelName = '\App\Models\pages\NewsPage';
    const PUBLIC_IMAGES_UPLOAD_PATH = 'img/page';

    public  function getModelClass() {
        return \App\Models\pages\NewsPage::class;
    }

    public static function modifyModel() {
        return \App\Models\pages\NewsPage::modifyModel();
    }

    public function getDisplay($model) {
        return null;
    }

    /**
     * Формирование структуры блока Новости (заголовок)
     * @param $lang
     * @return \SleepingOwl\Admin\Form\Columns\Columns
     * @throws \Exception
     */
    public function getFieldsNewsHeader ($lang) {
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->title', 'Заголовок')->required()
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->header->image','Фотография')
                ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                    return 'img/page'; // public/files
                })->mutateValue(function($value) {
                    if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                        $value = '/'.$value;
                    }
                    return $value;
                }),
            ], 6);
    }


    /**
     * @param Model $model
     * @return mixed|\SleepingOwl\Admin\Form\FormElements[][]
     */
    public function getEdit($model) {

        $langList = config('onessa5.adminLanguages');

        $contentLang =[];
        foreach ($langList as $lang => $langTitle){

           /**
            * Вывод таба Заголовок новостей
            */
            $newsTab = new \SleepingOwl\Admin\Form\FormElements([$this->getFieldsNewsHeader($lang)]);


            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'News '.$lang => $newsTab,
                ])
            ]);
        }


        return [
            'body' => $contentLang
        ];
    }
}
