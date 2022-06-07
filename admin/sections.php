<?php
/**
 * Список секций
 * Вычитка вложенных секций, обьединение в одни массив.
 * Тут же можно модифицировать
 */
$adminPath = base_path('admin');
$sectionsPath = base_path('admin/sections');

$adminSections = [];
// --------------- Core --------------------------
if (file_exists($sectionsPath . '/core.php')) {
    $coreSectionsArray = include $sectionsPath . '/core.php';
    $adminSections = array_merge($adminSections, $coreSectionsArray);
}
// -----------------------------------------------

// --------------- News --------------------------
if (file_exists($sectionsPath . '/news.php')) {
    $newsSectionsArray = include $sectionsPath . '/news.php';
    $adminSections = array_merge($adminSections, $newsSectionsArray);
}
// -----------------------------------------------

// Секции проекта
$appSection =  [
    App\Models\forms\Subscription::class => '\App\Admin\Http\Sections\forms\SFormSubscription',
    App\Models\forms\FormCooperation::class => '\App\Admin\Http\Sections\forms\SFormCooperation',
    App\Models\forms\FormAbout::class => '\App\Admin\Http\Sections\forms\SFormAbout',
    App\Models\options\Region::class => '\App\Admin\Http\Sections\options\SRegion',
    App\Models\options\Language::class => '\App\Admin\Http\Sections\options\SLanguage',
    App\Models\options\MainMenu::class => '\App\Admin\Http\Sections\options\SMainMenu',
];

$adminSections = array_merge($adminSections, $appSection);

return $adminSections;



