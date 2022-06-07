<?php

namespace App\Admin\Http\Sections;

use AdminColumn;
use AdminColumnFilter;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
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

/**
 * Class SSettings
 * Администрирование настроек сайта
 *
 * @property \Onessa5\Onessa5Core\Models\SiteSetting $model
 *
 * @see http://sleepingowladmin.ru/docs/model_configuration_section
 */
class SSettings extends Section implements Initializable
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
    protected $title = 'Settings';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        Log::info('Setting initialize');
        //$this->addToNavigation()->setPriority(20)->setIcon('fa fa-lightbulb-o');
    }

    public function isDisplayable() {
        return true;
    }
    /**
     * @param array $payload
     *
     * @return DisplayInterface
     */
    public function onDisplay($payload = [])
    {
        $columns = [
            AdminColumn::text('id', 'ID')->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),

        ];

        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->setDisplaySearch(true)
            ->paginate(25)
            ->setColumns($columns)
            ->setHtmlAttribute('class', 'table-primary table-hover th-center')
        ;
        return $display;

    }

    /**
     * @param int $id
     *
     * @param array $payload
     * @return FormInterface
     */
    public function onEdit($id, $payload = [])
    {
        $form = AdminForm::card();

        $tabsBody = [
            __('Email') => new \SleepingOwl\Admin\Form\FormElements([
                AdminFormElement::columns()
                    ->addColumn([
                        AdminFormElement::checkbox('settings->email->is_send', 'Отправлять?'),
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->host', 'host')->required()
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->port', 'port')->required()
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->username', 'username')->required()
                    ], 6)
                    ->addColumn([
                        AdminFormElement::password('settings->email->password', 'password')->required()
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->from', 'from email')->required()
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->from_name', 'from имя')
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->encryption', 'encryption')->required()
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->to', 'Получатель (для форм)')->required()
                    ], 6)
                    ->addColumn([
                        AdminFormElement::text('settings->email->cc', 'CC Получатели (через запятую) (для форм)')
                    ], 12)
            ])
        ];
        $dataBody = AdminDisplay::tabbed($tabsBody);

        $form->addBody($dataBody);

        $form->getButtons()->setButtons([
            'save' => new Save(),
            'save_and_close' => new SaveAndClose(),
            'cancel' => (new Cancel()),
        ]);

        return $form;
    }

    /**
     * @param array $payload
     * @return FormInterface
     */
    public function onCreate($payload = [])
    {
        return $this->onEdit(null);
    }


    /**
     * @return void
     */
    public function onRestore($id)
    {
        // todo: remove if unused
    }
}
