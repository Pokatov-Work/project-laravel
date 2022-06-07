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

class SIndexPage implements ISectionExt
{
    const modelName = '\App\Models\pages\IndexPage'; // может через класс получать?
    const PUBLIC_IMAGES_UPLOAD_PATH = 'img/page';

    public  function getModelClass() {
        return \App\Models\pages\IndexPage::class;
    }

    public static function modifyModel() {
        return \App\Models\pages\IndexPage::modifyModel();
    }

    public function getDisplay($model) {
        return null;
    }

    /**
     * Формирование структуры header блока
     * @param $lang
     * @return mixed
     */
    public function getFieldsHeader ($lang){
        return AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->header->title', 'Заголовок')->required()
                ], 6)
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->header->subtitle', 'Подзаголовок'),
                ], 6)
                ->addColumn([
                    AdminFormElement::image('data_value->'.$lang.'->header->image','Фотография')
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
                    AdminFormElement::text('data_value->'.$lang.'->header->title_url', 'Название ссылки'),
                    AdminFormElement::file('data_value->'.$lang.'->header->file','Файл')
                        ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                            return 'files';
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
     * Формирование структуры блока Продукты компании
     * @param $lang
     * @param $productCode
     * @return mixed
     */
    public function getFieldsProducts ($productCode, $lang){
        return
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->text_block->title', 'Наши продукты'),
                ], 6)
                ->addColumn([
                    AdminFormElement::textarea('data_value->'.$lang.'->products->'. $productCode .'->text_block->description', 'Вводный текст'),
                ], 6)
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->text_block->quote', 'Цитата'),
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->text_block->author_quote', 'Автор цитаты'),
                    AdminFormElement::textarea('data_value->'.$lang.'->products->'. $productCode .'->text_block->text', 'Текст'),
                ], 6)
                ->addColumn([
                    AdminFormElement::html('<hr>')
                ], 12)
                ->addColumn([
                    AdminFormElement::file('data_value->'.$lang.'->products->'. $productCode .'->info->icon','Иконка')
                        ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                            return 'img/page'; //'img/page'; // public/files
                        })

                        ->mutateValue(function($value) {
                            if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                                $value = '/'.$value;
                            }
                            return $value;
                        }),
                ], 6)
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->info->title', 'Наименование продукта')
                ], 6)
                ->addColumn([
                    AdminFormElement::textarea('data_value->'.$lang.'->products->'. $productCode .'->info->description', 'Краткое описание продукта')
                ], 6)
                ->addColumn([
                    AdminFormElement::text('data_value->'.$lang.'->products->'. $productCode .'->info->url', 'Ссылка')
                ], 6)
                ->addColumn([
                    AdminFormElement::html('<hr>')
                ], 12)
                ->addColumn([
                    new \SleepingOwl\Admin\Form\FormElements([
                        AdminFormElement::html('<hr><h5>Опции</h5>'),
                        AdminFormElement::hasManyLocal('data_value->'.$lang.'->products->'. $productCode .'->options', [
                            AdminFormElement::text('title', 'Заголовок'),
                            AdminFormElement::text('subtitle', 'Подзаголовок'),
                        ])
                            ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                    ])
                ], 6)
                ->addColumn([
                    new \SleepingOwl\Admin\Form\FormElements([
                        AdminFormElement::html('<hr><h5>Доходность</h5>'),
                        AdminFormElement::hasManyLocal('data_value->'.$lang.'->products->'. $productCode .'->income', [
                            AdminFormElement::text('title', 'Заголовок'),
                            AdminFormElement::text('subtitle', 'Подзаголовок'),
                        ])
                            ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                    ])
                ], 6);
    }

    /**
     * Формирование структуры блока Миссия компании
     * @param $lang
     * @param $langTitle
     * @return mixed
     */
    public function getFieldsAbout ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->about->title', 'Заголовок'),
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->about->description', 'Миссия компании'),
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->about->text', 'Дополнительный текст'),
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->about->url', 'Ссылка'),
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->about->image','Фотография')
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
                AdminFormElement::text('data_value->'.$lang.'->about->name', 'ФИО'),
                AdminFormElement::text('data_value->'.$lang.'->about->position', 'Должность'),
            ], 6);
    }

    /**
     * Формирование структуры блока Сотрудничество
     * @param $lang
     * @return mixed
     */
    public function getFieldsCooperation ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->cooperation->title', 'Заголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->cooperation->subtitle', 'Подзаголовок'),
            ], 6)
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::html('<hr><h5>Преимущества</h5>'),
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->cooperation->advantages', [
                        AdminFormElement::text('title', 'Заголовок'),
                        AdminFormElement::textarea('text', 'Подзаголовок'),
                    ])
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6);
    }

    /**
     * Формирование структуры блока Новости
     * @param $lang
     * @return mixed
     */
    public function getFieldsNews ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->news_block->title', 'Заголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->news_block->subtitle', 'Подзаголовок'),
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
            $headerTab = new \SleepingOwl\Admin\Form\FormElements([$this->getFieldsHeader($lang)]);

            /**
             * Вывод таба Продукты
             */
            $tabList = [];

            $tabList['wbt'] = $this->getFieldsProducts('wbt', $lang);
            $tabList['bct'] = $this->getFieldsProducts('bct', $lang);
            $tabList['apt'] = $this->getFieldsProducts('apt', $lang);

            $productsTab = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'WBT '.$lang => new \SleepingOwl\Admin\Form\FormElements([$tabList['wbt']]),
                    'BCT '.$lang => new \SleepingOwl\Admin\Form\FormElements([$tabList['bct']]),
                    'APT '.$lang => new \SleepingOwl\Admin\Form\FormElements([$tabList['apt']])
                ])
            ]);

            /**
             * Вывод таба О компании
             */
            $aboutTab = new \SleepingOwl\Admin\Form\FormElements([$this->getFieldsAbout($lang)]);

            /**
             * Вывод таба Сотрудничество
             */
            $cooperationTab = new \SleepingOwl\Admin\Form\FormElements([$this->getFieldsCooperation($lang)]);

            /**
             * Вывод таба Новости
             */
            $newsTab = new \SleepingOwl\Admin\Form\FormElements([$this->getFieldsNews($lang)]);

            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'Header '.$lang => $headerTab,
                    'Продукты '.$lang => $productsTab,
                    'Наша миссия '.$lang => $aboutTab,
                    'Сотрудничество '.$lang =>$cooperationTab,
                    'Новости '.$lang => $newsTab,
                    ])
            ]);
        }

        return [
            'body' => $contentLang
        ];
    }
}
