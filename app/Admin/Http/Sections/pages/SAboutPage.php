<?php


namespace App\Admin\Http\Sections\pages;

use AdminDisplay;
use AdminFormElement;
use Illuminate\Database\Eloquent\Model;
use \Onessa5\Onessa5Core\Admin\Http\Sections\ISectionExt;

class SAboutPage implements ISectionExt
{
    const modelName = '\App\Models\pages\AboutPage';
    const PUBLIC_IMAGES_UPLOAD_PATH = 'img/page';
    const PUBLIC_IMAGES_UPLOAD_FILE_PATH = 'files';

    public $sectionInstance;

    public function __construct($sectionInstance) {
        $this->sectionInstance = $sectionInstance;
    }

    public  function getModelClass() {
        return \App\Models\pages\AboutPage::class;
    }

    public static function modifyModel() {
        return \App\Models\pages\AboutPage::modifyModel();
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
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->0->title', 'Цифры'),
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->0->text', 'Подпись'),
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->1->title', 'Цифры'),
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->1->text', 'Подпись'),
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->2->title', 'Цифры'),
                AdminFormElement::text('data_value->'.$lang.'->header->info->cols->2->text', 'Подпись'),
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
                AdminFormElement::file('data_value->'.$lang.'->header->video', 'Видео')
                    ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                        return 'img/page'; // public/files
                    })
            ], 6);
    }

    /**
     * Формирование структуры блока О компании
     * @param $lang
     * @return mixed
     */
    public function genFieldsAbout ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->about->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->about->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->'.$lang.'->about->text', 'Преимущества')
            ], 6)
            ->addColumn([
                AdminFormElement::html('<hr><h5>Карточки</h5>'),
            ], 12)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->about->task->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->about->task->description', 'Описание'),
                AdminFormElement::image('data_value->'.$lang.'->about->task->image','Изображение')
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
                AdminFormElement::text('data_value->'.$lang.'->about->relationships->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->'.$lang.'->about->relationships->description', 'Описание'),
                AdminFormElement::image('data_value->'.$lang.'->about->relationships->image','Изображение')
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
     * Формирование структуры блок История компании
     * @param $lang
     * @return mixed
     */
    public function genFieldsHistory ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->' . $lang . '->history->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->' . $lang . '->history->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->' . $lang . '->history->leftText', 'Текстовое поле')
            ], 6)
            ->addColumn([
                AdminFormElement::textarea('data_value->' . $lang . '->history->rightText', 'Текстовое поле'),
            ], 6)
            ->addColumn([
                AdminFormElement::html('<hr><h5>Основатели</h5>'),
            ], 12)
            ->addColumn([
                AdminFormElement::text('data_value->' . $lang . '->history->left->fio', 'ФИО'),
                AdminFormElement::text('data_value->' . $lang . '->history->left->position', 'Должность'),
                AdminFormElement::image('data_value->' . $lang . '->history->left->image', 'Изображение')
                    ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
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
                AdminFormElement::text('data_value->' . $lang . '->history->right->fio', 'ФИО'),
                AdminFormElement::text('data_value->' . $lang . '->history->right->position', 'Должность'),
                AdminFormElement::image('data_value->' . $lang . '->history->right->image', 'Изображение')
                    ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
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
     * Формирование структуры блок Миссия компании
     * @param $lang
     * @return mixed
     */
    public function genFieldsMission ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->' . $lang . '->mission->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->' . $lang . '->mission->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->' . $lang . '->mission->image', 'Изображение')
                    ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
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
     * Формирование структуры блок Философия компании
     * @param $lang
     * @return mixed
     */
    public function genFieldsPhilosophy ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->' . $lang . '->philosophy->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->' . $lang . '->philosophy->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->' . $lang . '->philosophy->image', 'Изображение')
                    ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
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
     * Формирование структуры блок Карточки видение и стратегия компании
     * @param $lang
     * @return mixed
     */
    public function genFieldsVisionStrategy ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::html('<hr><h5>Наше видение</h5>'),
                AdminFormElement::text('data_value->' . $lang . '->vision->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->' . $lang . '->vision->subtitle', 'Подзаголовок'),
                AdminFormElement::image('data_value->' . $lang . '->vision->image', 'Изображение')
                    ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
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
                AdminFormElement::html('<hr><h5>Наша стратегия</h5>'),
                AdminFormElement::text('data_value->' . $lang . '->strategy->title', 'Заголовок'),
                AdminFormElement::textarea('data_value->' . $lang . '->strategy->subtitle', 'Подзаголовок'),
                AdminFormElement::image('data_value->' . $lang . '->strategy->image', 'Изображение')
                    ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
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
     * Формирование структуры блок Видео слайдер
     * @param $lang
     * @return mixed
     */
    public function genFieldsVideo ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->' . $lang . '->video->title', 'Заголовок'),
            ], 6)
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::html('<hr><h5>Ссылка на видео</h5>'),
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->video->list', [
                        AdminFormElement::text('ids', 'id на видео'),
                        AdminFormElement::image('poster','Постер к видео')
                            ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                                return 'img/page'; // public/files
                            })
                            ->mutateValue(function($value) {
                                if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                                    $value = '/'.$value;
                                }
                                return $value;
                            }),
                    ])
                        ->setInstance($this->sectionInstance->getModelValue())
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6);
    }

    /**
     * Формирование структуры блок Дорожная карта
     * @param $lang
     * @return mixed
     */
    public function genFieldsMap ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->' . $lang . '->map->title', 'Заголовок'),
            ], 6)
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->map->list', [
                        AdminFormElement::file('image', 'Изображение')
                            ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
                                return 'img/page'; // public/files
                            })
                            ->mutateValue(function($value) {
                                if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                                    $value = '/'.$value;
                                }
                                return $value;
                            }),
                        AdminFormElement::text('title', 'Заголовок'),
                        AdminFormElement::textarea('text', 'Текст'),
                    ])
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6);
    }

    /**
     * Формирование структуры блока Анализ проекта
     * @param $lang
     * @return mixed
     */
    public function genFieldsAnalysis ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->analysis->title', 'Заголовок'),
                AdminFormElement::text('data_value->'.$lang.'->analysis->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::image('data_value->'.$lang.'->analysis->logoImage','Логотип')
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
                AdminFormElement::text('data_value->'.$lang.'->analysis->result->title', 'Заголовок'),
                AdminFormElement::text('data_value->'.$lang.'->analysis->result->subtitle', 'Подзаголовок'),
                AdminFormElement::ckeditor('data_value->'.$lang.'->analysis->result->text', 'Список'),
                AdminFormElement::file('data_value->'.$lang.'->analysis->result->file','Файл анализа')
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
     * Формирование структуры блока Наши партнёры
     * @param $lang
     * @return mixed
     */
    public function genFieldsPartners ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->partners->title', 'Заголовок')
            ], 6)
            ->addColumn([
                new \SleepingOwl\Admin\Form\FormElements([
                    AdminFormElement::hasManyLocal('data_value->'.$lang.'->partners->list', [
                        AdminFormElement::image('image', 'Логотип')
                            ->setUploadPath(function (\Illuminate\Http\UploadedFile $file) {
                                return 'img/page'; // public/files
                            })
                            ->mutateValue(function($value) {
                                if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_PATH)) {
                                    $value = '/'.$value;
                                }
                                return $value;
                            }),
                        AdminFormElement::text('title', 'Название партнёра'),
                        AdminFormElement::textarea('text', 'Описание'),
                        AdminFormElement::text('url', 'Ссылка на сайт'),
                    ])
                        ->setInstance($this->sectionInstance->getModelValue())
                        ->setJsonOptions(JSON_UNESCAPED_UNICODE )
                ])
            ], 6);
    }

    /**
     * Формирование структуры блока Связаться с нами
     * @param $lang
     * @return mixed
     */
    public function genFieldsContactForm ($lang){
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->contactForm->title', 'Заголовок'),
                AdminFormElement::text('data_value->'.$lang.'->contactForm->subtitle', 'Подзаголовок')
            ], 6)
            ->addColumn([
                AdminFormElement::text('data_value->'.$lang.'->contactForm->address', 'Адрес'),
            ], 6)
            ->addColumn([AdminFormElement::file('data_value->'.$lang.'->contactForm->politic','Политика конфиденциальности')
                ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                    return 'files';
                })
                ->mutateValue(function($value) {
                    if(str_starts_with($value, self::PUBLIC_IMAGES_UPLOAD_FILE_PATH)) {
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
             * Вывод таба О компании
             */
            $aboutTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsAbout($lang)]);

            /**
             * Вывод таба История компании
             */
            $historyTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsHistory($lang)]);

            /**
             * Вывод таба Миссия компании
             */
            $missionTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsMission($lang)]);

            /**
             * Вывод таба Философия компании
             */
            $philosophyTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsPhilosophy($lang)]);

            /**
             * Вывод таба Карточки видение и стратегия компании
             */
            $strategyTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsVisionStrategy($lang)]);

            /**
             * Вывод таба Слайдер видео
             */
            $videoTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsVideo($lang)]);

            /**
             * Вывод таба Дорожная карта
             */
            $mapTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsMap($lang)]);

            /**
             * Вывод таба Анализ проекта
             */
            $analysisTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsAnalysis($lang)]);

            /**
             * Вывод таба Наши партнёры
             */
            $partnersTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsPartners($lang)]);

            /**
             * Вывод таба Контактная форма
             */
            $contactFormTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsContactForm($lang)]);


            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([
                AdminDisplay::tabbed([
                    'Header '.$lang => $headerTab,
                    'О компании '.$lang => $aboutTab,
                    'История компании '.$lang => $historyTab,
                    'Миссия компании '.$lang => $missionTab,
                    'Философия компании '.$lang => $philosophyTab,
                    'Видение и стратегия '.$lang => $strategyTab,
                    'Слайдер видео '.$lang => $videoTab,
                    'Дорожная карта '.$lang => $mapTab,
                    'Анализ проекта '.$lang => $analysisTab,
                    'Наши партнёры '.$lang => $partnersTab,
                    'Контактная форма '.$lang => $contactFormTab,
                ])
            ]);
        }

        return [
            'body' => $contentLang
        ];
    }
}
