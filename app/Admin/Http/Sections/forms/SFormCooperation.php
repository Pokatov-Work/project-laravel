<?php


namespace App\Admin\Http\Sections\forms;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminColumnEditable;
use App\Models\forms\FormCooperation;
use App\Models\options\Language;
use App\Models\options\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Section;
use function MongoDB\BSON\toJSON;

class SFormCooperation extends Section implements Initializable
{
    /**
     * @see http://sleepingowladmin.ru/docs/model_configuration#ограничение-прав-доступа
     *
     * @var bool
     */
    protected $checkAccess = false;

    /**
     * @var string
     */
    protected $title = 'Сотрудничество';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize() {

    }

    public function isDisplayable() {
        return true;
    }


    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = []) {
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('name', 'Имя'),
            AdminColumn::text('email', 'Email *'),
            AdminColumn::text('region', 'Регион'),

            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
                ->setWidth('160px')
                ->setOrderable(function ($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
                ->setSearchable(false)
        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center');
        return $display;
    }

    public function fireEdit($id, $payload = []) {
        return parent::fireEdit($id, $payload);
    }

    /**
     * @param int $id
     *
     * @param array $payload
     * @return FormInterface
     */
    public function onEdit($id, $payload = []) {
        $langList = config('onessa5.adminLanguages');
        $lang = \App::getLocale();
        $langList = Language::getLanguage(['code', $lang]);
        $lang=[];
        foreach ($langList as $itemLang){
            $lang = $itemLang['ulid'];
            $langTitle[$itemLang['ulid']] = $itemLang['name'];
        }
        $options = [['is_active', 1], ['lang', $lang]];
        $regionObj = Region::getRegion('data', $options);

        foreach ($regionObj as $region){
            $regions = json_decode($region->data->main, true);
        }
        $regionTitle = [];
        if (!empty($regions)) {
            foreach ($regions as $regionValue) {
                $regionTitle[$regionValue['title']] = $regionValue['title'];
            }
        }

        return AdminForm::panel()

            ->addBody([
                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::text('name', 'Имя')->required(),
                    ], 4)
                    ->addColumn([
                        AdminFormElement::text('email', 'Email')->required(),
                    ], 4)
                    ->addColumn([
                        AdminFormElement::select('region', 'Регион', $regionTitle)
                    ], 6)
                    ->addColumn([
                        AdminFormElement::select('lang', 'Язык', $langTitle)
                    ], 6)
                    ->addColumn([
                        AdminFormElement::html('created_at')
                            ->setDisplay(function(Model $model) {
                                return (string) "<b>Создано:</b> ".$model->created_at;
                            }),
                    ], 3)
            ])
            ->setHtmlAttribute('enctype', 'multipart/form-data');
    }

    /**
     * @param array $payload
     * @return FormInterface
     */
    public function onCreate($payload = []) {
        return $this->onEdit(null);
    }

    /**
     * @return void
     */
    public function onDelete($id) {
        // todo: remove if unused
    }

    /**
     * @return void
     */
    public function onRestore($id) {
        // todo: remove if unused
    }
}
