<?php
namespace Rohit\Tests;

use Orchestra\Testbench\TestCase;
use Rohit\LaravelLocalization\Middleware\LanguageHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Mockery as m;

/**
 * @coversDefaultClass Rohit\LaravelLocalization\Middleware\LanguageHandler
 */
class MiddlewareTest extends TestCase
{
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

        $this->request = m::mock(Request::class);
        $this->handler = app(LanguageHandler::class);
    }

    /**
     * @covers ::handle
     */
    public function testHandleWithDefaultLanguage()
    {
        $this->request->shouldReceive('segment')->with(1)
            ->andReturn('th')
            ->shouldReceive('server')->with('REQUEST_URI')
            ->andReturn('/th/home-page');

        $result = $this->handler->handle($this->request, function () {});

        $this->assertInstanceOf(RedirectResponse::class, $result);
        $this->assertEquals($result->getTargetUrl(), $this->baseUrl . '/home-page');
    }

    /**
     * @covers ::handle
     */
    public function testHandleWithOtherLanguage()
    {
        $this->request->shouldReceive('segment')->with(1)
            ->andReturn('en')
            ->shouldReceive('server')->with('REQUEST_URI')
            ->andReturn('/en/home-page');

        $result = $this->handler->handle($this->request, function () {});

        $this->assertEquals(null, $result);
    }
}
