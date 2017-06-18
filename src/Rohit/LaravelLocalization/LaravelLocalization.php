<?php

namespace Rohit\LaravelLocalization;

use Illuminate\Http\Request;

class LaravelLocalization
{
    protected $request;
    /**
     * Creates New instances of app and request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * set current locale and return prefix for routing
     *
     * @return string
     */
    public function setLocale()
    {
        $lang = $this->request->segment(1);

        if (in_array($lang, config('laravel-localization.all_locales', []))) {
            app()->setLocale($lang);

            return $lang;
        }

        return '';
    }

    /**
     * Return localized url for language switcher
     * @param $lang Language Prefix
     *
     * @return string
     */
    public function getLocaleUrl($lang = '')
    {
        $allLocales  = config('laravel-localization.all_locales', []);
        $default     = config('laravel-localization.default_locale', '');
        $currentUrl  = $this->request->server('REQUEST_URI');
        $replacelang = '/' . ($lang === $default ? '' : $lang);

        if ($lang && in_array($lang, $allLocales)) {
            $currentLang = $this->request->segment(1);

            if (!in_array($currentLang, $allLocales)) {
                $currentUrl = $replacelang . $currentUrl;
            } else {
                $langPos    = strpos($currentUrl, '/' . $currentLang);
                $currentUrl = substr_replace($currentUrl, $replacelang, $langPos, strlen('/' . $currentLang));
            }
        }

        return str_replace('//', '/', $currentUrl);
    }
}
