<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Tests;

use Laravel\Nova\Http\Requests\NovaRequest;
use ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeText;
use ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models\Post;

class ShortcodeTextFieldTest extends TestCase
{
    /** @test */
    public function returns_correct_component_name()
    {
        $field = ShortcodeText::make('Field');

        $this->assertEquals('shortcode-text', $field->component());
    }

    /** @test */
    public function field_not_fillable()
    {
        $field = ShortcodeText::make('Field');

        $model = new Post();
        $field->fill(app(NovaRequest::class), $model);

        $this->assertNull($model->field);
    }

    /** @test */
    public function has_default_shortcode_key_name()
    {
        $field = ShortcodeText::make('Field');
        $meta  = $field->meta();

        $this->assertEquals('key', $meta['shortcodeKeyName']);
    }

    /** @test */
    public function change_shortcode_key_name()
    {
        $field = ShortcodeText::make('Field');
        $field->shortcodeKeyName('fooBar');

        $meta = $field->meta();

        $this->assertEquals('fooBar', $meta['shortcodeKeyName']);
    }
}
