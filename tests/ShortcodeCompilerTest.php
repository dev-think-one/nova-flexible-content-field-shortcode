<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Tests;

use ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeCompiler;
use ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeException;
use ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models\Post;

class ShortcodeCompilerTest extends TestCase
{
    /** @test */
    public function empty_data_return_empty_string()
    {
        $compiler = ShortcodeCompiler::make();

        $this->assertEmpty($compiler->renderShortcodes('[key="foo"]'));
        $this->assertEquals('', $compiler->renderShortcodes('[key="foo"]'));
    }

    /** @test */
    public function empty_presenter_return_empty_string()
    {
        $compiler = ShortcodeCompiler::make([
            [
                'layout' => 'Example',
                'key'    => 'foo',
            ],
        ]);

        $this->assertEmpty($compiler->renderShortcodes('[key="foo"]'));
        $this->assertEquals('', $compiler->renderShortcodes('[key="foo"]'));
    }

    /** @test */
    public function throw_exception_if_presenter_not_extends_baseclass()
    {
        $compiler = ShortcodeCompiler::make([
            [
                'layout' => 'baz',
                'key'    => 'foo',
            ],
        ], [
            'baz' => Post::class,
        ]);

        $this->expectException(ShortcodeException::class);
        $compiler->renderShortcodes('[key="foo"]');
    }

    /** @test */
    public function find_presenter_by_slug()
    {
        $compiler = ShortcodeCompiler::make([
            [
                'layout' => 'qux',
                'key'    => 'bar',
            ],
        ], [
            'bar' => Post::class,
        ]);

        $this->expectException(ShortcodeException::class);
        $compiler->renderShortcodes('[key="bar"]');
    }
}
