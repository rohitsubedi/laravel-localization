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
        $allLocales = config('laravel-localization.all_locales', []);
        $default    = config('laravel-localization.default_locale', '');

        if (strlen($default)) {
            if (in_array($request->segment(1), $allLocales))
            {
                if($request->segment(1) === $default) {
                    array_walk($allLocales, function(&$item, $key) {
                        $item = '/' . $item . '/';
                    });

                    $url = str_replace($allLocales, '/', $request->server('REQUEST_URI'));

                    if ($url === '/' . $default) {
                        $url = '/';
                    }

                    return redirect($url);
                }
            }
        }

        return $next($request);
    }
}
