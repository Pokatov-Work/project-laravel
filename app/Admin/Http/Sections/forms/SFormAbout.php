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

class SFormAbout extends Section implements Initializable
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
    protected $title = 'Обратная связь';

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

    public function getLanguages(){
        $lang = \App::getLocale();
        $langList = Language::getLanguage(['code', $lang]);
        $lang=[];
        foreach ($langList as $itemLang){
            $lang = $itemLang['ulid'];
            $langTitle[$itemLang['ulid']] = $itemLang['name'];
        }
        return $langTitle;
    }

    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = []) {
        $langs = $this->getLanguages();
        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('name', 'Имя'),
            AdminColumn::text('email', 'Email'),

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
        $langs = $this->getLanguages();

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
                        AdminFormElement::text('message', 'Сообщение'),
                    ], 6)
                    ->addColumn([
                        AdminFormElement::select('lang', 'Язык', $langs)
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
