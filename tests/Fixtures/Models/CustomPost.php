<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use ThinkOne\NovaFlexibleContentFieldShortcode\Eloquent\HasShortcodes;

class CustomPost extends Model
{
    use HasShortcodes;

    protected string $shortcodesKey = 'shorts';

    protected $table = 'posts';

    protected $guarded = [];


}
