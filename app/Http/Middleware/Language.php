<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Установка локали в зависимости от домена
 */
class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       $locale = request()->segment(2);

        // if it's a valid language, set as locale and set time zone
        if ( array_key_exists($locale, config()->get('onessa5.adminLanguages')) ) {
            \App::setLocale($locale);
            setlocale(LC_TIME, $locale);
        } else { // дефолтный домен без префикса
            $locale = (null !==  env('APP_LOCALE')) ?  env('APP_LOCALE') : config('app.locale');
            \App::setLocale($locale);
            setlocale(LC_TIME, $locale);
        }

        return $next($request);
    }
}
