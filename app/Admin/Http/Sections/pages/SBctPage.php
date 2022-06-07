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

/**
 * Class SBctPage Настройка админки страницы BCT
 * @package App\Admin\Http\Sections\pages
 */
class SBctPage implements ISectionExt
{
    const modelName = '\App\Models\pages\BctPage';
    const PUBLIC_IMAGES_UPLOAD_PATH = 'img/page';

    public  function getModelClass() {
        return \App\Models\pages\BctPage::class;
    }

    public static function modifyModel() {
        return \App\Models\pages\BctPage::modifyModel();
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
                AdminFormElement::textarea('data_value->'.$lang.'->header->description', 'Подзаголовок'),
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->header->image','Изображение')
                    ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'img/page'; // public/files
                    })
                    ->mutateValue(function($value) {
                        if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                            $value = '/'.$value;
                        }
                        return $value;
                    }),
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->info->title', 'Заголовок стоимости валюты')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->price->text', 'Подпись к стоимости валюты')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->percent->text', 'Подпись к проценту валюты')
            ], 6);
    }

    /**
     * Формирование структуры блока Что такое BCT
     * @param $lang
     * @return mixed
     */
    public function genFieldsWhatBct ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->whatBct->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->whatBct->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->whatBct->advantage', 'Заголовок'),
                AdminFormElement::ckeditor('data_value->'.$lang.'->whatBct->text', 'Преимущества')
            ], 6);
    }

    /**
     * Формирование структуры блока Карточки о BCT
     * @param $lang
     * @return mixed
     */
    public function genFieldsCards ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->cards->leftBlock->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->cards->leftBlock->subtitle', 'Подзаголовок'),
                AdminFormElement::image('data_value->'.$lang.'->cards->leftBlock->image','Изображение')
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
                AdminFormElement::text('data_value->'.$lang.'->cards->rightBlock->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->cards->rightBlock->subtitle', 'Подзаголовок'),
                AdminFormElement::text('data_value->'.$lang.'->cards->rightBlock->url', 'Ссылка'),
                AdminFormElement::image('data_value->'.$lang.'->cards->rightBlock->image','Изображение')
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
     * Формирование структуры блока перспективы и преимущества
     * @param $lang
     * @return mixed
     */
    public function genFieldsProspects ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->prospects->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->prospects->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->prospects->advantage', 'Заголовок'),
                AdminFormElement::ckeditor('data_value->'.$lang.'->prospects->text', 'Преимущества')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->prospects->image','Изображение')
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
     * Формирование структуры блока Вопрос-ответ
     * @param $lang
     * @return mixed
     */
    public function genFieldsQuestion ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->questions->titleBlock->title', 'Заголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::ckeditor('data_value->'.$lang.'->questions->titleBlock->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::html('<hr><h5>Вопрос-ответ</h5>'),
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->questions->list', [
                        AdminFormElement::text('question', 'Вопрос'),
                        AdminFormElement::textarea('response', 'Ответ'),
                    ])
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
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
             * Вывод таба Что такое BCT
             */
            $whatBctTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsWhatBct($lang)]);

            /**
             * Вывод таба Карточки о BCT
             */
            $cardsTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsCards($lang)]);

            /**
             * Вывод таба перспективы и преимущества
             */
            $prospectsTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsProspects($lang)]);

            /**
             * Вывод таба Вопрос-ответ
             */
            $questionTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsQuestion($lang)]);


            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'Header '.$lang => $headerTab,
                    'Что такое BCT '.$lang => $whatBctTab,
                    'Карточки токена '.$lang => $cardsTab,
                    'Перспективы '.$lang => $prospectsTab,
                    'Вопрос-ответ '.$lang => $questionTab,
                ])
            ]);
        }

        return [
            'body' => $contentLang
        ];
    }
}
