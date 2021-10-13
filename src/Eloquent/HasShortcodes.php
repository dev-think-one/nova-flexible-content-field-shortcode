<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode\Eloquent;

use ThinkOne\NovaFlexibleContentFieldShortcode\ShortcodeCompiler;

trait HasShortcodes
{

    /**
     * Field name.
     *
     * @return string
     */
    public function shortcodesKey(): string
    {
        if (property_exists($this, 'shortcodesKey')) {
            return $this->shortcodesKey;
        }

        return 'shortcodes';
    }

    /**
     * Shortcodes map.
     *
     * @return array
     */
    public function shortcodesMap(): array
    {
        return [
            // 'image' => ImageWithCaption::class,
        ];
    }

    /**
     * Restore shortcode data.
     *
     * @return array
     */
    public function shortcodesData(): array
    {
        $data = null;
        if (($shortcodes = $this->{$this->shortcodesKey()}) && is_string($shortcodes)) {
            $data = json_decode($shortcodes, true);
        }

        return is_array($data) ? $data : [];
    }

    /**
     * Add shortcodes to content.
     *
     * @param string $data
     *
     * @return string
     */
    public function getDataWithShortcodes(string $data = ''): string
    {
        return ShortcodeCompiler::make(
            $this->shortcodesData(),
            $this->shortcodesMap()
        )->renderShortcodes($data);
    }
}
