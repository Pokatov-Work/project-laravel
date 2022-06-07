<?php
namespace App\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use SleepingOwl\Admin\Contracts\ModelConfigurationInterface;
use SleepingOwl\Admin\Http\Controllers\AdminController;

class PageController extends AdminController
{
    public function postUpdate(ModelConfigurationInterface $model, Request $request, $id) {
        Log::error('--------PageController------postUpdate------'.$id);
        $editForm = $model->fireEdit($id);
        $item = $editForm->getModel();
        Log::error('--------PageController------class------'. $editForm->getClass());
        Log::error('--------PageController------item------'.$item);

        return parent::postUpdate($model , $request, $id);

    }
}
