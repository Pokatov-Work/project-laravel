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

class SLayoutSocialIcon implements ISectionExt
{
    public static function modifyModel() {
        return \App\Models\layouts\LayoutSocialIcon::modifyModel();
    }

    public function getDisplay($model) {
        return null;
    }

    /**
     * @param Model $model
     * @return mixed|\SleepingOwl\Admin\Form\FormElements[][]
     */
    public function getEdit($model) {
        return [
            'Данные' => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::columns()
                    ->addColumn([AdminFormElement::text('data->facebook->title', 'Название соц. сети')], 6)
                    ->addColumn([AdminFormElement::text('data->facebook->url', 'Ссылка на соц. сеть')], 6)
                    ->addColumn([AdminFormElement::image('data->facebook->icon','Иконка')
                        ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                            return 'img/page';
                        })
                    ], 12)
                    ->addColumn([AdminFormElement::text('data->instagram->title', 'Название соц. сети')], 6)
                    ->addColumn([AdminFormElement::text('data->instagram->url', 'Ссылка на соц. сеть')], 6)
                    ->addColumn([AdminFormElement::image('data->instagram->icon','Иконка')
                        ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                            return 'img/page';
                        })
                    ], 12)
                    ->addColumn([AdminFormElement::text('data->twit->title', 'Название соц. сети')], 6)
                    ->addColumn([AdminFormElement::text('data->twit->url', 'Ссылка на соц. сеть')], 6)
                    ->addColumn([AdminFormElement::image('data->twit->icon','Иконка')
                        ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                            return 'img/page';
                        })
                    ], 12)
            ])
        ];
    }
}
