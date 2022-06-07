<?php

namespace App\Http\Controllers;

use App\Models\forms\FormAbout;
use App\Models\forms\FormCooperation;
use App\Models\forms\Subscription;
use App\Models\options\Language;
use App\Models\options\Region;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use \Onessa5\Onessa5Core\Lib\CommonResponse;
use Onessa5\Onessa5Core\Models\SiteSetting;

/**
 * Class FormController  - для обработки данных с форм
 * @package App\Http\Controllers
 */
class FormController extends Controller
{
    public $siteSettings = null;
    public $isSendEmails = false;
    public $emailSettings = null;
    public $toEmail = '';
    public $ccEmails = null;
    public $lang = 'ru';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->siteSettings = SiteSetting::getSettings();
        $this->lang = \App::getLocale();
        // Устанавливаем настройки почты
        $this->emailSettings = $this->siteSettings->settings->email;
        $this->isSendEmails = $this->emailSettings->is_send;

        $arSmtp = config('mail.mailers.smtp');

        $arSmtp = array_merge($arSmtp,[
            'host' => $this->emailSettings->host,
            'port' => $this->emailSettings->port,
            'encryption' => $this->emailSettings->encryption,
            'username' => $this->emailSettings->username,
            'password' => $this->emailSettings->password,

        ]);
        config(['mail.mailers.smtp' => $arSmtp]);
        $this->toEmail = $this->emailSettings->to;
        $this->ccEmails = $this->emailSettings->cc;
        config(['mail.from.address' => $this->emailSettings->from]);
        if(!empty($this->emailSettings->from_name)) {
            config(['mail.from.name' => $this->emailSettings->from_name]);
        }
    }

    /**
     * Обработка формы подписки новостей
     * структура
     * {
     *  email: "example@mail.ru"
     * }
     */
    public function newsSubscriptionCreate(Request $request)
    {
        $client = new Client(['base_uri' => 'https://my.blockchaincapital.pro/api/']);

        $requestData = $request->all();

        $options = [['email', $requestData['email']], ['lang', $this->lang]];
        $checkEmail = Subscription::checkEmailSubscription($options);

        if ($checkEmail){
            return json_encode(["status" => "subscribed"]);
        }else{
            //если email нет в базе, то добавляем и отправляем письмо по апи
            $modelSub = new Subscription();
            $modelSub->email = $requestData['email'];
            $modelSub->lang = $this->lang;
            $modelSub->save();

            $code = false;
            $response = $client->post('visitor/add', ['json' => ['mail' => $requestData['email']]]);
            $code = $response->getStatusCode();
            if ($code == "200"){
                return json_encode(["status" => "success"]);
            }else{
                return $code;
            }

        }

    }

    /**
     * Обработка формы для Сотрудничества
     * структура
     * {
     *  name: "Иван Иванов"
     *  email: "example@mail.ru"
     *  region: "Красноярский край"
     *  lang: ru|eng|...
     * }
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function cooperationCreate(Request $request)
    {
        $result = new CommonResponse();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required','min:2'],
                'email' => ['required'],
                'region' => ['required']
            ]);

            $isFormError = false;
            $arErrors = [];
            if ($validator->fails()) {
                $isFormError = true;
                $arErrors = $validator->errors()->getMessages();
            }
            if(!$isFormError) {
                //Получение email ответственных за регионы для формы
                $langList = Language::getLanguage(['code', $this->lang]);
                $lang=[];
                foreach ($langList as $itemLang){
                    $lang = $itemLang['ulid'];
                }

                $options = [['is_active', 1], ['lang', $lang]];
                $regionObj = Region::getRegion('*', $options);
                $listRegions = [];
                $emailParent = '';
                foreach ($regionObj as $region){
                    $emailParent = $region->emailParent;
                    $listRegions = json_decode($region->data->main);
                }
                foreach ($listRegions as $region){
                    if($request['region'] == $region->title){
                        $regionManager = $region->email;
                    }
                }
                if (empty($regionManager)){
                    $regionManager = $emailParent;
                }

                $this->toEmail = $regionManager;

                $requestData = $request->all();

                $formData = [
                    'name' => $requestData['name'],
                    'email' => $requestData['email'],
                    'region' => $requestData['region'],
                    'lang' => $lang,
                ];

                $obj = FormCooperation::createObj($formData);

                if($this->isSendEmails) {
                    $mail = Mail::to($this->toEmail);

                    if(!empty($this->ccEmails)) {
                        $addressList = explode(',', str_replace(' ', '', $this->ccEmails));
                        $mail->cc($addressList);
                    }
                    $mail->send(new \App\Mail\FormCooperationCreate($obj));
                }

                $result->setSuccessData(true);
            }else {
                $result->setError($arErrors);
            }

        } catch (\Exception $e) {
            $result->setError($e->getMessage());
            Log::error($e->getMessage());
        }

        return $result->returnResponse();
    }

    /**
     * Обработка формы для Сотрудничества
     * структура
     * {
     *  name: "Иван Иванов"
     *  email: "example@mail.ru"
     *  message: "Сообщение"
     *  lang: ru|eng|...
     * }
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function aboutCreate(Request $request)
    {
        $result = new CommonResponse();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required','min:2'],
                'email' => ['required'],
            ]);

            $langList = Language::getLanguage(['code', $this->lang]);
            $lang=[];
            foreach ($langList as $itemLang){
                $lang = $itemLang['ulid'];
            }

            $isFormError = false;
            $arErrors = [];
            if ($validator->fails()) {
                $isFormError = true;
                $arErrors = $validator->errors()->getMessages();
            }
            if(!$isFormError) {
                $requestData = $request->all();

                $formData = [
                    'name' => $requestData['name'],
                    'email' => $requestData['email'],
                    'message' => $requestData['message'],
                    'lang' => $lang,
                ];

                $obj = FormAbout::createObj($formData);

                if($this->isSendEmails) {
                    $mail = Mail::to($this->toEmail);

                    if(!empty($this->ccEmails)) {
                        $addressList = explode(',', str_replace(' ', '', $this->ccEmails));
                        $mail->cc($addressList);
                    }
                    $mail->send(new \App\Mail\FormAboutCreate($obj));
                }

                $result->setSuccessData(true);
            }else {
                $result->setError($arErrors);
            }

        } catch (\Exception $e) {
            $result->setError($e->getMessage());
            Log::error($e->getMessage());
        }

        return $result->returnResponse();
    }
}
