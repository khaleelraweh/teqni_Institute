<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Currency;
use App\Models\News;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{

    protected $previousRequest;
    protected $locale;

    public function switch($locale)
    {

        $this->previousRequest = $this->getPreviousRequest();
        $segments = $this->previousRequest->segments();

        try {
            if (array_key_exists($locale, config('locales.languages'))) {

                App::setLocale($locale);
                Lang::setLocale($locale);
                setlocale(LC_TIME, config('locales.languages')[$locale]['unicode']);
                Carbon::setLocale(config('locales.languages')[$locale]['lang']);
                Session::put('locale', $locale);

                if (config('locales.languages')[$locale]['rtl_support'] == 'rtl') {
                    Session::put('lang-rtl', true);
                } else {
                    Session::forget('lang-rtl');
                }

                if (Session()->has('currency_code')) {
                    // dd(Session()->get('currency_code'));
                    $currency_code = Session()->get('currency_code');

                    $currency = Currency::where('currency_code', $currency_code)->first();
                    session()->put('currency_code', $currency->currency_code);
                    session()->put('currency_symbol', $currency->currency_symbol);
                    session()->put('currency_name', $currency->currency_name);
                    session()->put('currency_exchange_rate', $currency->exchange_rate);
                }

                if (Cache::has('site_setting')) {
                    //make cache with  main permition come from permission model tree function
                    Cache::forever('site_setting', SiteSetting::whereNotNull('value')
                        // ->where('section',3)
                        ->pluck('value', 'name')->toArray());
                }

                if (isset($segments[1])) {

                    $url = url()->previous();
                    $routeName = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
                    // dd($routeName);

                    // $currentPath = Route::getFacadeRoot()->current()->uri();
                    // dd($currentPath);

                    if ($routeName === "frontend.card") {
                        // dd("yes");
                        return $this->resolveModel(Product::class, $segments[1], $locale, $routeName);
                    } else if ($routeName === "frontend.card_category") {
                        return $this->resolveModel(ProductCategory::class, $segments[1], $locale, $routeName);
                    } else if ($routeName === "frontend.blog.post") {
                        return $this->resolveModel(News::class, $segments[2], $locale, $routeName);
                    } else if ($routeName === "frontend.courses") {
                        return $this->resolveModel(Course::class, $segments[2], $locale, $routeName);
                    }
                }

                return redirect()->back();
            }

            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back();
        }
    }

    protected function getPreviousRequest()
    {
        return request()->create(url()->previous());
    }

    protected function resolveModel($modelClass, $slug, $locale, $routeName)
    {
        $model = $modelClass::where('slug->' . $locale, $slug)->first();
        if (is_null($model)) {

            foreach (config('locales.languages') as $key => $val) {


                $modelInLocale = $modelClass::where('slug->' . $key, $slug)->first();
                if ($modelInLocale) {

                    $newRoute = str_replace($slug, $modelInLocale->slug, urldecode(urlencode(route($routeName, $modelInLocale->slug))));

                    return redirect()->to($newRoute)->send();
                }
            }
            abort(404);
        }
        return $model;
    }
}
