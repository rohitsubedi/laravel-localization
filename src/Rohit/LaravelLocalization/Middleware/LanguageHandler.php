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
        $locale     = $request->segment(1);

        if (in_array($locale, $allLocales))
        {
            if($locale === $default) {
                $url = $request->server('REQUEST_URI');
                $pos = strpos($url, '/' . $default);
                $url = substr_replace($url, '', $pos, strlen('/' . $default));

                return redirect($url);
            }
        }

        return $next($request);
    }
}
