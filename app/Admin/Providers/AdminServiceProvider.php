<?php

namespace App\Admin\Providers;
use Illuminate\Support\Facades\Log;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminServiceProvider extends \Onessa5\Onessa5Core\Admin\Providers\AdminServiceProvider {

    /**
     * Настройка доступов
     * @var array
     */
    protected $policies = [

    ];
        /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register() {
        Log::info('---------AdminSectionsServiceProvider register------------');

        parent::register();
        Log::info('====================AdminSectionsServiceProvider register=================== END');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot(\SleepingOwl\Admin\Admin $admin) {
        Log::info('---------AdminSectionsServiceProvider register------------');
        parent::boot($admin);
        Log::info('====================AdminSectionsServiceProvider register=================== END');
    }
}
