<?php

namespace Rohit\LaravelLocalization;

class LaravelLocalization
{
    public $request;
    public $app;
    /**
     * Creates New instances of app and request
     */
    public function __construct()
    {
        $this->app = app();

        $this->request = $this->app['request'];
    }

    /**
     * set current locale and return prefix for routing
     *
     * @return string
     */
    public function setLocale()
    {
        $lang = $this->request->segment(1);

        if (in_array($lang, config('laravel-localization.all_locales'))) {
            $this->app->setLocale($lang);

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
        $allLocales = config('laravel-localization.all_locales', []);
        $default    = config('laravel-localization.default_locale', '');
        $currentUrl = $this->request->server('REQUEST_URI');

        if ($lang && in_array($lang, $allLocales)) {
            array_walk($allLocales, function(&$item, $key) use ($currentUrl) {
                if ($currentUrl === '/' . $item) {
                    $currentUrl = '/';
                }

                $item = '/' . $item . '/';
            });

            $currentUrl = str_replace($allLocales, '/', $currentUrl);

            if ($default != $lang) {
                $currentUrl = '/' .$lang . $currentUrl;
            }
        }

        return $currentUrl;
    }
}
