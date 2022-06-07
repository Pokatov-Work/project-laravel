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

class SLayoutFooter implements ISectionExt {


    public static function modifyModel() {
        return \Onessa5\Onessa5Core\Models\layouts\LayoutFooter::modifyModel();
    }

    public function getDisplay($model) {
        return null;
    }

    /**
     * Формирование структуры меню
     * @param $lang
     * @return mixed
     */
    public function getFieldsFooter ($lang)
    {
        return AdminFormElement::columns()
            ->addColumn([AdminFormElement::image('data->'.$lang.'->logo_menu','Логотип в футере')
                ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                    return 'img/layout'; // public/files
                })
                ->setAllowSvg(true),
            ], 6)
            ->addColumn([AdminFormElement::file('data->'.$lang.'->politic','Политика конфиденциальности')
                ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                    return 'files';
                })
            ], 6)
            ->addColumn([AdminFormElement::file('data->'.$lang.'->cookies','Настройки cookies')
                ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                    return 'files';
                })
            ], 6)
            ->addColumn([AdminFormElement::file('data->'.$lang.'->fileInfo','Раскрытие информации')
                ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                    return 'files';
                })
            ], 6)
            ->addColumn([AdminFormElement::text('data->'.$lang.'->email', 'Email адрес')], 6)
            ->addColumn([AdminFormElement::text('data->'.$lang.'->address', 'Адрес')], 6)
            ->addColumn([AdminFormElement::textarea('data->'.$lang.'->information', 'Правовая информация')], 6);
    }

    /**
     * @param Model $model
     * @return mixed|\SleepingOwl\Admin\Form\FormElements[][]
     */
    public function getEdit($model) {

        $langList = config('onessa5.adminLanguages');

        $contentLang =[];
        foreach ($langList as $lang => $langTitle) {

            $footerTab = new \SleepingOwl\Admin\Form\FormElements([$this->getFieldsFooter($lang)]);

            $contentLang[$langTitle] = new \SleepingOwl\Admin\Form\FormElements([$footerTab]);
        }

        return $contentLang;
    }
}
