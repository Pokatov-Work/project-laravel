<?php

namespace App\Models\forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

use \Onessa5\Onessa5Core\Models\BaseModel;
use Onessa5\Onessa5Core\Models\IModelModify;

class FormAbout extends BaseModel
{

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'name',
        'message',
        'email',
        'lang'
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
}
