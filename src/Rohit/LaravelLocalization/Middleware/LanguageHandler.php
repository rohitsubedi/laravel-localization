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

        if (in_array($request->segment(1), $allLocales))
        {
            if($request->segment(1) === $default) {
                $url = $request->server('REQUEST_URI');
                $pos = strpos($url, '/' . $default);
                $url = substr_replace($url, '', $pos, strlen('/' . $default));

                return redirect($url);
            }
        }

        return $next($request);
    }
}
