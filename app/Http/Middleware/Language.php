<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;

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

        // اذا كان معنا سيشن لوكال و هذا اللوكال موجود من ضمن اللغات الموجودة في ال لوكال نقوم بتعيينها كلغة الموقع الحالية
        if (Session::has('locale') && array_key_exists(Session::get('locale'), config('locales.languages'))) {
            App::setLocale(Session::get('locale'));
        } else {
            //  اذا لم توجد اللغة كسيشن مسبق نقوم باعداد اللغة بناء علي لغة الجهاز 
            $userLanguages = preg_split('/[,;]/', $request->server('HTTP_ACCEPT_LANGUAGE'));
            foreach ($userLanguages as $userLanguage) {
                if (array_key_exists($userLanguage, config('locales.languages'))) {
                    App::setLocale($userLanguage);
                    Lang::setLocale($userLanguage);
                    setlocale(LC_TIME, config('locales.languages')[$userLanguage]['unicode']);
                    Carbon::setLocale(config('locales.languages')[$userLanguage]['lang']);
                    if (config('locales.languages')[$userLanguage]['rtl_support'] == 'rtl') {
                        session(['lang-rtl' => true]);
                    } else {
                        Session::forget('lang-rtl');
                    }
                    break;
                }
            }
        }

        return $next($request);
    }
}
