# Laravel nova shortcode based on "nova-flexible-content"

![Packagist License](https://img.shields.io/packagist/l/think.studio/nova-flexible-content-field-shortcode?color=%234dc71f)
[![Packagist Version](https://img.shields.io/packagist/v/think.studio/nova-flexible-content-field-shortcode)](https://packagist.org/packages/think.studio/nova-flexible-content-field-shortcode)
[![Total Downloads](https://img.shields.io/packagist/dt/think.studio/nova-flexible-content-field-shortcode)](https://packagist.org/packages/think.studio/nova-flexible-content-field-shortcode)
[![Build Status](https://scrutinizer-ci.com/g/dev-think-one/nova-flexible-content-field-shortcode/badges/build.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/nova-flexible-content-field-shortcode/build-status/main)
[![Code Coverage](https://scrutinizer-ci.com/g/dev-think-one/nova-flexible-content-field-shortcode/badges/coverage.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/nova-flexible-content-field-shortcode/?branch=main)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/dev-think-one/nova-flexible-content-field-shortcode/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/dev-think-one/nova-flexible-content-field-shortcode/?branch=main)

A very highly targeted package. Designed specifically for the ability to add shortcodes to existing content. If you are
just starting to develop an application then just use `think.studio/nova-flexible-content` or alternative without using
this package. The package is needed if you already have a large amount of content, and the client requires adding new
functionality

| Nova | Package |
|------|---------|
| V1   | V1 V2   |
| V4   | V3      |

## Installation

You can install the package via composer:

1. Install "flexible content" package.

```bash
composer require think.studio/nova-flexible-content
```

2. Install "shortcode" package

```bash
composer require think.studio/nova-flexible-content-field-shortcode
# optional publish configs
php artisan vendor:publish --provider="ThinkOne\NovaFlexibleContentFieldShortcode\ServiceProvider" --tag="config"
```

## Usage

### Admin

`\ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeText` field. You need add it to **top level** layouts in you flexible content

```php
class ImageLayout extends \NovaFlexibleContent\Layouts\Layout
{
    public function fields(): array
    {
        return [
            \ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeText::make('Shortcode')
            ->help('All parameters you can find <a href="//some-link">here</a>'),
            NLFMImage::make('Image', 'image'),
            Text::make('Caption', 'caption'),
        ];
    }
}

class ImageLayout extends \NovaFlexibleContent\Layouts\Layout
{
    public function fields(): array
    {
        return [
           \ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeText::make('Shortcode'),
            NLFMImage::make('Image', 'image'),
            Text::make('Caption', 'caption'),
        ];
    }
}

class ImagesSliderLayout extends \NovaFlexibleContent\Layouts\Layout
{
    public function fields(): array
    {
        return [
            \ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeText::make('Shortcode'),
            \NovaFlexibleContent\Flexible::make('Slider', 'slider')
                    ->useLayout(ImageSlideLayout::class)
                    ->layoutsMenuButton('Add slide'),
        ];
    }
}

\NovaFlexibleContent\Flexible::make('Shortcodes', 'shortcodes')
    ->useLayout(ImageLayout::class)
    ->useLayout(ImagesSliderLayout::class)
    ->layoutsMenuButton('Add shortcode')
    ->hideWhenCreating(),
```

![](doc/assets/shortcode_example.gif)

### Html presenter

You need create "presenters" to display your shortcodes. Any presenter should implement
   interface `ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodePresenter` \
   Example:

```php
use ThinkOne\NovaFlexibleContentFieldShortcode\ViewPresenter;

class ImageWithCaption extends ViewPresenter
{
    protected string $viewPath = 'my-folder.shortcodes.image-with-caption';
}
```

```blade.php
# my-folder/shortcodes/image-with-caption.blade.php
@if(!empty($shortcodeData) && !empty($shortcodeData['image']))
    <div class="...">
        <div class="...">
            <img
                class="..."
                src="{{$shortcodeData['image']}}" alt=""/>
            @if(!empty($shortcodeData['caption']))
                <div class="...">
                    {{$shortcodeData['caption']}}
                </div>
            @endif
        </div>
    </div>
@endif
```

### Render example with trait

```php
class Article extends Model {

    use \ThinkOne\NovaFlexibleContentFieldShortcode\Eloquent\HasShortcodes;

    public function shortcodesMap(): array {
        return [ 'image' => ImageWithCaption::class, ];
    }

    public function getFullContentAttribute(): string {
        return $this->getDataWithShortcodes( WysiwygHelper::filter( (string) $this->content ) );
    }
    
    public function getFullContentOtherAttribute(): string {
        return $this->getDataWithShortcodes( WysiwygHelper::filter( (string) $this->content_other ) );
    }
}
```
Then call it:

```balde.php
{!! $article->full_content !!}
{!! $article->full_content_other !!}
```

### Raw render example

```php
class Post extends Model
{
    public function presentersMap(): array
    {
        return [
            'image'  => ImageWithCaption::class,
            'EYsCY62xKnkHrvIo'  => AdHocImageWithCaption::class,
            'slider' => ImagesSlider::class,
        ];
    }
    
    public function shortcodesData(): array
    {
        $data = null;
        if ($this->shortcodes && is_string($this->shortcodes)) {
            $data = json_decode($this->shortcodes, true);
        }

        return is_array($data) ? $data : [];
    }
    
    public function postContent(): ?string
    {
        return \ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeCompiler::make(
            $this->shortcodesData(), // array represent "nova-flexible-content" field
            $this->presentersMap() // array represent presenters map (key => class), see above
        )->renderShortcodes(
          $this->content // text containing shortcode, maybe you need to filter it to prevent xss
        );
    }
}
```

## Credits

- [![Think Studio](https://yaroslawww.github.io/images/sponsors/packages/logo-think-studio.png)](https://think.studio/)
