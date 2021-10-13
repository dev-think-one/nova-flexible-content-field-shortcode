<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use ThinkOne\NovaFlexibleContentFieldShortcode\Eloquent\HasShortcodes;
use ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Presenters\ImageWithCaption;

class Post extends Model
{
    use HasShortcodes;

    protected $table = 'posts';

    protected $guarded = [];

    public function shortcodesMap(): array
    {
        return [ 'image' => ImageWithCaption::class, ];
    }

    public function getFullContentAttribute(): string
    {
        return $this->getDataWithShortcodes((string) $this->content);
    }

    public function getFullContentBottomAttribute(): string
    {
        return $this->getDataWithShortcodes((string) $this->content_bottom);
    }

    public static function newWithShotrcode()
    {
        return static::create([
            'content'        => '<p>Lorem ipsum dolor </p><p>[key="BpSZT23l76uN8Mq9"]</p><p>Suspendisse iaculis purus sed</p>',
            'content_bottom' => '<p>Lorem ipsum</p><p>[key="BpSZT23l76uN8Mq9"]</p><p>Suspendisse sed</p><p>[key="BpSZT23l76uN8Mq9"]</p><p>iaculis purus</p>',
            'shortcodes'     => '[{"layout":"image","key":"BpSZT23l76uN8Mq9","attributes":{"image":"\/img\/logo-red-text.png","caption":"data caption"}}]',
        ]);
    }
}
