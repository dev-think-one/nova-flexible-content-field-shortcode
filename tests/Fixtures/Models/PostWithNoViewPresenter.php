<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models;

use ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Presenters\ImageNoViewPresenter;

class PostWithNoViewPresenter extends Post
{
    public function shortcodesMap(): array
    {
        return [ 'image' => ImageNoViewPresenter::class, ];
    }
}
