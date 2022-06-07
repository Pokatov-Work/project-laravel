<?php

namespace App\Models;

use App\Models\pages\ProductsPage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Onessa5\Onessa5Core\Models\BaseModel;

/**
 * Class WbtCryptoList список всех валют которые входят в индекс WBT
 * @package App\Models
 */
class WbtCryptoList extends BaseModel
{
    use HasFactory;

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'index_value',
        'created_by',

    ];

    /**
     * Список преобразований
     * @var string[]
     */
    protected $casts = [
        'index_value' => 'object',
    ];

    /**
     * Сохранение списка индексов
     * @param $indexValue - масив значенией крипто индексов
     * @return mixed
     */
    public static function saveObject ($indexValue){
        self::updateOrCreate(
            [],
            ['index_value' => $indexValue, 'created_by' => 1]
        );
    }

    /**
     * Получить список всех валют для выборки показа на стр Продукты
     * @return mixed
     */
    public static function getOnCryptoList($fields = ['*']) {
        $cryptoLists = self::select($fields)->get();
        $retCryptoList=[];
        foreach ($cryptoLists as $cryptoObj) {
            $retCryptoList = $cryptoObj->index_value;
        }
        return $retCryptoList;
    }
}
