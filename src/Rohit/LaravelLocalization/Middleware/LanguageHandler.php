<?php

namespace Rohit\LaravelLocalization\Middleware;

use Closure;

class LanguageHandler
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $allLocales = config('laravel-localization.all_locales');

        if (in_array($request->segment(1), $allLocales))
        {
            if($request->segment(1) === config('laravel-localization.default_locale')) {

                array_walk($allLocales, function(&$item, $key) {
                    $item = '/' . $item . '/';
                });

                $url = str_replace($allLocales, '/', $request->server('REQUEST_URI'));

                if ($url === '/' . config('laravel-localization.default_locale')) {
                    $url = '/';
                }

                return redirect($url);
            }
        }

        return $next($request);
    }
}
