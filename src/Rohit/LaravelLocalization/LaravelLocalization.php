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
}
