<?php


namespace ThinkOne\NovaFlexibleContentFieldShortcode;

use Illuminate\Support\Str;

class ShortcodeCompiler
{
    protected string $keyName;

    protected array $shortcodeData;

    protected array $presentersMap;

    /**
     * ShortcodeCompiler constructor.
     *
     * @param array $shortcodeData
     * @param array $shortcodeMap
     * @param string $keyName
     */
    public function __construct(array $shortcodeData = [], array $presentersMap = [], ?string $keyName = null)
    {
        $this->setKeyName($keyName ?? config('nfc-shortcode.key'));
        $this->shortcodeData = $shortcodeData;

        $this->presentersMap = array_merge(
            config('nfc-shortcode.presenters'),
            $presentersMap
        );
    }

    public static function make(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * @param string $keyName
     *
     * @return ShortcodeCompiler
     */
    public function setKeyName(string $keyName): self
    {
        $this->keyName = $keyName;

        return $this;
    }

    protected function regex()
    {
        return '\[\s*' . $this->keyName . '\s*=\s*[\'"]([a-zA-z0-9]*)[\'"].*\]';
    }

    public function renderShortcodes($value)
    {
        $pattern = $this->regex();
        preg_match_all("/{$pattern}/mU", $value, $matches);
        if ($matches && !empty($matches[0])) {
            foreach ($matches[0] as $i => $shortcode) {
                $value = Str::replaceFirst($shortcode, $this->render($matches[0][ $i ], $matches[1][ $i ]), $value);
            }
        }

        return $value;
    }

    /**
     * @throws ShortcodeException
     */
    protected function render($shortcode, $key): string
    {
        $data          = collect($this->shortcodeData);
        $shortcodeData = $data->firstWhere('key', $key);
        if (!$shortcodeData) {
            return '';
        }

        $presenter = $this->findPresenter($shortcodeData['layout'], $key);
        if (!$presenter) {
            return '';
        }

        /** @var ShortcodePresenter $presenter */
        $presenter = new $presenter();
        if (!($presenter instanceof ShortcodePresenter)) {
            throw new ShortcodeException('presenter should implement ShortcodePresenter');
        }

        return $presenter->render($key, $shortcodeData['attributes'], $this->parseAttributes($shortcode));
    }

    /**
     * Find Presenter
     *
     * @param string $slug
     * @param string $key
     *
     * @return string|null
     */
    protected function findPresenter(string $slug, string $key): ?string
    {
        if (!empty($this->presentersMap[ $key ])) {
            return $this->presentersMap[ $key ];
        }
        if (!empty($this->presentersMap[ $slug ])) {
            return $this->presentersMap[ $slug ];
        }

        return null;
    }

    /**
     * Parse the shortcode attributes
     *
     * @return array
     */
    protected function parseAttributes($text)
    {
        $text = trim($text, '[]');
        // decode attribute values
        $text = htmlspecialchars_decode($text, ENT_QUOTES);

        $attributes = [];
        // attributes pattern
        $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
        // Match
        if (preg_match_all($pattern, preg_replace('/[\x{00a0}\x{200b}]+/u', ' ', $text), $match, PREG_SET_ORDER)) {
            foreach ($match as $m) {
                if (!empty($m[1])) {
                    $attributes[ strtolower($m[1]) ] = stripcslashes($m[2]);
                } elseif (!empty($m[3])) {
                    $attributes[ strtolower($m[3]) ] = stripcslashes($m[4]);
                } elseif (!empty($m[5])) {
                    $attributes[ strtolower($m[5]) ] = stripcslashes($m[6]);
                } elseif (isset($m[7]) && strlen($m[7])) {
                    $attributes[] = stripcslashes($m[7]);
                } elseif (isset($m[8])) {
                    $attributes[] = stripcslashes($m[8]);
                }
            }
        } else {
            $attributes = ltrim($text);
        }

        $attributes = is_array($attributes) ? $attributes : [ $attributes ];
        if (isset($attributes[ $this->keyName ])) {
            unset($attributes[ $this->keyName ]);
        }

        return $attributes;
    }
}
