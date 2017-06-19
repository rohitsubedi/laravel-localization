<?php
namespace Rohit\Tests;

use Orchestra\Testbench\TestCase;
use Rohit\LaravelLocalization\LaravelLocalization;
use Illuminate\Http\Request;
use Mockery as m;

/**
 * @coversDefaultClass Rohit\LaravelLocalization\LaravelLocalization
 */
class LaravelLocalizationTest extends TestCase
{
    protected $localization;
    protected $request;

    /**
     * Setup config
     *
     * @param  $app
     *
     * @return null
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('laravel-localization.all_locales', [
            'en',
            'th',
            'fr',
        ]);
        $app['config']->set('laravel-localization.default_locale', 'th');
    }

    /**
     * Test Setup
     */
    public function setUp()
    {
        parent::setUp();

        $this->request      = m::mock(Request::class);
        $this->localization = m::mock(LaravelLocalization::class,[$this->request])->makePartial();
    }

    /**
     * @covers ::setLocale
     */
    public function testSetLocale()
    {
        $this->request->shouldReceive('segment')->with(1)
            ->andReturn('en');

        $returnLang = $this->localization->setLocale();

        $this->assertEquals($returnLang, 'en');
    }

    /**
     * @covers ::getLocaleUrl
     */
    public function testGetLocaleUrl()
    {
        $requestUri = '/en/home-page';

        $this->request->shouldReceive('server')->with('REQUEST_URI')
            ->andReturn($requestUri)
            ->shouldReceive('segment')->with(1)
            ->andReturn('en');

        $frenchUrl  = $this->localization->getLocaleUrl('fr');
        $thaiUrl    = $this->localization->getLocaleUrl('th');
        $englishurl = $this->localization->getLocaleUrl('en');

        $this->assertEquals($frenchUrl, '/fr/home-page');
        /* Thai is default locale */
        $this->assertEquals($thaiUrl, '/home-page');
        $this->assertEquals($englishurl, '/en/home-page');
    }
}
