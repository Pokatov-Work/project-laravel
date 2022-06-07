<?php


namespace App\Admin\Http\Sections\pages;

use AdminDisplay;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use \Onessa5\Onessa5Core\Admin\Http\Sections\ISectionExt;

class SCooperationPage implements ISectionExt
{
    const modelName = '\App\Models\pages\CooperationPage';
    const PUBLIC_IMAGES_UPLOAD_PATH = 'img/page';

    public  function getModelClass() {
        return \App\Models\pages\CooperationPage::class;
    }

    public static function modifyModel() {
        return \App\Models\pages\CooperationPage::modifyModel();
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
                    })->mutateValue(function($value) {
                        if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                            $value = '/'.$value;
                        }
                        return $value;
                    }),
            ], 6);
    }

    /**
     * Формирование структуры блока Партнёрская программа
     * @param $lang
     * @return mixed
     */
    public function genFieldsPartners ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->partners->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->partners->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->partners->advantage', 'Заголовок'),
                AdminFormElement::ckeditor('data_value->'.$lang.'->partners->text', 'Преимущества')
            ], 6)
            ->addColumn([
                AdminFormElement::html('<hr><h5>Карточки</h5>'),
            ], 12)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->partners->forCompany->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->partners->forCompany->description', 'Описание'),
                AdminFormElement::image('data_value->'.$lang.'->partners->forCompany->image','Изображение')
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
                AdminFormElement::text('data_value->'.$lang.'->partners->forPartners->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->partners->forPartners->description', 'Описание'),
                AdminFormElement::image('data_value->'.$lang.'->partners->forPartners->image','Изображение')
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
     * Формирование структуры блока Предложение компании
     * @param $lang
     * @return mixed
     */
    public function genFieldsSpecification ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->specification->title', 'Заголовок')
            ], 12)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->specification->titleOffer', 'Заголовок'),
            ], 6)
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::html('<hr><h5>Что мы предлагаем</h5>'),
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->specification->offer', [
                        AdminFormElement::text('text', 'Текст')
                    ])
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->specification->titleAction', 'Заголовок'),
            ], 6)
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::html('<hr><h5>Что делаете вы</h5>'),
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->specification->action', [
                        AdminFormElement::text('text', 'Текст')
                    ])
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6);
    }

    /**
     * Формирование структуры блока Обратная связь
     * @param $lang
     * @return mixed
     */
    public function genFieldsForm ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->form->title', 'Заголовок'),
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->form->subtitle', 'Подзаголовок')
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
             * Вывод таба Партнёрская программа
             */
            $partnersTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsPartners($lang)]);

            /**
             * Вывод таба Предложение компании
             */
            $specificationTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsSpecification($lang)]);

            /**
             * Вывод таба Обратная связь
             */
            $formTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsForm($lang)]);


            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'Header '.$lang => $headerTab,
                    'Партнёрская программа '.$lang => $partnersTab,
                    'Предложение компании '.$lang => $specificationTab,
                    'Обратная связь '.$lang => $formTab,
                ])
            ]);
        }

        return [
            'body' => $contentLang
        ];
    }
}
