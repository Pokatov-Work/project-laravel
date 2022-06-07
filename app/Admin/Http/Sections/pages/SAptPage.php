<?php


namespace App\Admin\Http\Sections\pages;

use AdminDisplay;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use \Onessa5\Onessa5Core\Admin\Http\Sections\ISectionExt;


class SAptPage implements ISectionExt
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
            ], 6);
    }

    /**
     * Формирование структуры блока Что такое APT
     * @param $lang
     * @return mixed
     */
    public function genFieldsWhatApt ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->whatApt->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->whatApt->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->whatApt->advantage', 'Заголовок'),
                AdminFormElement::ckeditor('data_value->'.$lang.'->whatApt->text', 'Преимущества')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->whatApt->video->id', 'id на видео'),
                AdminFormElement::image('data_value->'.$lang.'->whatApt->video->poster','Постер к видео')
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
                AdminFormElement::text('data_value->'.$lang.'->whatApt->target->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->whatApt->target->description', 'Описание'),
                AdminFormElement::image('data_value->'.$lang.'->whatApt->target->image','Изображение')
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
                AdminFormElement::text('data_value->'.$lang.'->whatApt->task->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->whatApt->task->description', 'Описание'),
                AdminFormElement::image('data_value->'.$lang.'->whatApt->task->image','Изображение')
                    ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'img/page'; // public/files
                    })
                    ->mutateValue(function($value) {
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
                    }),
            ], 6);
    }

    /**
     * Формирование структуры блока Возможности APT
     * @param $lang
     * @return mixed
     */
    public function genFieldsMultiply ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->multiply->title', 'Заголовок'),
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->multiply->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->multiply->image','Изображение')
                    ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'img/page'; // public/files
                    })
                    ->mutateValue(function($value) {
                        if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                            $value = '/'.$value;
                        }
                        return $value;
                    }),
            ], 6);
    }

    /**
     * Формирование структуры блока как работает APT
     * @param $lang
     * @return mixed
     */
    public function genFieldsWorking ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->working->title', 'Заголовок'),
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->working->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->working->url', 'Ссылка')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->working->image','Изображение')
                    ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'img/page'; // public/files
                    })
                    ->mutateValue(function($value) {
                        if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                            $value = '/'.$value;
                        }
                        return $value;
                    }),
            ], 6);
    }

    /**
     * Формирование структуры блока Гарантии
     * @param $lang
     * @return mixed
     */
    public function genFieldsGuarantee ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->guarantee->title', 'Заголовок'),
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->guarantee->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->guarantee->image','Изображение')
                    ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'img/page'; // public/files
                    })
                    ->mutateValue(function($value) {
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
             * Вывод таба Что такое APT
             */
            $whatBctTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsWhatApt($lang)]);

            /**
             * Вывод таба Возможности APT
             */
            $multiplyTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsMultiply($lang)]);

            /**
             * Вывод таба как работает APT
             */
            $workingTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsWorking($lang)]);

            /**
             * Вывод таба Гарантии
             */
            $guaranteeTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsGuarantee($lang)]);

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
                    'Что такое APT '.$lang => $whatBctTab,
                    'Перспективы '.$lang => $prospectsTab,
                    'Возможности APT '.$lang => $multiplyTab,
                    'Как работает APT '.$lang => $workingTab,
                    'Гарантии '.$lang => $guaranteeTab,
                    'Вопрос-ответ '.$lang => $questionTab,
                ])
            ]);
        }

        return [
            'body' => $contentLang
        ];
    }
}
