<?php

namespace App\Models\options;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Onessa5\Onessa5Core\Models\BaseModel;

class Language extends BaseModel
{

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'ulid'
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

    public static function getLanguage($option=[])
    {
        $qery = null;
        $langList = [];
        if (!empty($option)){
            $qery = self::select('*')
                ->where([$option])
                ->get();
        }else{
            $qery = self::select('*')
                ->get();
        }

        if ($qery !== null) {
            foreach ($qery as $lang) {
                $langList[] = [
                    'id' => $lang->id,
                    'name' => $lang->name,
                    'ulid' => $lang->ulid,
                ];
            }
        }

        return $langList;
    }
}
