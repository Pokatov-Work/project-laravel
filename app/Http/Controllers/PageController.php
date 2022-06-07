<?php
namespace App\Http\Controllers;

use App\Models\options\MainMenu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

use \Onessa5\Onessa5Core\Models\SiteSetting;
use \Onessa5\Onessa5Core\Models\PageTree;
use \Onessa5\Onessa5Core\Models\Page;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

use \Onessa5\Onessa5Core\Http\Controllers\PageController as Onessa5PageController;
use \Onessa5\Onessa5Core\Models\SiteLayout as Onessa5SiteLayout;
/**
 * Отображение страниц
 */
class PageController extends \Onessa5\Onessa5Core\Http\Controllers\PageController {

    public function getMultilanguagePath($pagePath) {
        $lang = \App::getLocale();
        $retPath = str_replace($lang,'',$pagePath);
        return $retPath;
    }


    /**
     * данные для страниц
     * @param Request $request
     * @param $lang
     * @param $pagePath
     * @param $options
     * @return array|void|null
     */
    public function apiLangPages(Request $request, $lang='ru', $pagePath='/', $options=[]) {
        try {
            $page = PageTree::getPageByPath($pagePath);

            if(null !== $page) {
                // получаем конфиг страницы
                $pageConfig = $page->getPageConfig();

                $pageView = $pageConfig['view'];
                $dataConvertorFunction = $pageConfig['convertor'];

                $modelData = null;

                // Проверка, есть ли функция-преобразователь для данной страницы
                if(!empty($dataConvertorFunction) && method_exists($this, (string)$dataConvertorFunction)) {

                    $modelData = $this->$dataConvertorFunction($request, $page);

                } else {
                    $modelData = $page->getPageData();
                }

                $pageData = [];

                // Получаем Layout данные
                $layoutData = Onessa5SiteLayout::getListLayoutData(Onessa5SiteLayout::getDefaultListName());

                // Получаем и формируем последовательность хлебных крошек
                $mainMenu = MainMenu::getMenu([], false);
                foreach ($mainMenu as $item){
                    if ($item->data->$lang->menu->url == '/'){
                        $mainMenuList[] = [
                            'title' => $item->data->$lang->menu->title,
                            'url' => $item->data->$lang->menu->url,
                        ];
                    }else{
                        $mainMenuList[] = [
                            'title' => $item->data->$lang->menu->title,
                            'url' => '/' . $item->data->$lang->menu->url,
                        ];
                    }

                }

                $arrPageSlug = explode('/', $pagePath);
                $breadcrumbs = [];
                if (count($arrPageSlug) <= 1){
                    $i = 0;
                    foreach ($mainMenuList as $menu){
                        if ($menu['url'] == '/'){
                            $breadcrumbs[$i] = $menu;
                            $i++;
                        }
                        if ($menu['url'] == '/'.$arrPageSlug[0]){
                            $breadcrumbs[$i] = $menu;
                            $i++;
                        }
                    }
                }else{
                    $i = 0;
                    foreach ($mainMenuList as $menu){
                        if ($menu['url'] == '/'){
                            $breadcrumbs[$i] = $menu;
                            $i++;
                        }
                        foreach ($arrPageSlug as $slug){
                            if ($menu['url'] == '/'.$slug){
                                $breadcrumbs[$i] = $menu;
                                $i++;
                            }
                        }
                        if ($menu['url'] == '/'.$pagePath){
                            $breadcrumbs[$i] = $menu;
                            $i++;
                        }
                    }
                }

                $modelData->header->breadcrumbs = $breadcrumbs;

                // Проверка, если запрос из API, то удаляем служебные данные
                if(!in_array(Onessa5PageController::FULL_PAGE_DATA, $options)) { // API

                    unset($page->data_config);
                    unset($page->data_value);

                    $pageData = [
                        'layout' => $layoutData,
                        'pageTitle' => $page->title,
                        'page' => [
                            'slug' =>$page->slug,
                            'ulid' =>$page->ulid,
                            'meta_list' => $page->meta_list,
                            'preview' =>$page->preview,
                            'content' =>$page->content,
                        ],
                        'pageData' => $modelData
                    ];
                } else { // Рендер страницы
                    $pageData = [
                        'layout' => $layoutData,
                        'view' => $pageView,
                        'pageTitle' => $page->title,
                        'page' => $page,
                        'pageData' => $modelData,
                        'siteSettings' => $this->siteSettings
                    ];
                }

                return $pageData;
            } else {
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Error (apiPages): '.$e->getMessage());
            Log::error('Error (apiPages): '.$e->getTraceAsString());
        }
    }


    /**
     * Получение модели страницы по ее пути, отображение страницы
     * @param Request $request
     * @param $lang
     * @param $pagePath
     * @return mixed
     */
    public function langPages(Request $request, $lang='ru', $pagePath='/') {
        try {
            // получение данных
            $pageData = $this->apiLangPages($request, $lang, $pagePath,[Onessa5PageController::FULL_PAGE_DATA]);
            if(null !== $pageData) {
                $pageView = $pageData['view'];
                unset($pageData["view"]);

                return view($pageView, $pageData);
            }
        } catch (\Exception $e) {
            Log::error('Error (pages): '.$e->getMessage());
            Log::error('Error (pages): '.$e->getTraceAsString());
            return $this->renderError($e->getCode());
        }
        return $this->renderError(404,['pageTitle'=>404]);
    }

    /**
     * Пример модификации данных в контроллере для модели и страницы.
     * Функция устанавливается в Config страницы, поле - Convertor
     * Необходим, если нужно сделать какие-то операции в контроллере для конкретной страницы
     * @param Request $request
     * @param $page
     * @return string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function indexConv(Request $request, $page ) {

        return $page->getPageData();
    }
}
