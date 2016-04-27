<?php

namespace Atrox;

/**
 * Class Haikunator
 *
 * @package Atrox
 */
class Haikunator
{
    /**
     * @var array Adjectives used by Haikunator
     */
    public static $ADJECTIVES = [
        "aged", "ancient", "autumn", "billowing", "bitter", "black", "blue", "bold",
        "broad", "broken", "calm", "cold", "cool", "crimson", "curly", "damp",
        "dark", "dawn", "delicate", "divine", "dry", "empty", "falling", "fancy",
        "flat", "floral", "fragrant", "frosty", "gentle", "green", "hidden", "holy",
        "icy", "jolly", "late", "lingering", "little", "lively", "long", "lucky",
        "misty", "morning", "muddy", "mute", "nameless", "noisy", "odd", "old",
        "orange", "patient", "plain", "polished", "proud", "purple", "quiet", "rapid",
        "raspy", "red", "restless", "rough", "round", "royal", "shiny", "shrill",
        "shy", "silent", "small", "snowy", "soft", "solitary", "sparkling", "spring",
        "square", "steep", "still", "summer", "super", "sweet", "throbbing", "tight",
        "tiny", "twilight", "wandering", "weathered", "white", "wild", "winter", "wispy",
        "withered", "yellow", "young",
    ];

    /**
     * @var array Nouns used by Haikunator
     */
    public static $NOUNS = [
        "art", "band", "bar", "base", "bird", "block", "boat", "bonus",
        "bread", "breeze", "brook", "bush", "butterfly", "cake", "cell", "cherry",
        "cloud", "credit", "darkness", "dawn", "dew", "disk", "dream", "dust",
        "feather", "field", "fire", "firefly", "flower", "fog", "forest", "frog",
        "frost", "glade", "glitter", "grass", "hall", "hat", "haze", "heart",
        "hill", "king", "lab", "lake", "leaf", "limit", "math", "meadow",
        "mode", "moon", "morning", "mountain", "mouse", "mud", "night", "paper",
        "pine", "poetry", "pond", "queen", "rain", "recipe", "resonance", "rice",
        "river", "salad", "scene", "sea", "shadow", "shape", "silence", "sky",
        "smoke", "snow", "snowflake", "sound", "star", "sun", "sun", "sunset",
        "surf", "term", "thunder", "tooth", "tree", "truth", "union", "unit",
        "violet", "voice", "water", "water", "waterfall", "wave", "wildflower", "wind",
        "wood",
    ];

    /**
     * @param array $params
     *
     * @return string
     */
    public function __invoke(array $params = [])
    {
        return static::haikunate($params);
    }

    /**
     * Generate Heroku-like random names to use in your applications.
     *
     * @param array $params Array containing the optinal parameters.
     * @return string
     */
    public static function haikunate(array $params = [])
    {
        $defaults = [
            "delimiter"   => "-",
            "tokenLength" => 4,
            "tokenHex"    => false,
            "tokenChars"  => "0123456789",
        ];

        $params = array_merge($defaults, $params);

        if ($params["tokenHex"] == true) {
            $params["tokenChars"] = "0123456789abcdef";
        }

        $adjective = self::$ADJECTIVES[mt_rand(0, count(self::$ADJECTIVES) - 1)];
        $noun = self::$NOUNS[mt_rand(0, count(self::$NOUNS) - 1)];
        $token = "";

        for ($i = 0; $i < $params["tokenLength"]; $i++) {
            $token .= $params["tokenChars"][mt_rand(0, strlen($params["tokenChars"]) - 1)];
        }

        $sections = [$adjective, $noun, $token];
        return implode($params["delimiter"], array_filter($sections));
    }
}
