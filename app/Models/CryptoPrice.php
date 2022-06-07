<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Onessa5\Onessa5Core\Models\BaseModel;

class CryptoPrice extends BaseModel
{
    use HasFactory;

    const BCTUSD = 'bctusd';
    const WBTUSD = 'wbtusd';

    /**
     * Список заполняемых полей
     * @var array
     */
    protected $fillable = [
        'index_value',
        'name',
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
     * Обновление значений криптовалюты WBT
     * @param array $cryptoData - масив значенией крипто индекса WBT
     * @return object
     */
    public static function saveObjectPrice ($cryptoData){
        return self::updateOrCreate(
            ['name' => $cryptoData['key']],
            ['name' => $cryptoData['key'], 'index_value' => $cryptoData, 'created_by' => 1]
        );
    }


    /**
     * Получить значение криптовалюты для вывода на странице
     * @param string[] $fields
     * @param $cryptoName
     * @return mixed
     */
    public static function getDataOnCryptoPrice($cryptoName, $fields = ['*']) {
        $cryptoIndex = self::select($fields)
            ->where('name', $cryptoName)
            ->first();

        return $cryptoIndex;
    }
}
