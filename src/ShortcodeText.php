<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class ShortcodeText extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'shortcode-text';

    public function shortcodeKeyName(string $value)
    {
        $this->withMeta([
            'shortcodeKeyName' => $value,
        ]);

        return $this;
    }

    public function meta()
    {
        $meta = $this->meta;
        if (empty($meta['shortcodeKeyName'])) {
            $meta['shortcodeKeyName'] = config('nfc-shortcode.key');
        }

        return $meta;
    }

    /**
     * @param NovaRequest $request
     * @param object $model
     *
     * @return mixed|void
     */
    public function fill(NovaRequest $request, $model)
    {
        // nothing
    }
}
