<?php
namespace App\Admin\Http\Controllers;

use Illuminate\Http\Request;
use SleepingOwl\Admin\Http\Controllers\AdminController;

class Controller extends AdminController
{
    public function test(Request $reques) {
        var_dump($reques->slug);
    }
}
