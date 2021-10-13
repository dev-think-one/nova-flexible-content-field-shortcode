<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

abstract class ViewPresenter implements ShortcodePresenter
{
    protected string $viewPath = '';

    protected array $viewParams = [];

    public function render(string $key, array $attributes = [], array $options = []): string
    {
        return View::make(
            $this->viewPath($key, $attributes, $options),
            $this->viewParams($key, $attributes, $options),
        )->render();
    }

    public function viewPath(string $key, array $attributes = [], array $options = []): string
    {
        if (!$this->viewPath) {
            return 'shortcodes.' . Str::kebab(class_basename(get_called_class()));
        }

        return $this->viewPath;
    }

    public function viewParams(string $key, array $attributes = [], array $options = []): array
    {
        return [
            'shortcodeData' => array_merge(
                $this->viewParams,
                $options,
                $attributes,
            ),
        ];
    }
}
