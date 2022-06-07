<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

use \Onessa5\Onessa5Core\Models\BaseModel;
use Onessa5\Onessa5Core\Models\IModelModify;

class Subscription extends BaseModel
{

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'email'
    ];
    /**
     * Список преобразований
     * @var string[]
     */
    protected $casts = [
    ];

    /**
     * Модификация модели из модулей (возможно не будет применяться), а заменится на trait
     */
    public static function modifyModel() {

    }

    /**
     * Функция для проверки подписки пользователя
     * @param $option - условия выборки where, вида [['is_active', 1], [...]]
     * @param string[] $fields
     * @return mixed
     */
    public static function checkEmailSubscription($option, $fields = ['*']) {
        $emailChecked='';
        $emailChecked = self::select($fields)
            ->where($option)
            ->value('email');

        return $emailChecked;
    }

    /**
     * Функция удаления подписки на рассылку
     * @param $email
     * @return
     */
    public static function deleteEmailSubscription($email){
        $emailDelete = '';
        $emailDelete = self::where('email', $email)
            ->delete();

        return $emailDelete;
    }
}
