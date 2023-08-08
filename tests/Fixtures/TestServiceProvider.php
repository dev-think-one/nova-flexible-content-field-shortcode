<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures;

class TestServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'tests-shortcodes');
    }
}
