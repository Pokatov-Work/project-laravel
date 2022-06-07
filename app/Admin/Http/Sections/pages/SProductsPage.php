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
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;
use \Onessa5\Onessa5Core\Admin\Http\Sections\ISectionExt;

class SProductsPage implements ISectionExt
{
    const modelName = '\App\Models\pages\ProductsPage';
    const PUBLIC_IMAGES_UPLOAD_PATH = 'img/page';

    public  function getModelClass() {
        return \App\Models\pages\ProductsPage::class;
    }

    public static function modifyModel() {
        return \App\Models\pages\ProductsPage::modifyModel();
    }

    public function getDisplay($model) {
        return null;
    }

    /**
     * Формирование структуры header блока
     * @param $lang
     * @return mixed
     */
    public function genFieldsHeader ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->title', 'Заголовок')->required()
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->description', 'Подзаголовок'),
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->header->image','Фоновое изображение')
                    ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'img/page'; // public/files
                    })->mutateValue(function($value) {
                        if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                            $value = '/'.$value;
                        }
                        return $value;
                    }),
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->url', 'Ссылка')
            ], 6);
    }

    /**
     * Формирование структуры Продукты
     * @param $lang
     * @param $productCode
     * @return mixed
     */
    public function genFieldsProducts ($productCode, $lang){
        return
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->anchor', 'Название блока'),
                ], 6)
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->title', 'Название продукта'),
                ], 6)
                ->addColumn([
                    AdminFormElement::textarea('data_value->'.$lang.'->products->'. $productCode .'->description', 'Описание продукта'),
                ], 6)
                ->addColumn([
                    AdminFormElement::textarea('data_value->'.$lang.'->products->'. $productCode .'->subtitle', 'Состав продукта'),
                ], 6)
                ->addColumn([
                    AdminFormElement::textarea('data_value->'.$lang.'->products->'. $productCode .'->text', 'Текст о продукте'),
                ], 6)
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->url', 'Ссылка')
                ], 6);
    }

    /**
     * @param Model $model
     * @return mixed|\SleepingOwl\Admin\Form\FormElements[][]
     */
    public function getEdit($model)
    {
        $langList = config('onessa5.adminLanguages');

        $contentLang =[];
        foreach ($langList as $lang => $langTitle){

            /**
             * Вывод таба Header
             */
            $headerTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsHeader($lang)]);

            /**
             * Вывод таба Продукты
             */
            $tabList = [];

            $tabList['wbt'] = $this->genFieldsProducts('wbt', $lang);
            $tabList['bct'] = $this->genFieldsProducts('bct', $lang);
            $tabList['apt'] = $this->genFieldsProducts('apt', $lang);

            $productsTab = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'WBT '.$lang => new \SleepingOwl\Admin\Form\FormElements([$tabList['wbt']]),
                    'BCT '.$lang => new \SleepingOwl\Admin\Form\FormElements([$tabList['bct']]),
                    'APT '.$lang => new \SleepingOwl\Admin\Form\FormElements([$tabList['apt']])
                ])
            ]);


            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'Header '.$lang => $headerTab,
                    'Продукты '.$lang => $productsTab
                ])
            ]);
        }

        return [
            'body' => $contentLang
        ];
    }
}
