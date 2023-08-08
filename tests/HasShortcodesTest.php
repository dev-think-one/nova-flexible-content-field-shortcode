<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Tests;

use ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models\CustomPost;
use ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models\Post;
use ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models\PostWithNoViewPresenter;

class HasShortcodesTest extends TestCase
{

    /** @test */
    public function correct_process_shorcodes()
    {
        $post = Post::newWithShotrcode();

        $this->assertStringContainsString('[key="BpSZT23l76uN8Mq9"]', $post->content_bottom);
        $this->assertStringContainsString('[key="BpSZT23l76uN8Mq9"]', $post->content);

        $this->assertStringNotContainsString('[key="BpSZT23l76uN8Mq9"]', $post->full_content);
        $this->assertStringContainsString('image-with-caption__img', $post->full_content);
        $this->assertEquals(1, substr_count($post->full_content, 'image-with-caption__img'));
        $this->assertStringContainsString('image-with-caption__caption', $post->full_content);
        $this->assertEquals(1, substr_count($post->full_content, 'image-with-caption__caption'));

        $this->assertStringNotContainsString('[key="BpSZT23l76uN8Mq9"]', $post->full_content_bottom);
        $this->assertStringContainsString('image-with-caption__img', $post->full_content_bottom);
        $this->assertEquals(2, substr_count($post->full_content_bottom, 'image-with-caption__img'));
        $this->assertStringContainsString('image-with-caption__caption', $post->full_content_bottom);
        $this->assertEquals(2, substr_count($post->full_content_bottom, 'image-with-caption__caption'));
    }

    /** @test */
    public function view_name_autogenerates()
    {
        $post = PostWithNoViewPresenter::newWithShotrcode();

        $this->assertStringContainsString('[key="BpSZT23l76uN8Mq9"]', $post->content_bottom);
        $this->assertStringContainsString('[key="BpSZT23l76uN8Mq9"]', $post->content);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('View [shortcodes.image-no-view-presenter] not found.');

        // Trigger to throw error
        $post->full_content;
    }

    /** @test */
    public function shortcode_field_can_be_override()
    {
        $model = new CustomPost();

        $this->assertEquals('shorts', $model->shortcodesKey());

        $this->assertIsArray($model->shortcodesMap());
        $this->assertEmpty($model->shortcodesMap());
    }
}
