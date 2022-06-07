<?php

namespace App\Http\Controllers;

use App\Models\CryptoPrice;
use App\Models\WbtCryptoGraph;
use App\Models\WbtCryptoList;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use \Onessa5\Onessa5Core\Models\SiteSetting;
use \Onessa5\Onessa5Core\Models\PageTree;
use \Onessa5\Onessa5Core\Models\Page;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ApiCryptoController
 * @package App\Http\Controllers
 */
class ApiCryptoController extends Controller
{
    /**
     * Функция делает запрос на получение списка индексов WBT и записывает результат в таблицу wbt_crypto_lists
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWbtCryptoList()
    {
        $client = new Client(['base_uri' => 'https://my.blockchaincapital.pro/api/']);

        $response = $client->get('stat/portfoliopie');

        $code = $response->getStatusCode();
        $body = $response->getBody();
        $stringBody = json_decode((string)$body);

        WbtCryptoList::saveObject($stringBody);

    }

    /**
     * Функция для получения данных из апи для графика на странице WBT
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWbtCryptoGraph(){
        $client = new Client(['base_uri' => 'https://my.blockchaincapital.pro/api/']);

        /*
            Показатели за все время —  -1,
            Показатели за сутки — 0,
            Показатели за неделю — 1,
            Показатели за месяц — 2,
            За три месяца — 3,
            За год — 4
        */
        $periods = config('onessa5.adminPeriods');
        foreach ($periods as $period){
            $response = $client->get('charts/wbt/'.$period);

            $body = $response->getBody();
            $cryptoGraphs = json_decode((string)$body);

            WbtCryptoGraph::saveObjectGraph($cryptoGraphs, $period);
        }
    }

    /**
     * Функция для получения данных из апи для показа котировки на странице WBT и BCT
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getCryptoPrice(){
        $client = new Client(['base_uri' => 'https://my.blockchaincapital.pro/api/']);

        $response = $client->get('stat/token/010320/010321');
        $body = $response->getBody();
        $cryptoPriceArr = json_decode((string)$body, true);

        $wbtUsd = [];
        $bctUsd = [];
        foreach ($cryptoPriceArr as $name => $value){
            if ($name == "wbtusd") {
                $wbtUsd['key'] = $name;
                $wbtUsd[$name] = $value;
            }
            if ($name == "bctusd") {
                $bctUsd['key'] = $name;
                $bctUsd[$name] = $value;
            }
            if ($name == "percentWBT") $wbtUsd[$name] = $value;
            if ($name == "dividendforbct") $bctUsd[$name] = $value;
        }

        if(!empty($wbtUsd)) {
            CryptoPrice::saveObjectPrice($wbtUsd);
        }

        if(!empty($bctUsd)) {
            CryptoPrice::saveObjectPrice($bctUsd);
        }
    }
}
