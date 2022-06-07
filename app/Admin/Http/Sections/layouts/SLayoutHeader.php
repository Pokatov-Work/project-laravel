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

class SLayoutHeader implements ISectionExt {

    public static function modifyModel() {
        return \Onessa5\Onessa5Core\Models\layouts\LayoutHeader::modifyModel();
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
                    ->addColumn([AdminFormElement::image('data->logo_main','Главный логотип')
                        ->setUploadPath(function(\Illuminate\Http\UploadedFile $file) {
                            return 'img/layout'; // public/files
                        })
                        ->setAllowSvg(true),
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('data->personal', 'Ссылка на личный кабинет')
                    ], 6)
            ])
        ];
    }
}
