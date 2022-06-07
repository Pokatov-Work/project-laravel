<?php

namespace App\Admin\Http\Sections\pages;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use Exception;
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

class SWbtPage implements ISectionExt
{
    const modelName = '\App\Models\pages\WbtPage';

    const PUBLIC_IMAGES_UPLOAD_PATH = 'img/page';

    public  function getModelClass() {
        return \App\Models\pages\WbtPage::class;
    }

    public static function modifyModel() {
        return \App\Models\pages\WbtPage::modifyModel();
    }

    public function getDisplay($model) {
        return null;
    }

    /**
     * Формирование структуры header блока
     * @param $lang
     * @return \SleepingOwl\Admin\Form\Columns\Columns
     * @throws Exception
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
     * Формирование структуры блока с графиком
     * @param $lang
     * @return mixed
     */
    public function genFieldsSchedule ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->schedule->title', 'Заголовок')
            ], 6);
    }

    /**
     * Формирование структуры блока Что такое WBT
     * @param $lang
     * @return mixed
     */
    public function genFieldsWhatWbt ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->whatWbt->title', 'Заголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->whatWbt->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->whatWbt->text', 'Описание')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->whatWbt->video->id', 'id на видео'),
                AdminFormElement::image('data_value->'.$lang.'->whatWbt->video->poster','Постер к видео')
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
     * Формирование структуры блока Состав индекса
     * @param $lang
     * @return mixed
     */
    public function genFieldsComposition ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->composition->title', 'Заголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->composition->subtitle', 'Подзаголовок')
            ], 6);
    }

    /**
     * Формирование структуры блока Описание работы индекса
     * @param $lang
     * @return mixed
     */
    public function genFieldsWork ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::html('<hr><h5>Описание работы индекса</h5>'),
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->work->options', [
                        AdminFormElement::text('title', 'Заголовок'),
                        AdminFormElement::textarea('subtitle', 'Подзаголовок'),
                        AdminFormElement::image('image','Избражение')
                            ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                                return 'img/page'; // public/files
                            })->mutateValue(function($value) {
                                if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                                    $value = '/'.$value;
                                }
                                return $value;
                            }),
                    ])
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6);
    }

    /**
     * Формирование структуры блока Формула индекса
     * @param $lang
     * @return mixed
     */
    public function genFieldsPayment ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->payment->title', 'Заголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->payment->formula->price', 'Получаемое значение'),
                AdminFormElement::text('data_value->'.$lang.'->payment->formula->topValue', 'Верхнее значение'),
                AdminFormElement::text('data_value->'.$lang.'->payment->formula->bottomValue', 'Нижнее значение'),
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->payment->text', 'Описание')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->payment->url', 'Ссылка')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->payment->image','Изображение')
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
     * Формирование структуры блока Описание индксного токена
     * @param $lang
     * @return mixed
     */
    public function genFieldsAdvantage ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->advantage->title', 'Заголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->advantage->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->advantage->image','Изображение')
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
             * Вывод таба График
             */
            $scheduleTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsSchedule($lang)]);

            /**
             * Вывод таба Что такое Wbt
             */
            $whatWbtTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsWhatWbt($lang)]);

            /**
             * Вывод таба Состав индекса
             */
            $compositionTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsComposition($lang)]);

            /**
             * Вывод таба Описание работы индекса
             */
            $workTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsWork($lang)]);

            /**
             * Вывод таба Формула индекса
             */
            $paymentTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsPayment($lang)]);

            /**
             * Вывод таба Описание индксного токена
             */
            $advantageTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsAdvantage($lang)]);

            /**
             * Вывод таба Вопрос-ответ
             */
            $questionTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsQuestion($lang)]);


            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'Header '.$lang => $headerTab,
                    'График '.$lang => $scheduleTab,
                    'Что такое WBT '.$lang => $whatWbtTab,
                    'Состав индекса '.$lang => $compositionTab,
                    'Описание работы индекса '.$lang => $workTab,
                    'Формула индекса '.$lang => $paymentTab,
                    'Описание индксного токена '.$lang => $advantageTab,
                    'Вопрос-ответ '.$lang => $questionTab,
                ])
            ]);
        }

        return [
            'body' => $contentLang
        ];
    }
}
