<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Onessa5\Onessa5Core\Models\BaseModel;

class WbtCryptoGraph extends BaseModel
{
    use HasFactory;

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'index_value',
        'period',
        'created_by',
    ];

    /**
     * Список преобразований
     * @var string[]
     */
    protected $casts = [
        'index_value' => 'object',
        'period' => 'integer',
    ];

    /**
     * Сохранение списка индексов
     * @param $indexValue - масив значенией крипто индексов
     * @param $period
     * @return mixed
     */
    public static function saveObjectGraph ($indexValue, $period){
        self::updateOrCreate(
            ['period' => $period],
            ['index_value' => $indexValue, 'created_by' => 1, 'period' => $period]
        );
    }

    /**
     * Получить список всех валют для выборки показа на стр Продукты
     * @param $fields
     * @return mixed
     */
    public static function getOnCryptoGraph($fields = ['*']) {
        $periods = config('onessa5.adminPeriods');
        $cryptoLists = self::select($fields)->get();

        $retCryptoList = [];
        foreach ($cryptoLists as $cryptoObj) {
            $retCryptoList[] = [
                'index_value' => $cryptoObj->index_value,
                'period' => $cryptoObj->period,
            ];
        }
        return $retCryptoList;
    }
}
