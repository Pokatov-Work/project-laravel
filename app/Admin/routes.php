<?php

use Illuminate\Support\Facades\Log;


$routesPath = base_path('admin/routes');
if(file_exists($routesPath)) {
    $files =  preg_grep('~\.(php)$~',scandir($routesPath));

    foreach($files as $file) {
        if('.' !== $file && '..' !== $file && '.gitkeep' !== $file) {

            require_once $routesPath.'/'.$file;
        }
    }
}


