<?php

namespace App\Admin\Http\Sections\options;

use Illuminate\Support\Facades\Log;

use AdminColumn;
use AdminDisplay;
use AdminForm;
use AdminFormElement;
use AdminDisplayFilter;
use AdminSection;
use AdminColumnFilter;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\Initializable;
use SleepingOwl\Admin\Form\Buttons\Cancel;
use SleepingOwl\Admin\Form\Buttons\Save;
use SleepingOwl\Admin\Form\Buttons\SaveAndClose;
use SleepingOwl\Admin\Form\Buttons\SaveAndCreate;
use SleepingOwl\Admin\Display\Column\Order;
use SleepingOwl\Admin\Display\Tree\OrderTreeType;
use SleepingOwl\Admin\Display\Tree\KalnoyNestedsetType;
use SleepingOwl\Admin\Navigation\Badge;
use SleepingOwl\Admin\Section;

class SLanguage extends Section implements Initializable
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
    protected $title = 'Языки';

    /**
     * @var string
     */
    protected $alias;

    /**
     * Initialize class.
     */
    public function initialize()
    {
        //$this->addToNavigation()->setIcon('fa fa-sitemap')->setBadge(new Badge('New'));
    }

    public function isDisplayable() {
        return true;
    }

    /**
     * @return DisplayInterface
     */
    public function onDisplay($scopes = []) {
        $display = AdminDisplay::datatables()
            ->setName('firstdatatables')
            ->setOrder([[0, 'asc']])
            ->paginate(10)
            ->setHtmlAttribute('class', 'table-primary table-hover th-left');

        $display->getFilters()->initialize();

        if($scopes){
            $display->getScopes()->push($scopes);
        }

        $columns = [
            AdminColumn::text('id', '#')->setWidth('50px')
                ->setHtmlAttribute('class', 'text-center'),
            AdminColumn::text('name', 'Имя'),
            AdminColumn::text('code', 'Язык'),

            AdminColumn::text('created_at', 'Created / updated', 'updated_at')
                ->setWidth('160px')
                ->setOrderable(function ($query, $direction) {
                    $query->orderBy('created_at', $direction);
                })
                ->setSearchable(false)
        ];

        $display->setColumns($columns);

        return $display;
    }

    public function fireEdit($id, $payload = []) {
        return parent::fireEdit($id, $payload); // TODO: Change the autogenerated stub
    }


    /**
     * Создание таба Регионы
     * @param $lang
     * @return \SleepingOwl\Admin\Form\Columns\Columns
     * @throws \Exception
     */
    public function genFieldsNews (){
        $langList = config('onessa5.adminLanguages');
        return AdminFormElement::columns()
            ->addColumn([
                AdminFormElement::select('code', 'Язык', $langList),
            ], 3);
    }


    /**
     * @param int|null $id
     * @return FormInterface
     */
    public function onEdit($id) {
        $form = AdminForm::card();
        $dataHeader = [
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('name', 'Name')->required()
                ], 3)
                ->addColumn([
                    AdminFormElement::text('ulid', 'ulid'),
                ], 3)

        ];

        $dataTabsBody =[];


        $langTab = new \SleepingOwl\Admin\Form\FormElements([$this->genFieldsNews()]);

        $dataTabsBody['Язык'] = new \SleepingOwl\Admin\Form\FormElements([$langTab]);

        // Config
        $dataTabsBody['Config'] = new \SleepingOwl\Admin\Form\FormElements([
            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('data_config->model', 'Model')
                        ->setHelpText('Имя класса модели')
                ], 4)
                ->addColumn([
                    AdminFormElement::text('data_config->form', 'Form')
                        ->setHelpText('Имя класса для модификации формы')
                ], 4)
                ->addColumn([
                    AdminFormElement::text('data_config->view', 'View')
                        ->setHelpText('Имя view')
                ], 4)
                ->addColumn([
                    AdminFormElement::text('data_config->convertor', 'Convertor')
                        ->setHelpText('Функция контроллера в которая будет вызвана для преобразования данных')
                ], 4),

            AdminFormElement::columns()
                ->addColumn([
                    AdminFormElement::text('created_at', 'Создано')->setReadonly(true),
                    AdminFormElement::text('created_by', 'Создал')->setReadonly(true)
                ], 4)->addColumn([
                    AdminFormElement::text('updated_at', 'Изменено')->setReadonly(true),
                    AdminFormElement::text('updated_by', 'Изменил')->setReadonly(true)
                ], 4)->addColumn([
                    AdminFormElement::text('deleted_at', 'Удалено')->setReadonly(true),
                    AdminFormElement::text('deleted_by', 'Удалил')->setReadonly(true)
                ])
        ]);

        $dataFooter = [

        ];

        $extensionEdit = $this->getExtension();

        foreach ($extensionEdit as $extensionSectionKey => $extensionObj) {

            switch ($extensionSectionKey) {
                case 'header':
                    $dataHeader = array_merge($dataHeader, $extensionObj);
                    break;
                case 'body':
                    foreach ($extensionObj as $extensionTabKey => $extensionElements) {

                        if (array_key_exists($extensionTabKey, $dataTabsBody)) {

                            $dataTabsBody[$extensionTabKey]->addElement($extensionElements);
                        } else {
                            $dataTabsBody[$extensionTabKey] = $extensionElements;
                        }
                    }
                    break;
                case 'footer':
                    $dataFooter = array_merge($dataFooter, $extensionObj);
                    break;
            }
        }

        $dataBody = AdminDisplay::tabbed($dataTabsBody);

        $form->addHeader($dataHeader);
        $form->addBody($dataBody);
        $form->addBody($dataFooter);
        $form->getButtons()->setButtons([
            'save' => new Save(),
            'save_and_close' => new SaveAndClose(),
            'save_and_create' => new SaveAndCreate(),
            'cancel' => (new Cancel()),
        ]);


        return $form;
    }

    public function isCreatable() {
        return true;
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

    /**
     * Получение расширения для формы и установка модели
     * @return array
     */
    public function getExtension(): array
    {
        $extForm = [];
        $modelValue = $this->getModelValue();

        try {
            $model = $this->getModel();

            if (null !== $modelValue) {
                // Получаем имя класса для расширения полей секции
                $sectionClassName = $modelValue->form;

                /**
                 * @var \Onessa5\Core\Admin\Http\Sections\ISectionExt
                 */
                $sectionExtClass = (!empty($sectionClassName)) ? new $sectionClassName() : null;


                if (null !== $sectionExtClass) {

                    $sectionExtClass::modifyModel($model);
                    // получение расширения формы
                    $extForm = $sectionExtClass->getEdit($model);
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        return $extForm;
    }
}
