<?php

namespace Atrox\Haikunator;

class Haikunator
{
    private static $ADJECTIVES = [
        "autumn", "hidden", "bitter", "misty", "silent", "empty", "dry", "dark",
        "summer", "icy", "delicate", "quiet", "white", "cool", "spring", "winter",
        "patient", "twilight", "dawn", "crimson", "wispy", "weathered", "blue",
        "billowing", "broken", "cold", "damp", "falling", "frosty", "green",
        "long", "late", "lingering", "bold", "little", "morning", "muddy", "old",
        "red", "rough", "still", "small", "sparkling", "throbbing", "shy",
        "wandering", "withered", "wild", "black", "young", "holy", "solitary",
        "fragrant", "aged", "snowy", "proud", "floral", "restless", "divine",
        "polished", "ancient", "purple", "lively", "nameless", "lucky", "odd", "tiny",
        "free", "dry", "yellow", "orange", "gentle", "tight", "super", "royal", "broad",
        "steep", "flat", "square", "round", "mute", "noisy", "hushy", "raspy", "soft",
        "shrill", "rapid", "sweet", "curly", "calm", "jolly", "fancy", "plain", "shinny"
    ];

    private static $NOUNS = [
        "waterfall", "river", "breeze", "moon", "rain", "wind", "sea", "morning",
        "snow", "lake", "sunset", "pine", "shadow", "leaf", "dawn", "glitter",
        "forest", "hill", "cloud", "meadow", "sun", "glade", "bird", "brook",
        "butterfly", "bush", "dew", "dust", "field", "fire", "flower", "firefly",
        "feather", "grass", "haze", "mountain", "night", "pond", "darkness",
        "snowflake", "silence", "sound", "sky", "shape", "surf", "thunder",
        "violet", "water", "wildflower", "wave", "water", "resonance", "sun",
        "wood", "dream", "cherry", "tree", "fog", "frost", "voice", "paper",
        "frog", "smoke", "star", "atom", "band", "bar", "base", "block", "boat",
        "term", "credit", "art", "fashion", "truth", "disk", "math", "unit", "cell",
        "scene", "heart", "recipe", "union", "limit", "bread", "toast", "bonus",
        "lab", "mud", "mode", "poetry", "tooth", "hall", "king", "queen", "lion", "tiger",
        "penguin", "kiwi", "cake", "mouse", "rice", "coke", "hola", "salad", "hat"
    ];

    /**
     * Generate Heroku-like random names to use in your applications.
     * @param array $params
     * @return string
     */
    public static function haikunate(array $params = array())
    {
        $defaults = [
            "delimiter" => "-",
            "tokenLength" => 4,
            "tokenHex" => false,
            "tokenChars" => "0123456789",
        ];

        $params = array_merge($defaults, $params);

        if ($params["tokenHex"] == true) $params["tokenChars"] = "0123456789abcdef";

        $adjective = self::$ADJECTIVES[mt_rand(0, count(self::$ADJECTIVES) - 1)];
        $noun = self::$NOUNS[mt_rand(0, count(self::$NOUNS) - 1)];
        $token = "";

        for($i = 0; $i <= $params["tokenLength"] - 1; $i++)
        {
            $token .= $params["tokenChars"][mt_rand(0, strlen($params["tokenChars"])-1)];
        }

        $sections = [$adjective, $noun, $token];
        return implode($params["delimiter"], array_filter($sections));
    }
}