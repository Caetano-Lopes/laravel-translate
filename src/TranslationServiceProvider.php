<?php

namespace Twigger\Translate;

use Twigger\Translate\Http\Controllers\TranslationController;
use Twigger\Translate\Locale\Strategies\BodyDetectionStrategy;
use Twigger\Translate\Locale\Strategies\CookieDetectionStrategy;
use Twigger\Translate\Locale\DetectionStrategyStore;
use Twigger\Translate\Locale\Strategies\HeaderDetectionStrategy;
use Twigger\Translate\Translate\Interceptors\CacheInterceptor;
use Twigger\Translate\Translate\Interceptors\DatabaseInterceptor;
use Twigger\Translate\Translate\TranslationFactory;
use Twigger\Translate\Translate\TranslationManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(DetectionStrategyStore::class);
        $this->app->singleton(TranslationFactory::class);
        $this->app->singleton('portal-translation', function($app) {
            return new TranslationManager($app);
        });
    }

    public function boot()
    {
        ($this->app->make(DetectionStrategyStore::class))->registerFirst(BodyDetectionStrategy::class);
        ($this->app->make(DetectionStrategyStore::class))->register(CookieDetectionStrategy::class);
        ($this->app->make(DetectionStrategyStore::class))->registerLast(HeaderDetectionStrategy::class);

        Route::post('/_translate', [TranslationController::class, 'translate'])->name('translator.translate');

        app(TranslationFactory::class)->intercept(CacheInterceptor::class);
        app(TranslationFactory::class)->intercept(DatabaseInterceptor::class);
    }

}