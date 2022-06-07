<?php
use \Illuminate\Routing\Router;

Route::get('/', ['as' => 'admin.dashboard', function () {
	$content = 'Define your dashboard here.';
	return AdminSection::view($content, 'Dashboard');
}]);

Route::get('information', ['as' => 'admin.information', function () {
	$content = 'Define your information here.';
	return AdminSection::view($content, 'Information');
}]);

Route::get('logs',   ['as' => 'admin.logs', function () {
    $content = 'Отображение логов.';
    return AdminSection::view($content, 'Logs');
}]);



