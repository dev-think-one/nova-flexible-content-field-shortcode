<?php


namespace ThinkOne\NovaFlexibleContentFieldShortcode;

interface ShortcodePresenter
{

    /**
     * Render shortcode
     * @param string $key
     * @param array $attributes
     * @param array $options
     *
     * @return string
     */
    public function render(string $key, array $attributes = [], array $options = []): string;
}
